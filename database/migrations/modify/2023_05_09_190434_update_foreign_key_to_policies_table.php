<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policies', function (Blueprint $table) {
            $table->dropForeign('policies_company_id_foreign');
            $table->foreign('company_id', 'policies_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policies', function (Blueprint $table) {
            $table->dropForeign('policies_company_id_foreign');
            $table->foreign('company_id', 'policies_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }
}
