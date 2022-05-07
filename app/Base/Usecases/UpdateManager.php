<?php

namespace App\Base\Usecases;

use App\Base\Requests\BaseRequest;
use App\Base\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateManager
{
    public BaseRequest $request;
    public Builder $builder;
    public string $id;
    public BaseResource $baseResource;


    public function execute(BaseRequest $request, Builder $model, string $id, BaseResource $baseResource): JsonResource
    {
        $this->request = $request;
        $this->builder = $model;
        $this->id = $id;
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
        $update = $this->builder->findOrFail($this->id);

        $update->update(
            $this->request->getFillable()
        );

        return $update->fresh();
    }

    private function afterProcess(Model $data): JsonResource
    {
        return new $this->baseResource($data);
    }
}
