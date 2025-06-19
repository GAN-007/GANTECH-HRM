<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeInterviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_interview', function (Blueprint $table) {
            $table->unsignedBigInteger('interview_id');
            $table->unsignedBigInteger('employee_id');

            $table->primary(['interview_id', 'employee_id']);
            $table->foreign('employee_id', 'employee_interview_employee_id_foreign')->references('id')->on('employees');
            $table->foreign('interview_id', 'employee_interview_interview_id_foreign')->references('id')->on('job_interviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_interview', function (Blueprint $table) {
            $table->dropForeign('employee_interview_employee_id_foreign');
            $table->dropForeign('employee_interview_interview_id_foreign');
            $table->dropIfExists('employee_interview');
        });
    }
}
