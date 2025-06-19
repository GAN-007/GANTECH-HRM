<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeQualificaitonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_qualificaitons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('education_level_id')->nullable();
            $table->string('institution_name', 191);
            $table->date('from_year')->nullable();
            $table->date('to_year')->nullable();
            $table->unsignedBigInteger('language_skill_id')->nullable();
            $table->unsignedBigInteger('general_skill_id')->nullable();
            $table->mediumText('description')->nullable();
            $table->timestamps();

            $table->foreign('education_level_id', 'employee_qualificaitons_education_level_id_foreign')->references('id')->on('qualification_education_levels')->onDelete('set NULL');
            $table->foreign('employee_id', 'employee_qualificaitons_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('general_skill_id', 'employee_qualificaitons_general_skill_id_foreign')->references('id')->on('qualification_skills')->onDelete('set NULL');
            $table->foreign('language_skill_id', 'employee_qualificaitons_language_skill_id_foreign')->references('id')->on('qualification_languages')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_qualificaitons', function (Blueprint $table) {
            $table->dropForeign('employee_qualificaitons_education_level_id_foreign');
            $table->dropForeign('employee_qualificaitons_employee_id_foreign');
            $table->dropForeign('employee_qualificaitons_general_skill_id_foreign');
            $table->dropForeign('employee_qualificaitons_language_skill_id_foreign');
            $table->dropIfExists('employee_qualificaitons');
        });
    }
}
