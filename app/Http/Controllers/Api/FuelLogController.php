<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuelLogHeavyVehicleRequest;
use App\Http\Requests\StoreFuelLogTruckRequest;
use App\Http\Requests\UpdateFuelLogHeavyVehicleRequest;
use App\Http\Requests\UpdateFuelLogTruckRequest;
use App\Http\Resources\FuelLogResource;
use App\Interfaces\FuelLogRepositoryInterface;
use App\Models\Driver;
use App\Models\GasOperator;
use App\Models\HeavyVehicle;
use App\Models\Station;
use App\Models\Truck;
use Illuminate\Http\Request;

class FuelLogController extends Controller
{
    protected $FuelLogRepository;

    public function __construct(FuelLogRepositoryInterface $FuelLogRepository)
    {
        $this->FuelLogRepository = $FuelLogRepository;
    }

    public function index(Request $request)
    {
        try {
            $fuelLogs = $this->FuelLogRepository->getAllFuelLogs($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', FuelLogResource::collection($fuelLogs), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function storeTruck(StoreFuelLogTruckRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->FuelLogRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->FuelLogRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        $truck = Truck::find($request['truck_id']);
        if ($truck->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Truck tidak aktif.', null, 405);
        }

        $driver = Driver::find($request['driver_id']);
        if ($driver->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Driver tidak aktif.', null, 405);
        }

        $station = Station::find($request['station_id']);
        if ($station->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Station tidak aktif.', null, 405);
        }

        $gasOperator = GasOperator::find($request['gas_operator_id']);
        if ($gasOperator->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Gas Operator tidak aktif.', null, 405);
        }

        try {
            $fuelLog = $this->FuelLogRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Catatan bahan bakar berhasil dibuat.', FuelLogResource::make($fuelLog), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function storeHeavyVehicle(StoreFuelLogHeavyVehicleRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->FuelLogRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->FuelLogRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        $heavyVehicle = HeavyVehicle::find($request['heavy_vehicle_id']);
        if ($heavyVehicle->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Kendaraan berat tidak aktif.', null, 405);
        }

        $driver = Driver::find($request['driver_id']);
        if ($driver->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Driver tidak aktif.', null, 405);
        }

        $station = Station::find($request['station_id']);
        if ($station->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Station tidak aktif.', null, 405);
        }

        $gasOperator = GasOperator::find($request['gas_operator_id']);
        if ($gasOperator->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Gas Operator tidak aktif.', null, 405);
        }

        try {
            $fuelLog = $this->FuelLogRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Catatan bahan bakar berhasil dibuat.', FuelLogResource::make($fuelLog), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $fuelLog = $this->FuelLogRepository->getFuelLogById($id);

            if (! $fuelLog) {
                return ResponseHelper::jsonResponse(false, 'Catatan bahan bakar tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', FuelLogResource::make($fuelLog), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getFuelType()
    {
        try {
            $fuelTypes = $this->FuelLogRepository->getFuelType();

            return ResponseHelper::jsonResponse(true, 'Success', $fuelTypes, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateTruck(UpdateFuelLogTruckRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->FuelLogRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->FuelLogRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        $truck = Truck::find($request['truck_id']);
        if ($truck->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Truck tidak aktif.', null, 405);
        }

        $driver = Driver::find($request['driver_id']);
        if ($driver->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Driver tidak aktif.', null, 405);
        }

        $station = Station::find($request['station_id']);
        if ($station->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Station tidak aktif.', null, 405);
        }

        $gasOperator = GasOperator::find($request['gas_operator_id']);
        if ($gasOperator->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Gas Operator tidak aktif.', null, 405);
        }

        try {
            $fuelLog = $this->FuelLogRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Catatan bahan bakar berhasil diubah.', FuelLogResource::make($fuelLog), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateHeavyVehicle(UpdateFuelLogHeavyVehicleRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->FuelLogRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->FuelLogRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        $heavyVehicle = HeavyVehicle::find($request['heavy_vehicle_id']);
        if ($heavyVehicle->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Kendaraan berat tidak aktif.', null, 405);
        }

        $driver = Driver::find($request['driver_id']);
        if ($driver->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Driver tidak aktif.', null, 405);
        }

        $station = Station::find($request['station_id']);
        if ($station->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Station tidak aktif.', null, 405);
        }

        $gasOperator = GasOperator::find($request['gas_operator_id']);
        if ($gasOperator->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Gas Operator tidak aktif.', null, 405);
        }

        try {
            $fuelLog = $this->FuelLogRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Catatan bahan bakar berhasil diubah.', FuelLogResource::make($fuelLog), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $fuelLog = $this->FuelLogRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Catatan bahan bakar berhasil dihapus.', FuelLogResource::make($fuelLog), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
