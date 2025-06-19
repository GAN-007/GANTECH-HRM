<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->foreign('company_id', 'indicators_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'indicators_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('designation_id', 'indicators_designation_id_foreign')->references('id')->on('designations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->dropForeign('indicators_company_id_foreign');
            $table->dropForeign('indicators_department_id_foreign');
            $table->dropForeign('indicators_designation_id_foreign');
        });
    }
}
