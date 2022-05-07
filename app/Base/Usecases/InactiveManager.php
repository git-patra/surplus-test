<?php

namespace App\Base\Usecases;

use App\Base\Utils\StatusEnum;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InactiveManager
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

                $this->succeedProcess[] = "data with id {$oldData->id} successfully deactivated.";
            } catch (Exception $exception) {
                $this->failedProcess[] = $exception->getMessage();
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

    private function process(Model $data): void
    {
        $data->update(
            ['status' => StatusEnum::INACTIVE->value]
        );
    }

    private function afterProcess(Model $data): void
    {
        return;
    }
}
