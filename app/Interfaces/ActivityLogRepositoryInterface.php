<?php

namespace App\Interfaces;

interface ActivityLogRepositoryInterface
{
    public function getAllActivityLogs();

    public function getActivityLogById(string $id);
}
