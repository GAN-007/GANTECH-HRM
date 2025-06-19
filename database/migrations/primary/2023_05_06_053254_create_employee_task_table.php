<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_task', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('task_id');

            $table->primary(['employee_id', 'task_id']);
            $table->foreign('employee_id', 'employee_task_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('task_id', 'employee_task_task_id_foreign')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    
    public function down()
    {
        Schema::table('employee_task', function (Blueprint $table) {
            $table->dropForeign('employee_task_employee_id_foreign');
            $table->dropForeign('employee_task_task_id_foreign');
            $table->dropIfExists('employee_task');
        });
    }
}
