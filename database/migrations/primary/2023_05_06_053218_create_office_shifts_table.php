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
        Schema::create('office_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name', 191);
            $table->string('default_shift', 191)->nullable();
            $table->unsignedBigInteger('company_id');
            $table->string('sunday_in', 191)->nullable();
            $table->string('sunday_out', 191)->nullable();
            $table->string('saturday_in', 191)->nullable();
            $table->string('saturday_out', 191)->nullable();
            $table->string('friday_in', 191)->nullable();
            $table->string('friday_out', 191)->nullable();
            $table->string('thursday_in', 191)->nullable();
            $table->string('thursday_out', 191)->nullable();
            $table->string('wednesday_in', 191)->nullable();
            $table->string('wednesday_out', 191)->nullable();
            $table->string('tuesday_in', 191)->nullable();
            $table->string('tuesday_out', 191)->nullable();
            $table->string('monday_in', 191)->nullable();
            $table->string('monday_out', 191)->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'office_shifts_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('office_shifts', function (Blueprint $table) {
            $table->dropForeign('office_shifts_company_id_foreign');
            $table->dropIfExists('office_shifts');
        });
    }
};
