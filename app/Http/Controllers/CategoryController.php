<?php

namespace App\Http\Controllers;

use App\Base\Http\Controller\MyBaseController;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Container\BindingResolutionException;

class CategoryController extends MyBaseController
{
    public function __construct()
    {
        parent::__construct(Category::query());
    }

    /**
     * Set Request Rule for Validation Create and Updated
     * @return void
     * @throws BindingResolutionException
     */
    public function setCreateRequest(): void
    {
        $this->createRequest = app()->make(CreateCategoryRequest::class);
    }

    /**
     * Set Request Rule for Validation Create and Updated
     * @return void
     * @throws BindingResolutionException
     */
    public function setUpdateRequest(): void
    {
        $this->updateRequest = app()->make(UpdateCategoryRequest::class);
    }
}
