<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('attendance_date');
            $table->string('clock_in', 191);
            $table->string('clock_in_ip', 45);
            $table->string('clock_out', 191);
            $table->string('clock_out_ip', 45);
            $table->tinyInteger('clock_in_out');
            $table->string('time_late', 191)->default('00:00');
            $table->string('early_leaving', 191)->default('00:00');
            $table->string('overtime', 191)->default('00:00');
            $table->string('total_work', 191)->default('00:00');
            $table->string('total_rest', 191)->default('00:00');
            $table->string('attendance_status', 191)->default('present');

            $table->foreign('employee_id', 'attendances_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign('attendances_employee_id_foreign');
            $table->dropIfExists('attendances');
        });
    }
};
