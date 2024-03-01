<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checker extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'name',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function materialMovements()
    {
        return $this->hasMany(MaterialMovement::class);
    }
}
