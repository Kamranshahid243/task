<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVipAdPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_ad_pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->string('nickname');
            $table->string('name');
            $table->string('created_by', 50)->nullable();
            
            $table->timestamps();
            $table->string('created_by', 50)->nullable();
        });


        DB::table('vip_ad_pages')->insert(['nickname' => 'page-1', 'name' => 'Page 1']);
        DB::table('vip_ad_pages')->insert(['nickname' => 'page-2', 'name' => 'Page 2']);
        DB::table('vip_ad_pages')->insert(['nickname' => 'page-3', 'name' => 'Page 3']);
        DB::table('vip_ad_pages')->insert(['nickname' => 'page-4', 'name' => 'Page 4']);
        DB::table('vip_ad_pages')->insert(['nickname' => 'page-5', 'name' => 'Page 5']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vip_ad_pages');
    }
}
