<?php

namespace App\Http\Controllers;

use App\Base\Http\Controller\MyBaseController;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Contracts\Container\BindingResolutionException;

class BlogController extends MyBaseController
{
    public function __construct()
    {
        parent::__construct(Blog::query()->with(['creator']));
    }

    /**
     * Set Request Rule for Validation Create and Updated
     * @return void
     * @throws BindingResolutionException
     */
    public function setRequest(): void
    {
        $this->createRequest = app()->make(CreateBlogRequest::class);
        $this->updateRequest = app()->make(UpdateBlogRequest::class);
    }
}
