<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nickname');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->boolean('is_paused')->default(false);
            $table->string('created_by', 50)->nullable();
         
            $table->timestamps();

  
            $table->foreign('created_by')->references('id')->on('admins');
        });

        Schema::table('categories', function (Blueprint $table) {
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
        Schema::dropIfExists('categories');
    }
}
