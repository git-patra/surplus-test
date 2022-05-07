<?php

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ActiveManager
{
    public BaseRequest $request;
    public Builder $builder;
    public array $failedProcess;
    public array $succeedProcess;

    public function __construct(BaseRequest $request, Builder $model)
    {
        $this->request = $request;
        $this->builder = $model;
    }

    public function __invoke(): JsonResponse
    {
        return $this->processEach();
    }

    public function processEach(): JsonResponse
    {
        collect($this->request->ids)->map(function ($id) {
            try {
                $oldData = $this->builder->findOrFail($id);

                $oldData = $this->beforeProcess($oldData);
                $this->process($oldData);

                $this->afterProcess($oldData);

                $this->succeedProcess[] = "data with id {$oldData->id} successfully activated.";
            } catch (Exception $exception) {
                $this->failedProcess[] = $exception;
            }
        });


        return response()->json([
            "success" => $this->succeedProcess,
            "failed" => $this->failedProcess,
        ], 200);
    }

    private function beforeProcess(Model $data): Model
    {
        return $data;
    }

    private function process(Model $data): Model|Builder|null
    {
        $data->update(
            ['status' => Status::ACTIVE]
        );

        return $data->fresh();
    }

    private function afterProcess(Model $data): void
    {
        return;
    }
}
