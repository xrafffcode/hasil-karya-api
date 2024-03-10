<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TruckRentalRecord extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'truck_id',
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
}
