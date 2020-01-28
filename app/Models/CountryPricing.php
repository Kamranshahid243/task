<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryPricing extends Model
{
    protected $table = 'country_pricings';

    protected $guarded = [];

    public function creator(){
        return $this->hasOne( Admin::class, 'id', 'created_by');
    }
}
