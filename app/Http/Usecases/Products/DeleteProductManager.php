<?php

namespace App\Http\Usecases\Products;

use App\Base\Usecases\DeleteManager;
use Illuminate\Database\Eloquent\Model;

class DeleteProductManager extends DeleteManager
{
    /**
     * Function Logic Before Delete Data
     *
     * @return Model
     */
    public function afterProcess(Model $data): void
    {
        $data->categories()->detach();
        $data->images()->detach();
    }
}
