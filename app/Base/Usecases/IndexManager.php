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

    public function execute(Request $request, Builder $model, BaseResource $baseResource): JsonResource
    {
        $this->request = $request;
        $this->builder = $model;

        $this->beforeResponse();

        return $baseResource::collection($this->paginate($this->builder, $this->request));
    }

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

    public function manipulateRequest(): void
    {
        return;
    }
}
