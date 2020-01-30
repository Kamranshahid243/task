<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmailTemplate extends Model
{


    protected $guarded=['id'];

    public static function findRequested()
    {
        $query=EmailTemplate::with(['role']);
        if(request('sort'))$query->orderBy(request('sort'), request("sortType", "asc"));
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();

    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function creator()
    {
        return $this->belongsTo(Admin::class,'created_by','id');
    }
}
