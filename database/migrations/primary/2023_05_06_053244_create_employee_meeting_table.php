<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_meeting', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('meeting_id');

            $table->primary(['employee_id', 'meeting_id']);
            $table->foreign('employee_id', 'employee_meeting_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('meeting_id', 'employee_meeting_meeting_id_foreign')->references('id')->on('meetings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_meeting', function (Blueprint $table) {
            $table->dropForeign('employee_meeting_employee_id_foreign');
            $table->dropForeign('employee_meeting_meeting_id_foreign');
            $table->dropIfExists('employee_meeting');
        });
    }
}




