<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_project', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('project_id');

            $table->primary(['employee_id', 'project_id']);
            $table->foreign('employee_id', 'employee_project_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('project_id', 'employee_project_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_project', function (Blueprint $table) {
            $table->dropForeign('employee_project_employee_id_foreign');
            $table->dropForeign('employee_project_project_id_foreign');
            $table->dropIfExists('employee_project');
        });
    }
}
