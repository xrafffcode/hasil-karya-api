<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Resources\DriverResource;
use App\Interfaces\DriverRepositoryInterface;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected $DriverRepository;

    public function __construct(DriverRepositoryInterface $DriverRepository)
    {
        $this->DriverRepository = $DriverRepository;
    }

    public function index(Request $request)
    {
        try {
            $drivers = $this->DriverRepository->getAllDrivers($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', DriverResource::collection($drivers), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreDriverRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->DriverRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->DriverRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $driver = $this->DriverRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Success', new DriverResource($driver), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $driver = $this->DriverRepository->getDriverById($id);

            if (! $driver) {
                return ResponseHelper::jsonResponse(false, 'Driver not found', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new DriverResource($driver), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateDriverRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->DriverRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->DriverRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $driver = $this->DriverRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Success', new DriverResource($driver), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $driver = $this->DriverRepository->updateActiveStatus($id, $status);

            return ResponseHelper::jsonResponse(true, 'Success', new DriverResource($driver), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $driver = $this->DriverRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Success', new DriverResource($driver), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
