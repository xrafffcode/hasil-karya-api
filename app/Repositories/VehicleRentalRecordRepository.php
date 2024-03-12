<?php

namespace App\Repositories;

use App\Interfaces\VehicleRentalRecordRepositoryInterface;
use App\Models\VehicleRentalRecord;

class VehicleRentalRecordRepository implements VehicleRentalRecordRepositoryInterface
{
    public function getAllVehicleRentalRecords()
    {
        $vehicleRentalRecords = VehicleRentalRecord::with('truck', 'heavyVehicle')
            ->orderBy('start_date', 'desc')
            ->get();

        return $vehicleRentalRecords;
    }

    public function create(array $data)
    {
        $vehicleRentalRecord = new VehicleRentalRecord();
        $vehicleRentalRecord->code = $data['code'];
        $vehicleRentalRecord->truck_id = $data['truck_id'];
        $vehicleRentalRecord->heavy_vehicle_id = $data['heavy_vehicle_id'];
        $vehicleRentalRecord->start_date = $data['start_date'];
        $vehicleRentalRecord->rental_duration = $data['rental_duration'];
        $vehicleRentalRecord->rental_cost = $data['rental_cost'];
        $vehicleRentalRecord->is_paid = $data['is_paid'];
        $vehicleRentalRecord->remarks = $data['remarks'];
        $vehicleRentalRecord->save();

        return $vehicleRentalRecord;
    }

    public function getVehicleRentalRecordById(string $id)
    {
        $vehicleRentalRecord = VehicleRentalRecord::with('truck', 'heavyVehicle')
            ->find($id);

        return $vehicleRentalRecord;
    }

    public function update(array $data, string $id)
    {
        $vehicleRentalRecord = VehicleRentalRecord::find($id);
        $vehicleRentalRecord->code = $data['code'];
        $vehicleRentalRecord->truck_id = $data['truck_id'];
        $vehicleRentalRecord->heavy_vehicle_id = $data['heavy_vehicle_id'];
        $vehicleRentalRecord->start_date = $data['start_date'];
        $vehicleRentalRecord->rental_duration = $data['rental_duration'];
        $vehicleRentalRecord->rental_cost = $data['rental_cost'];
        $vehicleRentalRecord->is_paid = $data['is_paid'];
        $vehicleRentalRecord->remarks = $data['remarks'];
        $vehicleRentalRecord->save();

        return $vehicleRentalRecord;
    }

    public function updateRentalPaymentStatus(string $id, bool $status)
    {
        $vehicleRentalRecord = VehicleRentalRecord::find($id);
        $vehicleRentalRecord->is_paid = $status;
        $vehicleRentalRecord->save();

        return $vehicleRentalRecord;
    }

    public function delete(string $id)
    {
        $vehicleRentalRecord = VehicleRentalRecord::find($id);
        $vehicleRentalRecord->delete();

        return $vehicleRentalRecord;
    }

    public function generateCode(int $tryCount): string
    {
        $count = VehicleRentalRecord::count() + 1 + $tryCount;
        $code = 'VRR'.str_pad($count, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, $exceptId = null): bool
    {
        $query = VehicleRentalRecord::where('code', $code);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->doesntExist();
    }
}
