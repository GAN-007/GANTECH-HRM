<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month_year', 50);
            $table->date('first_date')->nullable();
            $table->string('loan_title', 191);
            $table->string('loan_amount', 191);
            $table->string('loan_type', 191);
            $table->string('loan_time', 191);
            $table->string('amount_remaining', 191);
            $table->string('time_remaining', 191);
            $table->string('monthly_payable', 50);
            $table->mediumText('reason')->nullable();
            $table->timestamps();

            $table->foreign('employee_id', 'salary_loans_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_loans', function (Blueprint $table) {
            $table->dropForeign('salary_loans_employee_id_foreign');
            $table->dropIfExists('salary_loans');
        });

    }
}
