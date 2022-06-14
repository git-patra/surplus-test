<?php

namespace App\Http\Helpers;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RemoveImageFromProduct
{
    public function storeNewImage($image): Model
    {
        $old_image = Image::query()->findOrFail($image['id']);

        if (Storage::disk('public')->exists($old_image->file)) {
            Storage::disk('public')->delete($old_image->file);
        }

        $image['file_image']->store('public');
        $image['file'] = $image['file_image']->hashName();
        $old_image->fill($image);
        $old_image->save();

        return $old_image->fresh();
    }
}
