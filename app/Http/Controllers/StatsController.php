<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Cache;
use App\Traits\StatsTrait;
use App\Models\Project;
use Carbon\Carbon;

class StatsController extends Controller
{
    use StatsTrait;

    public function index(): Response
    {
        $stats = Cache::remember('homepage-stats', now()->addMinutes(30), function () {
            $user = auth()->user();
            $countsData = $this->getCardsData($user->companies);
            $chartData = $this->getChartData($user->companies);

            return [
                'cards' => $countsData,
                'chart' => $chartData,
            ];
        });

        return Inertia::render('Dashboard/Index', $stats);
    }

    public function clearCache()
    {
        Cache::forget('homepage-stats');
        return redirect()->back();
    }


    /**
     * Returns the data for the stats cards
     *
     * @param  \Illuminate\Database\Eloquent\Collection $companies
     * 
     * @return array
     */
    private function getCardsData($companies): array
    {
        $companiesCount = count($companies);
        $projectsCount = $companies->map(function ($company) {
            return $company->projects()->count();
        })->sum();
        $issuesCount = $companies->map(function ($company) {
            return $company->projects()->withCount('issues')->get()->sum('issues_count');
        })->sum();
        $issuesCount24 = $companies->map(function ($company) {
            return $company->projects()->withCount(['issues' => function ($query) {
                $query->whereBetween('triggered_at', [now()->subDays(1), now()]);
            }])->get()->sum('issues_count');
        })->sum();

        return [
            'companies' => $companiesCount,
            'projects' => $projectsCount,
            'issues' => $issuesCount,
            'issues24' => [
                'count' => $issuesCount24,
                'percentage' => $this->calculatePercentage($issuesCount24, $issuesCount),
            ],
        ];
    }

    /**
     * Returns the data for the chart
     *
     * @param \Illuminate\Database\Eloquent\Collection $companies
     *
     * @return array
     */
    private function getChartData($companies): array
    {
        // Prepare the result structure
        $result = [
            "total" => [],
            "companies" => [],
        ];

        // Fetch projects with issues and companies eagerly loaded
        $projects = Project::with([
            'company', 
            'issues' => function ($query) {
                $query->whereBetween('triggered_at', [now()->subDays(6), now()])
                    ->orderBy('triggered_at', 'asc');
            }
        ])->whereIn('company_id', $companies->pluck('id')->toArray())->get();

        foreach ($projects as $project) {
            $issues = $project->issues->groupBy(function ($issue) {
                return Carbon::parse($issue->triggered_at)->format('d-m-Y');
            })->map->count()->toArray();

            // Aggregate project issues into total
            foreach ($issues as $date => $count) {
                $result["total"][$date] = ($result["total"][$date] ?? 0) + $count;
            }

            // Aggregate project issues into companies
            $companyId = $project->company->id;
            $result["companies"][$companyId]['name'] = $project->company->name;
            $result["companies"][$companyId]['projects'][$project->name] = $issues;
        }

        // Add missing days
        $dateRange = $this->generateDateRange(7);
        $result["total"] = $this->addMissingDays(['total' => $result["total"]], 'total', $dateRange)["total"];

        foreach ($result['companies'] as &$companyIssue) {
            foreach ($companyIssue['projects'] as &$projectIssue) {
                $projectIssue = $this->addMissingDays(['issues' => $projectIssue], 'issues', $dateRange)["issues"];
            }
        }

        return $result;
    }
}
