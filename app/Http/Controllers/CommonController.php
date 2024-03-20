<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Interfaces\CommonRepositoryInterface;

class CommonController extends Controller
{
    protected $commonRepository;

    public function __construct(CommonRepositoryInterface $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }

    public function getDatePeriods()
    {
        try {
            $datePeriods = $this->commonRepository->getDatePeriods();

            return ResponseHelper::jsonResponse(true, 'Success', $datePeriods, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAggregateFunctions()
    {
        try {
            $aggregateFunctions = $this->commonRepository->getAggregateFunctions();

            return ResponseHelper::jsonResponse(true, 'Success', $aggregateFunctions, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
