<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nickname');
            $table->string('name');
            
            $table->timestamps();
            $table->string('created_by', 50)->nullable();
           

        });

        //Roles
        $roles = ['superadmin', 'admin', 'customer'];
        $role_names = ['Super Admin', 'Admin', 'Customer'];  

        foreach($roles as $index=>$role){

            DB::table('roles')->insert([
                'nickname' => $role,
                'name' => $role_names[$index],
                
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
