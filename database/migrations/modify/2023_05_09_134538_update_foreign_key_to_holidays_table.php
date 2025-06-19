<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('holidays', function (Blueprint $table) {
            $table->dropForeign('holidays_company_id_foreign');
            $table->dropForeign('holidays_department_id_foreign');

            $table->foreign('company_id', 'holidays_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'holidays_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('holidays', function (Blueprint $table) {
            $table->dropForeign('holidays_company_id_foreign');
            $table->dropForeign('holidays_department_id_foreign');

            $table->foreign('company_id', 'holidays_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id', 'holidays_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
        });
    }
}
