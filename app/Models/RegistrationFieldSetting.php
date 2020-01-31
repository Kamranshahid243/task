<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RegistrationFieldSetting extends Model
{

    protected $table='registration_field_settings';
    protected $guarded=['id'];
    public function creator()
    {
        return $this->belongsTo(Admin::class,'created_by','id');
    }
}
