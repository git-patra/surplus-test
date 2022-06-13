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

    /**
     * Process Create Data
     *
     * @param BaseRequest $request
     * @param Builder $model
     * @param string $id
     * @param BaseResource $baseResource
     * @return JsonResource
     */
    public function execute(BaseRequest $request, Builder $model, string $id, BaseResource $baseResource): JsonResource
    {
        $this->request = $request;
        $this->builder = $model;
        $this->id = $id;
        $this->baseResource = $baseResource;
        $this->oldData = $model->findOrFail($id);

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
        $update = $this->builder->findOrFail($this->id);

        $update->update(
            $this->request->getFillable()
        );

        return $update->fresh();
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
