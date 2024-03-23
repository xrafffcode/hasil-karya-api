<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuelLogHeavyVehicleRequest;
use App\Http\Requests\StoreFuelLogTruckRequest;
use App\Http\Resources\FuelLogErrorLogResource;
use App\Interfaces\FuelLogErrorLogRepositoryInterface;
use Illuminate\Http\Request;

class FuelLogErrorLogController extends Controller
{
    protected $FuelLogErrorLogRepository;

    public function __construct(FuelLogErrorLogRepositoryInterface $FuelLogErrorLogRepository)
    {
        $this->FuelLogErrorLogRepository = $FuelLogErrorLogRepository;
    }

    public function index(Request $request)
    {
        try {
            $FuelLogErrorLogs = $this->FuelLogErrorLogRepository->getAllFuelLogErrorLogs($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', FuelLogErrorLogResource::collection($FuelLogErrorLogs), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function storeTruck(StoreFuelLogTruckRequest $request)
    {
        $request = $request->validated();

        try {
            $FuelLogErrorLog = $this->FuelLogErrorLogRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Success', FuelLogErrorLogResource::make($FuelLogErrorLog), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function storeHeavyVehicle(StoreFuelLogHeavyVehicleRequest $request)
    {
        $request = $request->validated();

        try {
            $FuelLogErrorLog = $this->FuelLogErrorLogRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Success', FuelLogErrorLogResource::make($FuelLogErrorLog), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $FuelLogErrorLog = $this->FuelLogErrorLogRepository->getFuelLogErrorLogById($id);

            return ResponseHelper::jsonResponse(true, 'Success', FuelLogErrorLogResource::make($FuelLogErrorLog), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
