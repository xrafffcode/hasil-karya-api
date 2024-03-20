<?php

namespace App\Interfaces;

interface VehicleRentalRecordRepositoryInterface
{
    public function getAllVehicleRentalRecords();

    public function getDueVehicleRentalRecords();

    public function create(array $data);

    public function getVehicleRentalRecordById(string $id);

    public function update(array $data, string $id);

    public function updateRentalPaymentStatus(string $id, bool $status);

    public function delete(string $id);

    public function generateCode(int $tryCount): string;

    public function isUniqueCode(string $code, $exceptId = null): bool;
}
