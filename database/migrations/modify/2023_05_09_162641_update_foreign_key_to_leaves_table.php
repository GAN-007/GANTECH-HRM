<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign('leaves_employee_id_foreign');
            $table->dropForeign('leaves_leave_type_id_foreign');
            $table->foreign('employee_id', 'leaves_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('leave_type_id', 'leaves_leave_type_id_foreign')->references('id')->on('leave_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign('leaves_employee_id_foreign');
            $table->dropForeign('leaves_leave_type_id_foreign');
            $table->foreign('employee_id', 'leaves_employee_id_foreign')->references('id')->on('employees')->onDelete('set NULL');
            $table->foreign('leave_type_id', 'leaves_leave_type_id_foreign')->references('id')->on('leave_types')->onDelete('set NULL');
        });
    }
}
