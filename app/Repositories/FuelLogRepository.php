<?php

namespace App\Repositories;

use App\Interfaces\FuelLogRepositoryInterface;
use App\Models\FuelLog;

class FuelLogRepository implements FuelLogRepositoryInterface
{
    public function getAllFuelLogs()
    {
        $fuelLogs = FuelLog::with('truck', 'station')
            ->orderBy('date', 'desc')->get();

        return $fuelLogs;
    }

    public function create(array $data)
    {
        $fuelLog = new FuelLog();
        $fuelLog->code = $data['code'];
        $fuelLog->date = $data['date'];
        $fuelLog->truck_id = $data['truck_id'];
        $fuelLog->heavy_vehicle_id = $data['heavy_vehicle_id'];
        $fuelLog->driver_id = $data['driver_id'];
        $fuelLog->station_id = $data['station_id'];
        $fuelLog->gas_operator_id = $data['gas_operator_id'];
        $fuelLog->fuel_type = $data['fuel_type'];
        $fuelLog->volume = $data['volume'];
        $fuelLog->odometer = $data['odometer'];
        $fuelLog->hourmeter = $data['hourmeter'];
        $fuelLog->remarks = $data['remarks'];
        $fuelLog->save();

        return $fuelLog;
    }

    public function getFuelLogById(string $id)
    {
        $fuelLog = FuelLog::with('truck', 'station')
            ->find($id);

        return $fuelLog;
    }

    public function update(array $data, string $id)
    {
        $fuelLog = FuelLog::find($id);
        $fuelLog->code = $data['code'];
        $fuelLog->date = $data['date'];
        $fuelLog->truck_id = $data['truck_id'];
        $fuelLog->heavy_vehicle_id = $data['heavy_vehicle_id'];
        $fuelLog->driver_id = $data['driver_id'];
        $fuelLog->station_id = $data['station_id'];
        $fuelLog->gas_operator_id = $data['gas_operator_id'];
        $fuelLog->fuel_type = $data['fuel_type'];
        $fuelLog->volume = $data['volume'];
        $fuelLog->odometer = $data['odometer'];
        $fuelLog->hourmeter = $data['hourmeter'];
        $fuelLog->remarks = $data['remarks'];
        $fuelLog->save();

        return $fuelLog;
    }

    public function delete(string $id)
    {
        $fuelLog = FuelLog::find($id);
        $fuelLog->delete();

        return $fuelLog;
    }

    public function generateCode(int $tryCount): string
    {
        $count = FuelLog::count() + 1 + $tryCount;
        $code = 'FL'.str_pad($count, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, $exceptId = null): bool
    {
        $fuelLog = FuelLog::where('code', $code);
        if ($exceptId) {
            $fuelLog = $fuelLog->where('id', '!=', $exceptId);
        }
        $fuelLog = $fuelLog->first();

        return $fuelLog ? false : true;
    }
}
