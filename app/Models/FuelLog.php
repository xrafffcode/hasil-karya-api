<?php

namespace App\Models;

use App\Traits\UUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelLog extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'date',
        'truck_id',
        'heavy_vehicle_id',
        'driver_id',
        'station_id',
        'gas_operator_id',
        'fuel_type',
        'volume',
        'odometer',
        'hourmeter',
        'remarks',
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function heavyVehicle()
    {
        return $this->belongsTo(HeavyVehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function gasOperator()
    {
        return $this->belongsTo(GasOperator::class);
    }

    public function getFormattedDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->date);

        return $this->date->isoFormat('DD MMMM YYYY');
    }
}
