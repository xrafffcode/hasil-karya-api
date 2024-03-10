<?php

namespace App\Interfaces;

interface MaterialRepositoryInterface
{
    public function getAllMaterials();

    public function create(array $data);

    public function getMaterialById(string $id);

    public function update(array $data, string $id);

    public function delete(string $id);

    public function generateCode(int $tryCount): string;

    public function isUniqueCode(string $code, $exceptId = null): bool;
}
