<?php

namespace App\Services;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class QueryService
{
    /**
     * Return the query filtered by the given params
     * searchBy param is the fallback value if no searchBy param is given in the request
     *
     * @param  Builder  $q
     * @param  string  $searchBy
     * @return Builder
     */
    public function search(Builder $q, string $searchBy) : Builder
    {
        $data = request()->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'searchBy' => ['nullable', 'string', 'max:255']
        ]);

        if (!array_key_exists('searchBy', $data)) $data['searchBy'] = $searchBy;
        if (!array_key_exists('search', $data)) return $q;

        // Check if the searchBy field contains a dot, indicating a relation
        if (strpos($data['searchBy'], '.') !== false) {
            [$relation, $attribute] = explode('.', $data['searchBy']);

            return $q->whereHas($relation, function ($query) use ($attribute, $data) {
                $query->where($attribute, 'LIKE', '%' . $data['search'] . '%');
            });
        } else {
            // If no relation, just search the attribute
            return $q->where($data['searchBy'], 'LIKE', '%' . $data['search'] . '%');
        }
    }

    /**
     * Return the query ordered by the given param
     *
     * @param  Builder  $q
     * @param  array  $orderByArray (optional)
     * @return Builder
     */
    public function order(Builder $q, array $orderByArray = []) : Builder
    {
        $data = request()->validate([
            'orderBy' => ['nullable', 'string', Rule::in(['ASC', 'DESC'])],
        ]);

        if (array_key_exists('orderBy', $data)) {
            $q = $q->orderBy('created_at', $data['orderBy']);
        }

        foreach ($orderByArray as &$orderBy) {
            $q = $q->orderBy($orderBy[0], $orderBy[1]);
        }

        return $q;
    }

    /**
     * Return the query paginated by the given param
     *
     * @param  Builder  $q
     * @param  int  $itemPerPage (optional)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(Builder $q, int $itemPerPage = 10) : \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $data = request()->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'searchBy' => ['nullable', 'string', 'max:255'],
            'orderBy' => ['nullable', 'string', Rule::in(['ASC', 'DESC'])],
        ]);

        $q = $q->paginate($itemPerPage);

        // Append the query params, this allows the search query to be preserved when navigating between pages.
        if (array_key_exists('search', $data)) {
            $q = $q->appends(['search' => $data['search']]);
        }
        if (array_key_exists('searchBy', $data)) {
            $q = $q->appends(['searchBy' => $data['searchBy']]);
        }
        if (array_key_exists('orderBy', $data)) {
            $q = $q->appends(['orderBy' => $data['orderBy']]);
        }

        return $q;
    }
}
