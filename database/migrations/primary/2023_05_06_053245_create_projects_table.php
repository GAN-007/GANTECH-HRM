<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('project_priority', 40);
            $table->mediumText('description')->nullable();
            $table->mediumText('summary')->nullable();
            $table->string('project_status', 40)->default('not started');
            $table->longText('project_note')->nullable();
            $table->string('project_progress', 191)->nullable();
            $table->boolean('is_notify')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps();

            $table->foreign('added_by', 'projects_added_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('client_id', 'projects_client_id_foreign')->references('id')->on('clients')->onDelete('set NULL');
            $table->foreign('company_id', 'projects_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_added_by_foreign');
            $table->dropForeign('projects_client_id_foreign');
            $table->dropForeign('projects_company_id_foreign');
            $table->dropIfExists('projects');
        });

    }
}
