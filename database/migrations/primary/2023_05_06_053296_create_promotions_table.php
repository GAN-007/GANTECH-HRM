<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('promotion_title', 40);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('employee_id');
            $table->date('promotion_date');
            $table->timestamps();

            $table->foreign('company_id', 'promotions_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('employee_id', 'promotions_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropForeign('promotions_company_id_foreign');
            $table->dropForeign('promotions_employee_id_foreign');
            $table->dropIfExists('promotions');
        });
    }
}
