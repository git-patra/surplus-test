<?php

namespace App\Http\Usecases\Images;

use App\Base\Usecases\UpdateManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UpdateImageManager extends UpdateManager
{
    /**
     * Function Logic Before Save Data
     *
     * @return void
     */
    public function beforeProcess(): void
    {
        $this->request->file_image->store('public');

        $this->request['file'] = $this->request->file_image->hashName();
    }

    /**
     * Function Logic After Save Data
     *
     * @return JsonResource
     */
    public function afterProcess(Model $data): JsonResource
    {
        if (Storage::disk('public')->exists($this->oldData->file)) {
            Storage::disk('public')->delete($this->oldData->file);
        }

        return new $this->baseResource($data);
    }
}
