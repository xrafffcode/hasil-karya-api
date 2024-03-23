<?php

namespace App\Repositories;

use App\Interfaces\FuelLogErrorLogRepositoryInterface;
use App\Models\FuelLogErrorLog;

class FuelLogErrorLogRepository implements FuelLogErrorLogRepositoryInterface
{
    public function getAllFuelLogErrorLogs()
    {
        $fuelLogErrorLogs = FuelLogErrorLog::orderBy('created_at', 'desc')->get();

        return $fuelLogErrorLogs;
    }

    public function create(array $data)
    {
        $fuelLogErrorLog = new FuelLogErrorLog();
        $fuelLogErrorLog->code = $data['code'];
        $fuelLogErrorLog->date = $data['date'];
        $fuelLogErrorLog->truck_id = isset($data['truck_id']) ? $data['truck_id'] : null;
        $fuelLogErrorLog->heavy_vehicle_id = isset($data['heavy_vehicle_id']) ? $data['heavy_vehicle_id'] : null;
        $fuelLogErrorLog->driver_id = $data['driver_id'];
        $fuelLogErrorLog->station_id = $data['station_id'];
        $fuelLogErrorLog->gas_operator_id = $data['gas_operator_id'];
        $fuelLogErrorLog->fuel_type = $data['fuel_type'];
        $fuelLogErrorLog->volume = $data['volume'];
        $fuelLogErrorLog->odometer = isset($data['odometer']) ? $data['odometer'] : null;
        $fuelLogErrorLog->hourmeter = isset($data['hourmeter']) ? $data['hourmeter'] : null;
        $fuelLogErrorLog->remarks = $data['remarks'];
        $fuelLogErrorLog->error_log = $data['error_log'];
        $fuelLogErrorLog->save();

        return $fuelLogErrorLog;
    }

    public function getFuelLogErrorLogById(string $id)
    {
        $fuelLogErrorLog = FuelLogErrorLog::find($id);

        return $fuelLogErrorLog;
    }
}
