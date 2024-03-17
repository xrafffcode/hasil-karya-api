<?php

namespace App\Models;

use App\Traits\UUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialMovement extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'driver_id',
        'truck_id',
        'station_id',
        'checker_id',
        'date',
        'truck_capacity',
        'observation_ratio_percentage',
        'observation_ratio_number',
        'solid_ratio',
        'solid_volume_estimate',
        'remarks',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function checker()
    {
        return $this->belongsTo(Checker::class);
    }

    public function getFormattedDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->date);

        return $date->isoFormat('DD MMMM YYYY');
    }
}
