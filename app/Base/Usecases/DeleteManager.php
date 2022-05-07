<?php

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class DeleteManager
{
    public BaseRequest $request;
    public Builder $builder;
    public array $failedProcess;
    public array $succeedProcess;

    public function __invoke(BaseRequest $request, Builder $model): JsonResponse
    {
        $this->request = $request;
        $this->builder = $model;

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

                $this->succeedProcess[] = "data with id {$oldData->id} successfully delete.";
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
        $data->delete();

        return $data;
    }

    private function afterProcess(Model $data): void
    {
        return;
    }
}
