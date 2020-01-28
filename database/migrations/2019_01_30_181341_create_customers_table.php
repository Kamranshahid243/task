<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id', 50)->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('opassword')->nullable();
            $table->unsignedTinyInteger('gender_id')->nullable();
            $table->string('avatar')->default('/assets/images/avatars/male.png');
            $table->string('mobile')->nullable();
            $table->integer('role_id')->unsigned();
            $table->unsignedMediumInteger('country_id')->index()->nullable();
            $table->unsignedMediumInteger('state_id')->index()->nullable();
            $table->unsignedMediumInteger('city_id')->index()->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->boolean('is_login_approval_code_on')->default(0);
            $table->string('login_approval_code')->nullable();
            $table->boolean('is_login_otp_on')->default(0);
            $table->boolean('is_login_password_expiry_on')->default(0);
            $table->string('time_unit', 20)->nullable();
            $table->unsignedTinyInteger('time_unit_id')->nullable();
            $table->timestamp('time_to_expire')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('gender_id')->references('id')->on('genders');
        });

        Schema::table('customers', function (Blueprint $table) {
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
        Schema::dropIfExists('customers');
    }
}
