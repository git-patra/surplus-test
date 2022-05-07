<?php

namespace App\Base\Http\Controller;

use App\Base\Requests\BaseRequest;
use App\Base\Resources\BaseResource;
use App\Base\Usecases\ActiveManager;
use App\Base\Usecases\CreateManager;
use App\Base\Usecases\DeleteManager;
use App\Base\Usecases\InactiveManager;
use App\Base\Usecases\IndexManager;
use App\Base\Usecases\ShowManager;
use App\Base\Usecases\UpdateManager;
use App\Base\Utils\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyBaseController extends Controller
{
    public BaseResource $baseResource;
    public BaseRequest $createRequest;
    public BaseRequest $updateRequest;
    public Builder $builder;
    public IndexManager $indexManager;
    public ShowManager $showManager;
    public CreateManager $createManager;
    public UpdateManager $updateManager;
    public DeleteManager $deleteManager;
    public ActiveManager $activeManager;
    public InactiveManager $inactiveManager;

    public function __construct(
        Builder $model,
    )
    {
        $this->builder = $model;

        $this->baseResource = new BaseResource;

        $this->indexManager = new IndexManager;
        $this->showManager = new ShowManager();
        $this->createManager = new CreateManager();
        $this->updateManager = new UpdateManager();
        $this->deleteManager = new DeleteManager();
        $this->activeManager = new ActiveManager();
        $this->inactiveManager = new InactiveManager();
    }

    public function setRequest(): void
    {
        $this->createRequest = app()->make(BaseRequest::class);
        $this->updateRequest = app()->make(BaseRequest::class);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     *
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        return $this->indexManager->execute($request, $this->builder, $this->baseResource);
    }

    /**
     * Display the specified resource.
     *
     * @param int | string $id
     * @return JsonResource
     */
    public function show(int|string $id): JsonResource
    {
        return $this->showManager->execute($id, $this->builder, $this->baseResource);
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     *
     * @return JsonResource
     */
    public function create(Request $request): JsonResource
    {
        $this->setRequest();

        return $this->createManager->execute($this->createRequest, $this->builder, $this->baseResource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int | string $id
     * @return JsonResource
     */
    public function update(int|string $id): JsonResource
    {
        $this->setRequest();

        return $this->updateManager->execute($this->updateRequest, $this->builder, $id, $this->baseResource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        return $this->deleteManager->execute($request, $this->builder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function active(Request $request): JsonResponse
    {
        return $this->activeManager->execute($request, $this->builder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function inactive(Request $request): JsonResponse
    {
        return $this->inactiveManager->execute($request, $this->builder);
    }
}
