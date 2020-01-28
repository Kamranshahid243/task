<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname');
            $table->string('name');
            $table->float('price')->default(0);
            $table->string('created_by', 50)->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('country_id')->references('id')->on('auc_countries');
            $table->foreign('state_id')->references('id')->on('auc_states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_pricings');
    }
}
