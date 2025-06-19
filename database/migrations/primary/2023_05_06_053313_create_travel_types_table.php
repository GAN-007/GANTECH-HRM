<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_types', function (Blueprint $table) {
            $table->id();
            $table->string('arrangement_type', 191);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'travel_types_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }

    public function down()
    {
        Schema::table('travel_types', function (Blueprint $table) {
            $table->dropForeign('travel_types_company_id_foreign');
            $table->dropIfExists('travel_types');
        });
    }
}
