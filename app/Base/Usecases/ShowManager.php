<?php

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowManager
{
    public function __invoke(string $id, Builder $model, BaseResource $baseResource): JsonResource
    {
        return new $baseResource($model->findOrFail($id));
    }
}
