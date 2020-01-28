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
            $table->string('coins');
            $table->float('price')->default(0);
            $table->string('created_by', 50)->nullable();
            $table->boolean('is_paused')->default(false);
            $table->timestamps();
           
        });

        DB::table('plans')->insert([ 'coins' => 0, 'price' => 0, 'nickname' => 'free', 'name' => 'Free']);
        DB::table('plans')->insert([ 'coins' => 100, 'price' => 10, 'nickname' => 'silver', 'name' => 'Silver']);
        DB::table('plans')->insert([ 'coins' => 200, 'price' => 20, 'nickname' => 'bronze', 'name' => 'Bronze']);
        DB::table('plans')->insert([ 'coins' => 350, 'price' => 30, 'nickname' => 'gold', 'name' => 'Gold']);
        DB::table('plans')->insert([ 'coins' => 500, 'price' => 40, 'nickname' => 'platinum', 'name' => 'Platinum']);
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
