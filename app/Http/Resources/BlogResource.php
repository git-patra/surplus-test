<?php

namespace App\Http\Resources;

use app\Base\Resources\BaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends BaseResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
