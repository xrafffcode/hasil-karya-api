<?php

namespace App\Repositories;

use App\Interfaces\ActivityLogRepositoryInterface;
use Spatie\Activitylog\Models\Activity;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function getAllActivityLogs()
    {
        $activityLogs = Activity::all();

        return $activityLogs;
    }

    public function getActivityLogById($id)
    {
        $activityLog = Activity::find($id);

        return $activityLog;
    }
}
