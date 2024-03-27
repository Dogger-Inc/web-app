<?php

namespace App\Providers;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Add a whereHasRecursive method to the Builder class
         * Use this method to recursively search through relations
         * (warning: this can lead to performance issues if used abusively)
         * 
         * @param array $relations
         * @param \Closure $callback
         * 
         * @return Builder
         */
        Builder::macro('whereHasRecursive', function($relations, $callback) {
            if (count($relations) > 1) {
                $relation = array_shift($relations);
        
                return $this->whereHas($relation, function ($query) use ($relations, $callback) {
                    $query->whereHasRecursive($relations, $callback);
                });
            } else {
                return $this->whereHas(array_shift($relations), $callback);
            }
        });

        /**
         * Add a orderByMany method to the Builder class
         * Use this method to order the given model by multiple columns
         * 
         * @param array $orderByArray
         * 
         * @return Builder
         */
        Builder::macro('orderByMany', function(array $orderByArray) {
            foreach ($orderByArray as &$orderBy) {
                $this->orderBy($orderBy[0], $orderBy[1]);
            }

            return $this;
        });

        /**
         * Add a autoSearch method to the Builder class
         * Use this method to automatically search the given model from the request
         * 
         * @param string $searchByFallback
         * 
         * @return Builder
         */
        Builder::macro('autoSearch', function(string $searchByFallback) {
            $data = request()->validate([
                'search' => ['nullable', 'string', 'max:255'],
                'searchBy' => ['nullable', 'string', 'max:255']
            ]);

            if (!array_key_exists('search', $data)) return $this;
            if (!array_key_exists('searchBy', $data)) $data['searchBy'] = $searchByFallback;

            // Check if the searchBy field contains a dot, indicating a relation
            if (strpos($data['searchBy'], '.') !== false) {
                $relations = explode('.', $data['searchBy']);
                $attribute = array_pop($relations);

                if (count($relations) >= 3) return $this;

                return $this->whereHasRecursive($relations, function ($query) use ($attribute, $data) {
                    $query->where($attribute, 'LIKE', '%' . $data['search'] . '%');
                });
            } else {
                // If no relation, just search the attribute
                return $this->where($data['searchBy'], 'LIKE', '%' . $data['search'] . '%');
            }
        });

        /**
         * Add a autoOrder method to the Builder class
         * Use this method to automatically order the given model from the request
         * 
         * @param string $orderOn (optional)
         * @param string $defaultOrder (optional)
         * 
         * @return Builder
         */
        Builder::macro('autoOrder', function(string $orderOn = 'id', string $defaultOrder = 'DESC') {
            $data = request()->validate([
                'orderBy' => ['nullable', 'string', Rule::in(['ASC', 'DESC'])],
            ]);

            if (!array_key_exists('orderBy', $data)) $data['orderBy'] = $defaultOrder;

            return $this->orderBy($orderOn, $data['orderBy']);
        });

        /**
         * Add a autoPaginate method to the Builder class
         * Use this method to automatically paginate the given model from the request
         * This method also appends the query params from others macro to keep them during pagination
         * 
         * @param string $pageName (optional)
         * @param int $defaultPerPage (optional)
         * 
         * @return Builder
         */
        Builder::macro('autoPaginate', function(string $pageName = 'page', int $defaultPerPage = 9) {
            $data = request()->validate([
                'search' => ['nullable', 'string', 'max:255'],
                'searchBy' => ['nullable', 'string', 'max:255'],
                'orderBy' => ['nullable', 'string', Rule::in(['ASC', 'DESC'])],
                'perPage' => ['nullable', 'integer', 'min:5', 'max:100'],
            ]);

            if (!array_key_exists('perPage', $data)) $data['perPage'] = $defaultPerPage;

            return $this->paginate($data['perPage'], ['*'], $pageName)->appends($data);
        });
    }
}
