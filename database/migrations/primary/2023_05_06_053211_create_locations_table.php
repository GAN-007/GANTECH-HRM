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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_name', 191);
            $table->unsignedBigInteger('location_head')->nullable();
            $table->string('address1', 191)->nullable();
            $table->string('address2', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->string('state', 191)->nullable();
            $table->unsignedInteger('country')->nullable();
            $table->integer('zip')->nullable();
            $table->timestamps();

            $table->foreign('country', 'locations_country_foreign')->references('id')->on('countries')->onDelete('set NULL');
            // $table->foreign('location_head', 'locations_location_head_foreign')->references('id')->on('employees')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_country_foreign');
            $table->dropIfExists('locations');
        });
    }
};
