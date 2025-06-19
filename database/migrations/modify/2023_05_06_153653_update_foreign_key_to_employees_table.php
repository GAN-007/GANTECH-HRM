<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_company_id_foreign');
            $table->dropForeign('employees_department_id_foreign');
            $table->dropForeign('employees_designation_id_foreign');

            $table->foreign('company_id', 'employees_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'employees_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('designation_id', 'employees_designation_id_foreign')->references('id')->on('designations')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_company_id_foreign');
            $table->dropForeign('employees_department_id_foreign');
            $table->dropForeign('employees_designation_id_foreign');
            
            $table->foreign('company_id', 'employees_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id', 'employees_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
            $table->foreign('designation_id', 'employees_designation_id_foreign')->references('id')->on('designations')->onDelete('set NULL');
        });
    }
}
