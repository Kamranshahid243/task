<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'admins';

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id' );
    }

    public function gender(){
        return $this->hasOne(Gender::class, 'id', 'gender_id');
    }

    public function country(){
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
    
    public function state(){
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
