<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nickname');
            $table->string('name');
            
            $table->timestamps();
        });

        DB::table('genders')->insert([ 'nickname' => 'male','name' => 'Male', ]);
        DB::table('genders')->insert([ 'nickname' => 'female','name' => 'Female', ]);
           
            
            
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
}
