<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
   public $guarded=['id','created_at','update_at'];
    public static function findRequested()
    {
        $query=Ad::query();
        if(request('sort'))$query->orderBy(request('sort'), request("sortType", "asc"));
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();

    }
}
