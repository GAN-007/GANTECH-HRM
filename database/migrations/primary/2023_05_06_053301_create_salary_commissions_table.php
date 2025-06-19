<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryCommissionsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month_year', 191);
            $table->string('commission_title', 191);
            $table->date('first_date')->nullable();
            $table->string('commission_amount', 191);
            $table->timestamps();

            $table->foreign('employee_id', 'salary_commissions_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_commissions', function (Blueprint $table) {
            $table->dropForeign('salary_commissions_employee_id_foreign');
            $table->dropIfExists('salary_commissions');
        });
    }
}
