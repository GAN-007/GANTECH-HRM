<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToTravelTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travel_types', function (Blueprint $table) {
             $table->dropForeign(['company_id']);
             $table->foreign('company_id')->references('id')->on('companies')->onDelete('CASCADE');

            // $table->foreign('company_id', 'travel_types_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travel_types', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set NULL');

            // $table->foreign('company_id', 'travel_types_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('set NULL')->onUpdate('set NULL');
        });
    }
}
