<?php

use App\Http\Resources\BaseResource;
use App\Models\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexManager
{
    use Filter;

    public Request $request;
    public Builder $builder;

    public function __invoke(Request $request, Builder $model, BaseResource $baseResource): JsonResource
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
