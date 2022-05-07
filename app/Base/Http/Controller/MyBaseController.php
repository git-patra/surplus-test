<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Resources\BaseResource;
use CreateManager;
use DeleteManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use IndexManager;
use ShowManager;
use UpdateManager;

class MyBaseController extends Controller
{
    public BaseRequest $createRequest;
    public BaseRequest $updateRequest;
    public BaseResource $baseResource;
    public Request $request;
    public Builder $builder;
    public IndexManager $indexManager;
    public ShowManager $showManager;
    public CreateManager $createManager;
    public UpdateManager $updateManager;
    public DeleteManager $deleteManager;

    public function __construct(
        Builder $model,
    )
    {
        $this->builder = $model;

        $this->request = new Request();
        $this->createRequest = new BaseRequest;
        $this->updateRequest = new BaseRequest;

        $this->baseResource = new BaseResource;

        $this->indexManager = new IndexManager;
        $this->showManager = new ShowManager;
        $this->createManager = new CreateManager;
        $this->updateManager = new UpdateManager;
        $this->deleteManager = new DeleteManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return new $this->indexManager($this->request, $this->builder, $this->baseResource);
    }

    /**
     * Display the specified resource.
     *
     * @param int | string $id
     * @return JsonResource
     */
    public function show(int|string $id): JsonResource
    {
        return new $this->showManager($id, $this->builder, $this->baseResource);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Model
     */
    public function create(): Model
    {
        $this->createRequest->validated();

        return new $this->createManager($this->createRequest, $this->builder, $this->baseResource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int | string $id
     * @return Model
     */
    public function update(Request $request, int|string $id): Model
    {
        $this->updateRequest->validated();

        return new $this->updateManager($this->updateRequest, $this->builder, $id, $this->baseResource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        return new $this->deleteManager($id, $this->builder);
    }
}
