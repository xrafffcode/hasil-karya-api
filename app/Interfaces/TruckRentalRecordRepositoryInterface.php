<?php

namespace App\Interfaces;

interface TruckRentalRecordRepositoryInterface
{
    public function getAllTruckRentalRecords();

    public function create(array $data);

    public function getTruckRentalRecordById(string $id);

    public function update(array $data, string $id);

    public function updateRentalPaymentStatus(string $id, bool $status);

    public function delete(string $id);

    public function generateCode(int $tryCount): string;

    public function isUniqueCode(string $code, $exceptId = null): bool;
}
