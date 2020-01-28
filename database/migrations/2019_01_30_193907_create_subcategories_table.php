<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nickname');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->boolean('is_paused')->default(false);
            $table->string('created_by', 50)->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->timestamps();


            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        
        Schema::table('subcategories', function (Blueprint $table) {
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
        Schema::dropIfExists('subcategories');
    }
}
