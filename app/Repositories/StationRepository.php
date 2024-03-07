<?php

namespace App\Repositories;

use App\Enum\StationCategoryEnum;
use App\Interfaces\StationRepositoryInterface;
use App\Models\Station;

class StationRepository implements StationRepositoryInterface
{
    public function getAllStations()
    {
        $stations = Station::orderBy('name', 'asc')->get();

        return $stations;
    }

    public function create(array $data)
    {
        $station = new Station();
        $station->code = $data['code'];
        $station->name = $data['name'];
        $station->category = $data['category'];
        $station->is_active = $data['is_active'];
        $station->save();

        return $station;
    }

    public function getStationById($id)
    {
        $station = Station::find($id);

        return $station;
    }

    public function getStationCategory()
    {
        $categories = StationCategoryEnum::toArray();

        return $categories;
    }

    public function update(array $data, $id)
    {
        $station = Station::find($id);
        $station->code = $data['code'];
        $station->name = $data['name'];
        $station->category = $data['category'];
        $station->is_active = $data['is_active'];
        $station->save();

        return $station;
    }

    public function updateActiveStatus($id, $status)
    {
        $station = Station::find($id);
        $station->is_active = $status;
        $station->save();

        return $station;
    }

    public function delete($id)
    {
        $station = Station::find($id);
        $station->delete();

        return $station;
    }

    public function generateCode(int $tryCount): string
    {
        $count = Station::count() + 1 + $tryCount;
        $code = 'STA'.str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, $exceptId = null): bool
    {
        $query = Station::where('code', $code);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->doesntExist();
    }
}
