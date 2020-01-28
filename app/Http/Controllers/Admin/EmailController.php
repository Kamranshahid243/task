<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function storeTemplate(Request $request)
    {
        $template=new EmailTemplate();
        $template->body=$request->body;
        $template->role_id=$request->role_id;
        if($template->save()){
            return "template created.";
        }
        return abort(404,"Error while creating template.");
    }
}
