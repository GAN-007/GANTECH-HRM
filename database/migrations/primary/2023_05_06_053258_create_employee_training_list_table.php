<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTrainingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_training_list', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('training_list_id');

            $table->primary(['employee_id', 'training_list_id']);
            $table->foreign('employee_id', 'employee_training_list_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('training_list_id', 'employee_training_list_training_list_id_foreign')->references('id')->on('training_lists')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('employee_training_list', function (Blueprint $table) {
            $table->dropForeign('employee_training_list_employee_id_foreign');
            $table->dropForeign('employee_training_list_training_list_id_foreign');
            $table->dropIfExists('employee_training_list');
        });
    }
}
