<?php

namespace App\Interfaces;

interface MaterialMovementErrorLogRepositoryInterface
{
    public function getAllMaterialMovementErrorLogs();

    public function create(array $data);

    public function getMaterialMovementErrorLogById(string $id);
}
