<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToTravelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travels', function (Blueprint $table) {
            $table->dropForeign('travels_travel_type_foreign');
            $table->foreign('travel_type', 'travels_travel_type_foreign')->references('id')->on('travel_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('travels', function (Blueprint $table) {
            $table->dropForeign('travels_travel_type_foreign');
            $table->foreign('travel_type', 'travels_travel_type_foreign')->references('id')->on('travel_types')->onDelete('set NULL');
        });
    }
}
