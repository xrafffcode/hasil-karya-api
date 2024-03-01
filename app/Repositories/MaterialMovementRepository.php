<?php

namespace App\Repositories;

use App\Interfaces\MaterialMovementRepositoryInterface;
use App\Models\MaterialMovement;

class MaterialMovementRepository implements MaterialMovementRepositoryInterface
{
    public function getAllMaterialMovements()
    {
        $materialMovements = MaterialMovement::orderBy('date', 'desc')->get();

        return $materialMovements;
    }

    public function create(array $data)
    {
        $materialMovement = new MaterialMovement();
        $materialMovement->code = $data['code'];
        $materialMovement->driver_id = $data['driver_id'];
        $materialMovement->truck_id = $data['truck_id'];
        $materialMovement->station_id = $data['station_id'];
        $materialMovement->checker_id = $data['checker_id'];
        $materialMovement->date = $data['date'];
        $materialMovement->amount = $data['amount'];
        $materialMovement->save();

        return $materialMovement;
    }

    public function getMaterialMovementById($id)
    {
        $materialMovement = MaterialMovement::find($id);

        return $materialMovement;
    }

    public function update(array $data, $id)
    {
        $materialMovement = MaterialMovement::find($id);
        $materialMovement->code = $data['code'];
        $materialMovement->driver_id = $data['driver_id'];
        $materialMovement->truck_id = $data['truck_id'];
        $materialMovement->station_id = $data['station_id'];
        $materialMovement->checker_id = $data['checker_id'];
        $materialMovement->date = $data['date'];
        $materialMovement->amount = $data['amount'];
        $materialMovement->save();

        return $materialMovement;
    }

    public function delete($id)
    {
        $materialMovement = MaterialMovement::find($id);
        $materialMovement->delete();

        return $materialMovement;
    }

    public function generateCode(int $tryCount): string
    {
        $count = MaterialMovement::count() + 1 + $tryCount;
        $code = 'MM'.str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, $exceptId = null): bool
    {
        $query = MaterialMovement::where('code', $code);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->doesntExist();
    }
}
