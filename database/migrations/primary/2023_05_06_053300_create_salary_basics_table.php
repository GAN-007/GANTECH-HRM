<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_basics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month_year', 191);
            $table->date('first_date')->nullable();
            $table->string('payslip_type', 191);
            $table->double('basic_salary')->default(0);
            $table->timestamps();

            $table->foreign('employee_id', 'salary_basics_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_basics', function (Blueprint $table) {
            $table->dropForeign('salary_basics_employee_id_foreign');
            $table->dropIfExists('salary_basics');
        });
    }
}
