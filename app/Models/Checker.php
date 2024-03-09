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

    // protected $dateFormat = 'Y-m-d H:i:s';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     $carbon = Carbon::parse($value);
    //     $date = $carbon->toDateTimeString();
    //     $this->attributes['created_at'] = $date;
    // }

    // public function getUpdatedAtAttribute($value)
    // {
    //     $carbon = Carbon::parse($value);
    //     $this->attributes['updated_at'] = $carbon->toDateTimeString();
    // }
}
