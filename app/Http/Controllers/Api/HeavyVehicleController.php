<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHeavyVehicleRequest;
use App\Http\Requests\UpdateHeavyVehicleRequest;
use App\Http\Resources\HeavyVehicleResource;
use App\Interfaces\HeavyVehicleRepositoryInterface;
use Illuminate\Http\Request;

class HeavyVehicleController extends Controller
{
    protected $HeavyVehicleRepository;

    public function __construct(HeavyVehicleRepositoryInterface $HeavyVehicleRepository)
    {
        $this->HeavyVehicleRepository = $HeavyVehicleRepository;
    }

    public function index(Request $request)
    {
        try {
            $heavyVehicles = $this->HeavyVehicleRepository->getAllHeavyVehicles();

            return ResponseHelper::jsonResponse(true, 'Success', HeavyVehicleResource::collection($heavyVehicles), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreHeavyVehicleRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->HeavyVehicleRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->HeavyVehicleRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $heavyVehicle = $this->HeavyVehicleRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data alat berat berhasil ditambahkan.', new HeavyVehicleResource($heavyVehicle), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $heavyVehicle = $this->HeavyVehicleRepository->getHeavyVehicleById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new HeavyVehicleResource($heavyVehicle), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateHeavyVehicleRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->HeavyVehicleRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->HeavyVehicleRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $heavyVehicle = $this->HeavyVehicleRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data alat berat berhasil diubah.', new HeavyVehicleResource($heavyVehicle), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $heavyVehicle = $this->HeavyVehicleRepository->updateActiveStatus($id, $status);

            $message = $status ? 'Status data alat berat berhasil diaktifkan.' : 'Status data alat berat berhasil di nonaktifkan';

            return ResponseHelper::jsonResponse(true, $message, new HeavyVehicleResource($heavyVehicle), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $heavyVehicle = $this->HeavyVehicleRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data alat berat berhasil dihapus.', new HeavyVehicleResource($heavyVehicle), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
