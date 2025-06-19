<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resignations', function (Blueprint $table) {
            $table->id();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->date('notice_date')->nullable();
            $table->date('resignation_date');
            $table->timestamps();

            $table->foreign('company_id', 'resignations_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'resignations_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employee_id', 'resignations_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resignations', function (Blueprint $table) {
            $table->dropForeign('resignations_company_id_foreign');
            $table->dropForeign('resignations_department_id_foreign');
            $table->dropForeign('resignations_employee_id_foreign');
            $table->dropIfExists('resignations');
        });
    }
}
