<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_bugs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->mediumText('title');
            $table->string('bug_attachment', 191)->nullable();
            $table->string('status', 191)->default('pending');
            $table->timestamps();

            $table->foreign('project_id', 'project_bugs_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id', 'project_bugs_user_id_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_bugs', function (Blueprint $table) {
            $table->dropForeign('project_bugs_project_id_foreign');
            $table->dropForeign('project_bugs_user_id_foreign');
            $table->dropIfExists('project_bugs');
        });
    }
}
