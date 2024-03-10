<?php

namespace App\Repositories;

use App\Interfaces\TruckRentalRecordRepositoryInterface;
use App\Models\TruckRentalRecord;

class TruckRentalRecordRepository implements TruckRentalRecordRepositoryInterface
{
    public function getAllTruckRentalRecords()
    {
        $truckRentalRecords = TruckRentalRecord::with('truck')
            ->orderBy('start_date', 'desc')
            ->get();

        return $truckRentalRecords;
    }

    public function create(array $data)
    {
        $truckRentalRecord = new TruckRentalRecord();
        $truckRentalRecord->code = $data['code'];
        $truckRentalRecord->truck_id = $data['truck_id'];
        $truckRentalRecord->start_date = $data['start_date'];
        $truckRentalRecord->rental_duration = $data['rental_duration'];
        $truckRentalRecord->rental_cost = $data['rental_cost'];
        $truckRentalRecord->is_paid = $data['is_paid'];
        $truckRentalRecord->remarks = $data['remarks'];
        $truckRentalRecord->save();

        return $truckRentalRecord;
    }

    public function getTruckRentalRecordById(string $id)
    {
        $truckRentalRecord = TruckRentalRecord::with('truck')
            ->find($id);

        return $truckRentalRecord;
    }

    public function update(array $data, string $id)
    {
        $truckRentalRecord = TruckRentalRecord::find($id);
        $truckRentalRecord->code = $data['code'];
        $truckRentalRecord->truck_id = $data['truck_id'];
        $truckRentalRecord->start_date = $data['start_date'];
        $truckRentalRecord->rental_duration = $data['rental_duration'];
        $truckRentalRecord->rental_cost = $data['rental_cost'];
        $truckRentalRecord->is_paid = $data['is_paid'];
        $truckRentalRecord->remarks = $data['remarks'];
        $truckRentalRecord->save();

        return $truckRentalRecord;
    }

    public function updateRentalPaymentStatus(string $id, bool $status)
    {
        $truckRentalRecord = TruckRentalRecord::find($id);
        $truckRentalRecord->is_paid = $status;
        $truckRentalRecord->save();

        return $truckRentalRecord;
    }

    public function delete(string $id)
    {
        $truckRentalRecord = TruckRentalRecord::find($id);
        $truckRentalRecord->delete();

        return $truckRentalRecord;
    }

    public function generateCode(int $tryCount): string
    {
        $count = TruckRentalRecord::count() + 1 + $tryCount;
        $code = 'TRR'.str_pad($count, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, $exceptId = null): bool
    {
        $query = TruckRentalRecord::where('code', $code);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->exists();
    }
}
