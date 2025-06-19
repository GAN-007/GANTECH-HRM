<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('file_title', 191);
            $table->string('file_attachment', 191);
            $table->mediumText('file_description')->nullable();
            $table->timestamps();

            $table->foreign('project_id', 'project_files_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id', 'project_files_user_id_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_files', function (Blueprint $table) {
            $table->dropForeign('project_files_project_id_foreign');
            $table->dropForeign('project_files_user_id_foreign');
            $table->dropIfExists('project_files');
        });
    }
}
