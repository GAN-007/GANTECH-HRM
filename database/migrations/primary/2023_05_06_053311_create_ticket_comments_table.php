<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->mediumText('ticket_comments');
            $table->timestamps();

            $table->foreign('ticket_id', 'ticket_comments_ticket_id_foreign')->references('id')->on('support_tickets')->onDelete('cascade');
            $table->foreign('user_id', 'ticket_comments_user_id_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_comments', function (Blueprint $table) {
            $table->dropForeign('ticket_comments_ticket_id_foreign');
            $table->dropForeign('ticket_comments_user_id_foreign');
            $table->dropIfExists('ticket_comments');
        });
    }
}
