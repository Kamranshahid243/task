<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;
    
    protected $table = 'plans';

    public function creator(){
        return $this->hasOne( Admin::class, 'id', 'created_by');
    }
}
