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

            return ResponseHelper::jsonResponse(true, 'Data driver berhasil ditambahkan.', new DriverResource($driver), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $driver = $this->DriverRepository->getDriverById($id);

            if (! $driver) {
                return ResponseHelper::jsonResponse(false, 'Data driver tidak ditemukan.', null, 404);
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

            return ResponseHelper::jsonResponse(true, 'Data driver berhasil diperbaharui.', new DriverResource($driver), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $driver = $this->DriverRepository->updateActiveStatus($id, $status);

            $message = $driver->is_active ? 'Driver berhasil diaktifkan.' : 'Driver berhasil dinonaktifkan.';

            return ResponseHelper::jsonResponse(true, $message, new DriverResource($driver), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $driver = $this->DriverRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Driver berhasil dihapus.', new DriverResource($driver), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function checkAvailability($id)
    {
        try {
            $isAvailable = $this->DriverRepository->isAvailable($id);

            if ($isAvailable) {
                return ResponseHelper::jsonResponse(true, 'Driver tersedia.', null, 200);
            } else {
                return ResponseHelper::jsonResponse(false, 'Driver tidak tersedia.', null, 200);
            }
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
