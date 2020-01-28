<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{ 
    use SoftDeletes;
    
    protected $table = 'subcategories';

   

    public function creator(){
        return $this->hasOne( Admin::class, 'id', 'created_by');
    }

    public function category(){
        return $this->hasOne( Category::class, 'id', 'category_id');
    }
}
