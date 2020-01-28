<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportTicketRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_ticket_replies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('ticket_id', 50);
            $table->string('admin_id', 50)->nullable();
            $table->string('customer_id', 50)->nullable();
            $table->text('description');
            $table->timestamps();

            // $table->index('sender_id');
            // $table->index('recipient_id');
            
            $table->foreign('ticket_id')->references('id')->on('support_tickets');
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
        Schema::dropIfExists('support_ticket_replies');
    }
}
