<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id', 50)->primary();
            $table->string('admin_id', 50)->nullable();
            $table->string('customer_id', 50)->nullable();
            $table->text('title');
            $table->text('description');
            $table->string('status')->default('open');
            $table->timestamp('openend_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
}
