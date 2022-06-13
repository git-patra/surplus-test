<?php

namespace App\Http\Usecases\Images;

use App\Base\Usecases\DeleteManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DeleteImageManager extends DeleteManager
{
    /**
     * Function Logic After Delete Data
     *
     * @return void
     */
    public function afterProcess(Model $oldData): void
    {
        if (Storage::disk('public')->exists($oldData->file)) {
            Storage::disk('public')->delete($oldData->file);
        }
    }
}
