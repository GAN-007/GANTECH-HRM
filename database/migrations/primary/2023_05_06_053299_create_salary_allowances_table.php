<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_allowances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month_year', 191);
            $table->date('first_date')->nullable();
            $table->string('allowance_title', 191);
            $table->string('allowance_amount', 191);
            $table->boolean('is_taxable');
            $table->timestamps();

            $table->foreign('employee_id', 'salary_allowances_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_allowances', function (Blueprint $table) {
            $table->dropForeign('salary_allowances_employee_id_foreign');
            $table->dropIfExists('salary_allowances');
        });
    }
}
