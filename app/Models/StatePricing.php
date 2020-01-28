<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatePricing extends Model
{
    protected $table = 'state_pricings';

    protected $guarded = [];

    public function creator(){
        return $this->hasOne( Admin::class, 'id', 'created_by');
    }
    public function country(){
        return $this->hasOne( Country::class, 'id', 'country_id');
    }
}
