<?php

namespace App\Models;

use App\Traits\UUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleRentalRecord extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'truck_id',
        'heavy_vehicle_id',
        'start_date',
        'rental_duration',
        'rental_cost',
        'is_paid',
        'remarks',
        'payment_proof_image',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        // 'start_date' => 'datetime:Y-m-d H:i:s',
        // 'end_date' => 'datetime:Y-m-d H:i:s',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'truck_id', 'heavy_vehicle_id', 'start_date', 'rental_duration', 'rental_cost', 'is_paid', 'remarks', 'payment_proof_image'])
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}")
            ->useLogName('VehicleRentalRecord');
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function heavyVehicle()
    {
        return $this->belongsTo(HeavyVehicle::class);
    }

    // public function getFormattedStartDateAttribute()
    // {
    //     $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date);

    //     return $date->isoFormat('DD MMMM YYYY');
    // }
}
