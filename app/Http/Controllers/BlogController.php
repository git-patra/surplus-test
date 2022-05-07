<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BlogController extends MyBaseController
{
    public function __construct()
    {
        parent::__construct(Blog::query());

        $this->createRequest = new CreateBlogRequest;
//        $this->updateRequest = new UpdateBlogRequest;

        $this->baseResource = new BlogResource;
    }
}
