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
        'amount',
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
        $tanggal = Carbon::createFromFormat('Y-m-d H:i:s', $this->date);

        return $tanggal->isoFormat('DD MMMM YYYY');
    }
}
