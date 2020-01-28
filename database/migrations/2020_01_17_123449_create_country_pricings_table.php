<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname');
            $table->string('name');
            $table->float('price')->default(0);
            $table->string('created_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_pricings');
    }
}
