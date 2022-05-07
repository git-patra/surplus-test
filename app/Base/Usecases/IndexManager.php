<?php

namespace App\Base\Usecases;

use App\Base\Helper\Filter\Filter;
use App\Base\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexManager
{
    use Filter;

    public Request $request;
    public Builder $builder;

    /**
     * Execute Function
     *
     * @param Request $request
     * @param Builder $model
     * @param BaseResource $baseResource
     * @return JsonResource
     */
    public function execute(Request $request, Builder $model, BaseResource $baseResource): JsonResource
    {
        $this->request = $request;
        $this->builder = $model;

        $this->beforeResponse();

        return $baseResource::collection($this->paginate($this->builder, $this->request));
    }

    /**
     * Filter Logic
     *
     * @return Builder
     */
    public function beforeResponse(): Builder
    {
        $this->manipulateRequest();
        $this->setFilterQueries($this->request);

        $this->builder = $this->filterData(
            $this->builder,
            $this->request
        );

        $this->skipTakeData($this->request, $this->builder);

        return $this->builder;
    }

    /**
     * Function for Manipulated Request
     *
     * @return void
     */
    public function manipulateRequest(): void
    {
        return;
    }
}
