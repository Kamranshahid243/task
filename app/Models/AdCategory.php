<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AdCategory extends Model
{
    protected $table="auc_ad_categories";

    protected $guarded=['id'];

    public static function findRequested()
    {
        $query=AdCategory::with(['role']);
        if(request('sort'))$query->orderBy(request('sort'), request("sortType", "asc"));
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();

    }

    public function creator()
    {
        return $this->hasOne(Admin::class,'id','created_by');
    }
}
