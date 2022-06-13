<?php

namespace App\Http\Controllers;

use App\Base\Http\Controller\MyBaseController;
use App\Http\Requests\Image\CreateImageRequest;
use App\Http\Requests\Image\UpdateImageRequest;
use App\Http\Usecases\Images\CreateImageManager;
use App\Http\Usecases\Images\DeleteImageManager;
use App\Http\Usecases\Images\UpdateImageManager;
use App\Models\Image;
use Illuminate\Contracts\Container\BindingResolutionException;

class ImageController extends MyBaseController
{
    public function __construct()
    {
        parent::__construct(Image::query());

        $this->createManager = new CreateImageManager();
        $this->updateManager = new UpdateImageManager();
        $this->deleteManager = new DeleteImageManager();
    }

    /**
     * Set Request Rule for Validation Create and Updated
     * @return void
     * @throws BindingResolutionException
     */
    public function setCreateRequest(): void
    {
        $this->createRequest = app()->make(CreateImageRequest::class);
    }

    /**
     * Set Request Rule for Validation Create and Updated
     * @return void
     * @throws BindingResolutionException
     */
    public function setUpdateRequest(): void
    {
        $this->updateRequest = app()->make(UpdateImageRequest::class);
    }
}
