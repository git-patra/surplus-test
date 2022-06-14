<?php

namespace App\Base\Usecases;

use App\Base\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowManager
{
    /**
     * Get Model Find One Response
     *
     * @param string $id
     * @param Builder $model
     * @param BaseResource $baseResource
     * @return JsonResource
     */
    public function execute(string $id, Builder $model, BaseResource $baseResource): JsonResource
    {
        return new $baseResource($model->findOrFail($id));
    }
}
