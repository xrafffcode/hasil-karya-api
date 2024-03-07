<?php

namespace App\Interfaces;

interface StationRepositoryInterface
{
    public function getAllStations();

    public function create(array $data);

    public function getStationById(string $id);

    public function getStationCategory();

    public function update(array $data, string $id);

    public function updateActiveStatus(string $id, bool $status);

    public function delete(string $id);

    public function generateCode(int $tryCount): string;

    public function isUniqueCode(string $code, $exceptId = null): bool;
}
