<?php

namespace App\Repositories;

use App\Enum\AggregateFunctionEnum;
use App\Enum\DatePeriodEnum;
use App\Interfaces\CommonRepositoryInterface;

class CommonRepository implements CommonRepositoryInterface
{
    public function getDatePeriods()
    {
        $datePeriods = [];

        foreach (DatePeriodEnum::toArray() as $datePeriod) {
            $datePeriods[] = [
                'name' => $datePeriod,
            ];
        }

        return $datePeriods;
    }

    public function getAggregateFunctions()
    {
        $aggregateFunctions = [];

        foreach (AggregateFunctionEnum::toArray() as $aggregateFunction) {
            $aggregateFunctions[] = [
                'name' => $aggregateFunction,
            ];
        }

        return $aggregateFunctions;
    }
}
