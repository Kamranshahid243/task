<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nickname');
            $table->string('name');
            $table->string('description');
            $table->float('price');
            $table->boolean('is_paused')->default(false);
            $table->string('created_by', 50)->nullable();
         
            $table->timestamps();

  
            $table->foreign('created_by')->references('id')->on('admins');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
