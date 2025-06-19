<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('travel_type')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('purpose_of_visit', 191)->nullable();
            $table->string('place_of_visit', 191)->nullable();
            $table->string('expected_budget', 20)->nullable();
            $table->string('actual_budget', 20)->nullable();
            $table->string('travel_mode', 20);
            $table->string('status', 30);
            $table->timestamps();

            $table->foreign('company_id', 'travels_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('employee_id', 'travels_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('travel_type', 'travels_travel_type_foreign')->references('id')->on('travel_types')->onDelete('set NULL');
        });
    }

    
    public function down()
    {
        Schema::table('travels', function (Blueprint $table) {
            $table->dropForeign('travels_company_id_foreign');
            $table->dropForeign('travels_employee_id_foreign');
            $table->dropForeign('travels_travel_type_foreign');
            $table->dropIfExists('travels');
        });
    }
}
