<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'province',
        'regency',
        'district',
        'subdistrict',
        'category',
        'material_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_station_pivot');
    }

    public function materialMovements()
    {
        return $this->hasMany(MaterialMovement::class);
    }
}
