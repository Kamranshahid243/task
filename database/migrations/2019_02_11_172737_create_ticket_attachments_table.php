<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('ticket_id', 50)->nullable();
            $table->string('user_id', 50)->nullable();
            $table->string('filename')->nullable();
            $table->string('type', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->string('attachment_local_path');
            $table->string('attachment_public_path');
            $table->timestamps();

            $table->index('ticket_id');
            $table->index('user_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_attachments');
    }
}
