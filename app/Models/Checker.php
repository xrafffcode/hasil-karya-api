<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Carbon\Carbon;

class Checker extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function materialMovements()
    {
        return $this->hasMany(MaterialMovement::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_checker_pivot');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
