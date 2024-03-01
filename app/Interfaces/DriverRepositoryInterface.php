<?php

namespace App\Interfaces;

interface DriverRepositoryInterface
{
    public function getAllDrivers();

    public function create(array $data);

    public function getDriverById(string $id);

    public function update(array $data, string $id);

    public function delete(string $id);

    public function generateCode(int $tryCount): string;

    public function isUniqueCode(string $code, $exceptId = null): bool;
}
