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
        Schema::create('appraisals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('designation_id');
            $table->string('customer_experience', 191);
            $table->string('marketing', 191)->nullable();
            $table->string('administration', 191)->nullable();
            $table->string('professionalism', 191)->nullable();
            $table->string('integrity', 191)->nullable();
            $table->string('attendance', 191)->nullable();
            $table->text('remarks')->nullable();
            $table->string('date', 191)->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'appraisals_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'appraisals_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('designation_id', 'appraisals_designation_id_foreign')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('employee_id', 'appraisals_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->dropForeign('appraisals_company_id_foreign');
            $table->dropForeign('appraisals_department_id_foreign');
            $table->dropForeign('appraisals_designation_id_foreign');
            $table->dropForeign('appraisals_employee_id_foreign');
            $table->dropIfExists('appraisals');
        });
    }
};
