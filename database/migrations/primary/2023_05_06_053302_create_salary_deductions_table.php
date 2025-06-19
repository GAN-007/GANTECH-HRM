<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_deductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month_year', 50);
            $table->date('first_date')->nullable();
            $table->string('deduction_title', 191);
            $table->string('deduction_amount', 191);
            $table->string('deduction_type', 191);
            $table->timestamps();

            $table->foreign('employee_id', 'salary_deductions_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_deductions', function (Blueprint $table) {
            $table->dropForeign('salary_deductions_employee_id_foreign');
            $table->dropIfExists('salary_deductions');
        });
    }
}
