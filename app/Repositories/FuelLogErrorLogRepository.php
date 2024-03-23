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
        $fuelLogErrorLog->driver_id = $data['driver_id'];
        $fuelLogErrorLog->truck_id = $data['truck_id'];
        $fuelLogErrorLog->station_id = $data['station_id'];
        $fuelLogErrorLog->checker_id = $data['checker_id'];
        $fuelLogErrorLog->truck_capacity = $data['truck_capacity'];
        $fuelLogErrorLog->observation_ratio_percentage = $data['observation_ratio_percentage'];
        $fuelLogErrorLog->solid_ratio = $data['solid_ratio'];
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
