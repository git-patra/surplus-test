<?php

namespace App\Base\Usecases;

use App\Base\Utils\StatusEnum;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActiveManager
{
    public Request $request;
    public Builder $builder;
    public array $failedProcess;
    public array $succeedProcess;

    /**
     * Process Logic Data
     *
     * @param Request $request
     * @param Builder $model
     * @return JsonResponse
     */
    public function execute(Request $request, Builder $model): JsonResponse
    {
        $this->request = $request;
        $this->builder = $model;
        $this->succeedProcess = [];
        $this->failedProcess = [];

        return $this->processEach();
    }

    /**
     * Looping IDS Data
     *
     * @return JsonResponse
     */
    public function processEach(): JsonResponse
    {
        $allData = $this->builder->whereIn('id', $this->request->ids)->get();

        collect($allData)->map(function ($oldData) {
            try {
                $oldData = $this->beforeProcess($oldData);
                $this->process($oldData);

                $this->afterProcess($oldData);

                $this->succeedProcess[] = "data with id {$oldData->id} successfully activated.";
            } catch (Exception $exception) {
                $this->failedProcess[] = $exception->getMessage();
            }
        });


        return response()->json([
            "success" => $this->succeedProcess,
            "failed" => $this->failedProcess,
        ], 200);
    }

    /**
     * Function Logic Before Active Data
     *
     * @return Model
     */
    private function beforeProcess(Model $data): Model
    {
        return $data;
    }

    /**
     * Update Status to Active
     *
     * @return void
     */
    private function process(Model $data): void
    {
        $data->update(
            ['status' => StatusEnum::ACTIVE->value]
        );
    }

    /**
     * Function Logic After Active Data
     *
     * @return void
     */
    private function afterProcess(Model $data): void
    {
        return;
    }
}
