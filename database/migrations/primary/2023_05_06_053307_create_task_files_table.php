<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('file_title', 191);
            $table->string('file_attachment', 191);
            $table->mediumText('file_description')->nullable();
            $table->timestamps();

            $table->foreign('task_id', 'task_files_task_id_foreign')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id', 'task_files_user_id_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_files', function (Blueprint $table) {
            $table->dropForeign('task_files_task_id_foreign');
            $table->dropForeign('task_files_user_id_foreign');
            $table->dropIfExists('task_files');
        });
    }
}
