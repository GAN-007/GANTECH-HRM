<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_discussions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->mediumText('project_discussion');
            $table->string('discussion_attachment', 191);
            $table->timestamps();

            $table->foreign('project_id', 'project_discussions_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id', 'project_discussions_user_id_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_discussions', function (Blueprint $table) {
            $table->dropForeign('project_discussions_project_id_foreign');
            $table->dropForeign('project_discussions_user_id_foreign');
            $table->dropIfExists('project_discussions');
        });
    }
}
