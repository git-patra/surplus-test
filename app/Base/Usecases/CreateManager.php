<?php

use App\Http\Requests\BaseRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateManager
{
    public BaseRequest $request;
    public Builder $builder;
    public BaseResource $baseResource;

    public function __invoke(BaseRequest $request, Builder $model, BaseResource $baseResource): Model
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
        $create = $this->builder->create([
            $this->request->getFillable()
        ]);

        return $create->fresh();
    }

    private function afterProcess(Model $data): Model
    {
        return new $this->baseResource($data);
    }
}
