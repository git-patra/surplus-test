<?php

namespace App\Http\Controllers;

use App\Base\Http\Controller\MyBaseController;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Usecases\Products\CreateProductManager;
use App\Http\Usecases\Products\DeleteProductManager;
use App\Http\Usecases\Products\UpdateProductManager;
use App\Models\Product;
use Illuminate\Contracts\Container\BindingResolutionException;

class ProductController extends MyBaseController
{
    public function __construct()
    {
        parent::__construct(Product::query()->with('categories', 'images'));

        $this->createManager = new CreateProductManager();
        $this->updateManager = new UpdateProductManager();
        $this->deleteManager = new DeleteProductManager();
    }

    /**
     * Set Request Rule for Validation Create and Updated
     * @return void
     * @throws BindingResolutionException
     */
    public function setCreateRequest(): void
    {
        $this->createRequest = app()->make(CreateProductRequest::class);
    }

    /**
     * Set Request Rule for Validation Create and Updated
     * @return void
     * @throws BindingResolutionException
     */
    public function setUpdateRequest(): void
    {
        $this->updateRequest = app()->make(UpdateProductRequest::class);
    }
}
