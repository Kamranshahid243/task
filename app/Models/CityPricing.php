<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityPricing extends Model
{
    protected $table = 'city_pricings';

    protected $guarded = [];

    public function creator(){
        return $this->hasOne( Admin::class, 'id', 'created_by');
    }
    public function country(){
        return $this->hasOne( Country::class, 'id', 'country_id');
    }
    public function state(){
        return $this->hasOne( State::class, 'id', 'state_id');
    }
}
