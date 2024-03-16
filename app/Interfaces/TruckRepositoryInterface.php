<?php

namespace App\Interfaces;

interface TruckRepositoryInterface
{
    public function getAllTrucks();

    public function create(array $data);

    public function getTruckById(string $id);

    public function update(array $data, string $id);

    public function updateActiveStatus(string $id, bool $status);

    public function delete(string $id);

    public function generateCode(int $tryCount): string;

    public function isUniqueCode(string $code, $exceptId = null): bool;

    public function isAvailable(string $id): bool;
}
