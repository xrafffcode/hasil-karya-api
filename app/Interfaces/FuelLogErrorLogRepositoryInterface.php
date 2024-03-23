<?php

namespace App\Interfaces;

interface FuelLogErrorLogRepositoryInterface
{
    public function getAllFuelLogErrorLogs();

    public function create(array $data);

    public function getFuelLogErrorLogById(string $id);
}
