<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRentalRecordRequest;
use App\Http\Requests\UpdateVehicleRentalRecordRequest;
use App\Http\Resources\VehicleRentalRecordResource;
use App\Interfaces\VehicleRentalRecordRepositoryInterface;
use Illuminate\Http\Request;

class VehicleRentalRecordController extends Controller
{
    protected $VehicleRentalRecordRepository;

    public function __construct(VehicleRentalRecordRepositoryInterface $VehicleRentalRecordRepository)
    {
        $this->VehicleRentalRecordRepository = $VehicleRentalRecordRepository;
    }

    public function index(Request $request)
    {
        try {
            $vehicleRentalRecords = $this->VehicleRentalRecordRepository->getAllVehicleRentalRecords();

            return ResponseHelper::jsonResponse(true, 'Success', VehicleRentalRecordResource::collection($vehicleRentalRecords), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreVehicleRentalRecordRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];

        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->VehicleRentalRecordRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->VehicleRentalRecordRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        if (! isset($request['truck_id'])) {
            $request['truck_id'] = null;
        }

        if (! isset($request['heavy_vehicle_id'])) {
            $request['heavy_vehicle_id'] = null;
        }

        try {
            $vehicleRentalRecord = $this->VehicleRentalRecordRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data rekaman sewa kendaraan berhasil ditambahkan.', new VehicleRentalRecordResource($vehicleRentalRecord), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $vehicleRentalRecord = $this->VehicleRentalRecordRepository->getVehicleRentalRecordById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new VehicleRentalRecordResource($vehicleRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateVehicleRentalRecordRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->VehicleRentalRecordRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->VehicleRentalRecordRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        if (! isset($request['truck_id'])) {
            $request['truck_id'] = null;
        }

        if (! isset($request['heavy_vehicle_id'])) {
            $request['heavy_vehicle_id'] = null;
        }

        try {
            $vehicleRentalRecord = $this->VehicleRentalRecordRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data rekaman sewa kendaraan berhasil diubah.', new VehicleRentalRecordResource($vehicleRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateRentalPaymentStatus(Request $request, $id)
    {
        $status = $request->is_paid;

        try {
            $vehicleRentalRecord = $this->VehicleRentalRecordRepository->updateRentalPaymentStatus($id, $status);

            $message = $vehicleRentalRecord->is_paid ? 'Status bayar rekaman sewa kendaraan berhasil dirubah menjadi sudah terbayar.' : 'Status bayar rekaman sewa kendaraan berhasil diubah menjadi belum terbayar.';

            return ResponseHelper::jsonResponse(true, $message, new VehicleRentalRecordResource($vehicleRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $vehicleRentalRecord = $this->VehicleRentalRecordRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data rekaman sewa kendaraan berhasil dihapus.', new VehicleRentalRecordResource($vehicleRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
