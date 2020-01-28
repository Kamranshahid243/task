<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedMediumInteger('country_id')->index()->nullable();
            $table->unsignedMediumInteger('state_id')->index()->nullable();
            $table->unsignedMediumInteger('city_id')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_pricings');
    }
}
