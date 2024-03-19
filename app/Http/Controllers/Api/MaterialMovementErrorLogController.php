<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialMovementErrorLogRequest;
use App\Http\Resources\MaterialMovementErrorLogResource;
use App\Interfaces\MaterialMovementErrorLogRepositoryInterface;
use Illuminate\Http\Request;

class MaterialMovementErrorLogController extends Controller
{
    protected $MaterialMovementErrorLogRepository;

    public function __construct(MaterialMovementErrorLogRepositoryInterface $MaterialMovementErrorLogRepository)
    {
        $this->MaterialMovementErrorLogRepository = $MaterialMovementErrorLogRepository;
    }

    public function index(Request $request)
    {
        try {
            $MaterialMovementErrorLogRepository = $this->MaterialMovementErrorLogRepository->getAllMaterialMovementErrorLogs($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', MaterialMovementErrorLogResource::collection($MaterialMovementErrorLogRepository), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);

        }
    }

    public function store(StoreMaterialMovementErrorLogRequest $request)
    {
        $request = $request->validated();

        try {
            $MaterialMovementErrorLogRepository = $this->MaterialMovementErrorLogRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Success', MaterialMovementErrorLogResource::make($MaterialMovementErrorLogRepository), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $MaterialMovementErrorLogRepository = $this->MaterialMovementErrorLogRepository->getMaterialMovementErrorLogById($id);

            return ResponseHelper::jsonResponse(true, 'Success', MaterialMovementErrorLogResource::make($MaterialMovementErrorLogRepository), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
