<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->uuid('payslip_key');
            $table->string('payslip_number', 191)->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('company_id');
            $table->string('payment_type', 191);
            $table->double('basic_salary');
            $table->double('net_salary');
            $table->text('allowances');
            $table->text('commissions');
            $table->text('loans');
            $table->text('deductions');
            $table->text('overtimes');
            $table->text('other_payments');
            $table->string('pension_type', 50)->nullable();
            $table->double('pension_amount');
            $table->integer('hours_worked');
            $table->tinyInteger('status');
            $table->string('month_year', 15);
            $table->timestamps();

            $table->foreign('employee_id', 'payslips_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropForeign('payslips_employee_id_foreign');
            $table->dropIfExists('payslips');
        });

    }
}
