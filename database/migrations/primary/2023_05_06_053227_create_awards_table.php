<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->mediumText('award_information')->nullable();
            $table->date('award_date');
            $table->string('gift', 40)->nullable();
            $table->string('cash', 40)->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('award_type_id')->nullable();
            $table->string('award_photo', 191)->nullable();
            $table->timestamps();

            $table->foreign('award_type_id', 'awards_award_type_id_foreign')->references('id')->on('award_types')->onDelete('set NULL');
            $table->foreign('company_id', 'awards_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id', 'awards_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
            $table->foreign('employee_id', 'awards_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->dropForeign('awards_employee_id_foreign');
            $table->dropIfExists('awards');
        });
    }
};
