<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Interfaces\ActivityLogRepositoryInterface;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    protected $activityLogRepository;

    public function __construct(ActivityLogRepositoryInterface $activityLogRepository)
    {
        $this->activityLogRepository = $activityLogRepository;
    }

    public function index(Request $request)
    {
        try {
            $activityLogs = $this->activityLogRepository->getAllActivityLogs();

            return ResponseHelper::jsonResponse(true, 'Success', $activityLogs, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $activityLog = $this->activityLogRepository->getActivityLogById($id);

            return ResponseHelper::jsonResponse(true, 'Success', $activityLog, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
