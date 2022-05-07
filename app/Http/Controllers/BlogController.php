<?php

namespace App\Http\Controllers;

use App\Base\Http\Controller\MyBaseController;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;

class BlogController extends MyBaseController
{
    public function __construct()
    {
        parent::__construct(Blog::query()->with(['creator']));

        $this->baseResource = new BlogResource;
    }

    public function setRequest(): void
    {
        $this->createRequest = app()->make(CreateBlogRequest::class);
        $this->updateRequest = app()->make(UpdateBlogRequest::class);
    }
}
