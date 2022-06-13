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

    /**
     * Process Create Data
     *
     * @param BaseRequest $request
     * @param Builder $model
     * @param BaseResource $baseResource
     * @return JsonResource
     */
    public function execute(BaseRequest $request, Builder $model, BaseResource $baseResource): JsonResource
    {
        $this->request = $request;
        $this->builder = $model;
        $this->baseResource = $baseResource;

        $this->beforeProcess();

        $new_data = $this->process();

        return $this->afterProcess($new_data);
    }

    /**
     * Function Logic Before Save Data
     *
     * @return void
     */
    public function beforeProcess(): void
    {
        return;
    }

    /**
     * Save Data
     *
     * @return Model|Builder|null
     */
    private function process(): Model|Builder|null
    {
        $create = $this->builder->create(
            $this->request->getFillable()
        );

        return $create->fresh();
    }

    /**
     * Function Logic After Save Data
     *
     * @return JsonResource
     */
    public function afterProcess(Model $data): JsonResource
    {
        return new $this->baseResource($data);
    }
}
