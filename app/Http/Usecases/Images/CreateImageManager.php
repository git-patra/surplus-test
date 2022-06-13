<?php

namespace App\Http\Usecases\Images;

use App\Base\Usecases\CreateManager;

class CreateImageManager extends CreateManager
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
}
