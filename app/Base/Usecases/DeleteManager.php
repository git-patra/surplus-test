<?php

namespace App\Base\Usecases;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DeleteManager
{
    public Request $request;
    public Builder $builder;
    public array $failedProcess;
    public array $succeedProcess;

    public function execute(Request $request, Builder $model): JsonResponse
    {
        $this->request = $request;
        $this->builder = $model;
        $this->succeedProcess = [];
        $this->failedProcess = [];

        return $this->processEach();
    }

    public function processEach(): JsonResponse
    {
        $allData = $this->builder->whereIn('id', $this->request->ids)->get();

        collect($allData)->map(function ($oldData) {
            try {
                $oldData = $this->beforeProcess($oldData);
                $this->process($oldData);

                $this->afterProcess($oldData);

                $this->succeedProcess[] = "data with id {$oldData->id} successfully delete.";
            } catch (Exception $exception) {
                $this->failedProcess[] = $exception->getMessage();
            }
        });

        return response()->json([
            "success" => $this->succeedProcess,
            "failed" => $this->failedProcess,
        ]);
    }

    private function beforeProcess(Model $data): Model
    {
        return $data;
    }

    private function process(Model $data): void
    {
        $data->delete();
    }

    private function afterProcess(Model $data): void
    {
        return;
    }
}
