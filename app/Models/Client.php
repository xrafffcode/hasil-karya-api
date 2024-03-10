<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'code',
        'name',
        'province',
        'regency',
        'district',
        'subdistrict',
        'address',
        'phone',
        'email',
    ];

    public function Projects()
    {
        return $this->hasMany(Project::class);
    }
}
