<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_discussions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->mediumText('task_discussion');
            $table->timestamps();

            $table->foreign('task_id', 'task_discussions_task_id_foreign')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id', 'task_discussions_user_id_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_discussions', function (Blueprint $table) {
            $table->dropForeign('task_discussions_task_id_foreign');
            $table->dropForeign('task_discussions_user_id_foreign');
            $table->dropIfExists('task_discussions');
        });
    }
}
