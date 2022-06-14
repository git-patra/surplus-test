<?php

namespace App\Http\Usecases\Products;

use App\Base\Usecases\UpdateManager;
use App\Http\Helpers\RemoveImageFromProduct;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UpdateProductManager extends UpdateManager
{
    /**
     * Function Logic After Save Data
     *
     * @return JsonResource
     */
    public function afterProcess(Model $data): JsonResource
    {
        $new_product_images = collect($this->request->product_images)->map(function ($image) {
            if (! array_key_exists('id', $image) || ! $image['id']) {
                $image['file_image']->store('public');
                $image['file'] = $image['file_image']->hashName();
                $image = Image::query()->create($image);
            } else {
                $image = (new RemoveImageFromProduct())->storeNewImage($image);
            }

            return $image['id'];
        })->toArray();


        $data->categories()->detach();
        $data->images()->detach();
        $data->categories()->attach($this->request->categories);
        $data->images()->attach($new_product_images);
        $data->save();

        return new $this->baseResource($data->fresh());
    }
}
