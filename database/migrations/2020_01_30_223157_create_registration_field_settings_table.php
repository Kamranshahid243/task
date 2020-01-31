<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationFieldSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_field_settings', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nickname', 30);
            $table->string('name', 30);
            $table->boolean('is_disabled')->default(false);
            $table->string('created_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admins');
        });

        DB::table('registration_field_settings')->insert([
            'nickname' => 'first_name',
            'name' => 'First Name',
        ]);
        DB::table('registration_field_settings')->insert([
            'nickname' => 'last_name',
            'name' => 'Last Name',
        ]);
        DB::table('registration_field_settings')->insert([
            'nickname' => 'mobile',
            'name' => 'Mobile',
        ]);
        DB::table('registration_field_settings')->insert([
            'nickname' => 'gender',
            'name' => 'Gender',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_field_settings');
    }
}
