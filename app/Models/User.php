<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function checker()
    {
        return $this->hasOne(Checker::class);
    }

    public function hasChecker()
    {
        return $this->checker()->exists();
    }

    public function gasOperator()
    {
        return $this->hasOne(GasOperator::class);
    }

    public function hasGasOperator()
    {
        return $this->gasOperator()->exists();
    }

    public function technicalAdmin()
    {
        return $this->hasOne(TechnicalAdmin::class);
    }

    public function hasTechnicalAdmin()
    {
        return $this->technicalAdmin()->exists();
    }

    public function isActive()
    {
        if ($this->hasChecker()) {
            return $this->checker->is_active;
        }elseif ($this->hasGasOperator()) {
            return $this->gasOperator->is_active;
        }elseif ($this->hasTechnicalAdmin()) {
            return $this->technicalAdmin->is_active;
        }else {
            return true;
        }
    }
}
