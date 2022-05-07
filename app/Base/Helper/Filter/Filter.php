<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

trait Filter
{
    /**
     * Filter Production
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function filterData(Builder $builder, Request $request)
    {
        $this->setFilterQueries($request);

        $filterQueries = $this->filterQueries ?? [];

        $builder = app(Pipeline::class)
            ->send($builder)
            ->through($filterQueries)
            ->thenReturn();

        return $builder->orderBy('id', 'DESC');
    }

    /**
     * Paginate data
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(Builder $query, Request $request)
    {
        return $query->paginate($request->perPage ?? config('app.pagination'));
    }

    /**
     * Get filtered data with or without pagination
     *
     * @param Builder $query
     * @param Request $request
     * @return LengthAwarePaginator|Collection
     */
    public function getFilteredData(Builder $query, Request $request)
    {
        if ($this->withOutPagination($request)) {
            return $query->get();
        }

        return $this->paginate($query, $request);
    }

    public function paginateCollection(Collection $items, Request $request)
    {
        if ($this->withOutPagination($request)) {
            return $items;
        }

        $page = $request->page ?: (Paginator::resolveCurrentPage() ?: 1);

        $perPage = $request->perPage ?? 10;

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            []
        );
    }

    /**
     * Check need to paginate or no
     *
     * @param Request $request
     * @return bool
     */
    public function withOutPagination(Request $request)
    {
        return $request->type && ($request->type === 'list');
    }

    public function skipTakeData(Request $request, Builder $builder)
    {
        $page = $request->page ?? 1;

        $perPage = $request->perPage ?? 10;

        return $builder
            ->skip(($page - 1) * $perPage)
            ->take($perPage);
    }

    /**
     * Set filter query
     *
     * @param Request $request
     * @return void
     */
    public function setFilterQueries(Request $request): void
    {
        $this->filterQueries = [];
    }
}
