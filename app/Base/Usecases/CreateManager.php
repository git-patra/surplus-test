<?php

namespace App\Base\Usecases;

use App\Base\Requests\BaseRequest;
use App\Base\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateManager
{
    public BaseRequest $request;
    public Builder $builder;
    public BaseResource $baseResource;

    public function execute(BaseRequest $request, Builder $model, BaseResource $baseResource): JsonResource
    {
        $this->request = $request;
        $this->builder = $model;
        $this->baseResource = $baseResource;

        $this->beforeProcess();

        $new_data = $this->process();

        return $this->afterProcess($new_data);
    }

    private function beforeProcess(): void
    {
        return;
    }

    private function process(): Model|Builder|null
    {
        $create = $this->builder->create(
            $this->request->getFillable()
        );

        return $create->fresh();
    }

    private function afterProcess(Model $data): JsonResource
    {
        return new $this->baseResource($data);
    }
}
