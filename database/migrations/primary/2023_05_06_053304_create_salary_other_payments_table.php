<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryOtherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_other_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month_year', 50)->default('');
            $table->date('first_date')->nullable();
            $table->string('other_payment_title', 191);
            $table->string('other_payment_amount', 191);
            $table->timestamps();

            $table->foreign('employee_id', 'salary_other_payments_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_other_payments', function (Blueprint $table) {
            $table->dropForeign('salary_other_payments_employee_id_foreign');
            $table->dropIfExists('salary_other_payments');
        });
    }
}
