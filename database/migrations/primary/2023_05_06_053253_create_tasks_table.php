<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name', 191);
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('task_hour', 40);
            $table->mediumText('description')->nullable();
            $table->string('task_status', 40)->default('not started');
            $table->mediumText('task_note')->nullable();
            $table->string('task_progress', 191)->nullable();
            $table->boolean('is_notify')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps();

            $table->foreign('added_by', 'tasks_added_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('company_id', 'tasks_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('project_id', 'tasks_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
        });
    }

   
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_added_by_foreign');
            $table->dropForeign('tasks_company_id_foreign');
            $table->dropForeign('tasks_project_id_foreign');
            $table->dropIfExists('tasks');
        });

    }
}
