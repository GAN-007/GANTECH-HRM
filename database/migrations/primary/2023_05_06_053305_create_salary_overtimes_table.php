<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month_year', 50);
            $table->date('first_date')->nullable();
            $table->string('overtime_title', 191);
            $table->string('no_of_days', 191);
            $table->string('overtime_hours', 191);
            $table->string('overtime_rate', 191);
            $table->string('overtime_amount', 191);
            $table->timestamps();

            $table->foreign('employee_id', 'salary_overtimes_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('salary_overtimes', function (Blueprint $table) {
            $table->dropForeign('salary_overtimes_employee_id_foreign');
            $table->dropIfExists('salary_overtimes');
        });
    }
}
