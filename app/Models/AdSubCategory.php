<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AdSubCategory extends Model
{
    protected $table="auc_ad_subcategories";

    protected $guarded=['id'];

    public function creator()
    {
        return $this->hasOne(Admin::class,'id','created_by');
    }
}
