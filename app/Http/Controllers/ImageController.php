<?php

namespace App\Http\Controllers;

use App\Base\Http\Controller\MyBaseController;
use App\Http\Requests\Image\CreateImageRequest;
use App\Http\Requests\Image\UpdateImageRequest;
use App\Models\Image;
use Illuminate\Contracts\Container\BindingResolutionException;

class ImageController extends MyBaseController
{
    public function __construct()
    {
        parent::__construct(Image::query());
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
