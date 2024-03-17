<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'name',
        'description',
        'start_date',
        'end_date',
        'person_in_charge',
        'amount',
        'client_id',
        'province',
        'regency',
        'district',
        'subdistrict',
        'status',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'project_driver_pivot');
    }

    public function trucks()
    {
        return $this->belongsToMany(Truck::class, 'project_truck_pivot');
    }

    public function heavyVehicles()
    {
        return $this->belongsToMany(HeavyVehicle::class, 'project_heavy_vehicle_pivot');
    }

    public function stations()
    {
        return $this->belongsToMany(Station::class, 'project_station_pivot');
    }

    public function checkers()
    {
        return $this->belongsToMany(Checker::class, 'project_checker_pivot');
    }

    public function technicalAdmins()
    {
        return $this->belongsToMany(TechnicalAdmin::class, 'project_technical_admin_pivot');
    }

    public function gasOperators()
    {
        return $this->belongsToMany(GasOperator::class, 'project_gas_operator_pivot');
    }
}
