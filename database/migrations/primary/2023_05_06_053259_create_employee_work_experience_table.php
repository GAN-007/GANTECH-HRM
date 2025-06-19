<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeWorkExperienceTable extends Migration
{
    public function up()
    {
        Schema::create('employee_work_experience', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('company_name', 191);
            $table->date('from_year')->nullable();
            $table->date('to_year')->nullable();
            $table->string('post', 191);
            $table->mediumText('description')->nullable();
            $table->timestamps();

            $table->foreign('employee_id', 'employee_work_experience_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_work_experience', function (Blueprint $table) {
            $table->dropForeign('employee_work_experience_employee_id_foreign');
            $table->dropIfExists('employee_work_experience');
        });
    }
}
