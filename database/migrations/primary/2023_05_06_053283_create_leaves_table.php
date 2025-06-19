<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->mediumText('leave_reason')->nullable();
            $table->string('remarks', 191)->nullable();
            $table->string('status', 40);
            $table->boolean('is_notify')->default(0);
            $table->timestamps();

            $table->foreign('company_id', 'leaves_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'leaves_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employee_id', 'leaves_employee_id_foreign')->references('id')->on('employees')->onDelete('set NULL');
            $table->foreign('leave_type_id', 'leaves_leave_type_id_foreign')->references('id')->on('leave_types')->onDelete('set NULL');
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
            $table->dropForeign('leaves_company_id_foreign');
            $table->dropForeign('leaves_department_id_foreign');
            $table->dropForeign('leaves_employee_id_foreign');
            $table->dropForeign('leaves_leave_type_id_foreign');
            $table->dropIfExists('leaves');
        });
    }
}
