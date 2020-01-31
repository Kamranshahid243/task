<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcategoryMetadata extends Model
{
//    use SoftDeletes;
    protected $table = 'auc_ad_subcategory_meta_data';



    public function creator(){
        return $this->hasOne( Admin::class, 'id', 'created_by');
    }
//
    public function category(){
        return $this->hasOne( Category::class, 'id', 'category_id');
    }
    public function subCategory(){
        return $this->belongsTo( Subcategory::class);
    }
}
