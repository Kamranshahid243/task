<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatePricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname');
            $table->string('name');
            $table->float('price')->default(0);
            $table->string('created_by', 50)->nullable();
            $table->unsignedBigInteger('country_id');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('country_id')->references('id')->on('auc_countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_pricings');
    }
}
