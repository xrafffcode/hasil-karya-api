<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleRentalRecord extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'truck_id',
        'heavy_vehicle_id',
        'start_date',
        'rental_duration',
        'rental_cost',
        'is_paid',
        'remarks',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function heavyVehicle()
    {
        return $this->belongsTo(HeavyVehicle::class);
    }
}
