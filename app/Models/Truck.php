<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Truck extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'brand',
        'model',
        'capacity',
        'production_year',
        'vendor_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'brand', 'model', 'capacity', 'production_year', 'vendor_id', 'is_active'])
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}")
            ->useLogName('Truck');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_truck_pivot');
    }

    public function materialMovements()
    {
        return $this->hasMany(MaterialMovement::class);
    }
}
