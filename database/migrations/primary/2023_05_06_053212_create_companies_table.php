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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 191);
            $table->string('company_type', 191);
            $table->string('trading_name', 191)->nullable();
            $table->string('registration_no', 191)->nullable();
            $table->string('contact_no', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('website', 191)->nullable();
            $table->string('tax_no', 191)->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('company_logo', 191)->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();

            $table->foreign('location_id', 'companies_location_id_foreign')->references('id')->on('locations')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_location_id_foreign');
            $table->dropIfExists('companies');
        });
    }
};
