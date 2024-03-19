<?php

namespace App\Repositories;

use App\Interfaces\MaterialMovementErrorLogRepositoryInterface;
use App\Models\MaterialMovementErrorLog;

class MaterialMovementErrorLogRepository implements MaterialMovementErrorLogRepositoryInterface
{
    public function getAllMaterialMovementErrorLogs()
    {
        $materialMovementErrorLogs = MaterialMovementErrorLog::orderBy('created_at', 'desc')->get();

        return $materialMovementErrorLogs;
    }

    public function create(array $data)
    {
        $materialMovementErrorLog = new MaterialMovementErrorLog();
        $materialMovementErrorLog->code = $data['code'];
        $materialMovementErrorLog->driver_id = $data['driver_id'];
        $materialMovementErrorLog->truck_id = $data['truck_id'];
        $materialMovementErrorLog->station_id = $data['station_id'];
        $materialMovementErrorLog->checker_id = $data['checker_id'];
        $materialMovementErrorLog->date = $data['date'];
        $materialMovementErrorLog->truck_capacity = $data['truck_capacity'];
        $materialMovementErrorLog->observation_ratio_percentage = $data['observation_ratio_percentage'];
        $materialMovementErrorLog->solid_ratio = $data['solid_ratio'];
        $materialMovementErrorLog->remarks = $data['remarks'];
        $materialMovementErrorLog->error_log = $data['error_log'];
        $materialMovementErrorLog->save();

        return $materialMovementErrorLog;
    }

    public function getMaterialMovementErrorLogById(string $id)
    {
        $materialMovementErrorLog = MaterialMovementErrorLog::find($id);

        return $materialMovementErrorLog;
    }
}
