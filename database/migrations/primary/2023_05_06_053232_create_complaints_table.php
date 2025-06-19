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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_title', 40);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('complaint_from');
            $table->unsignedBigInteger('complaint_against');
            $table->date('complaint_date');
            $table->string('status', 40);
            $table->timestamps();

            $table->foreign('company_id', 'complaints_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('complaint_against', 'complaints_complaint_against_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('complaint_from', 'complaints_complaint_from_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign('complaints_company_id_foreign');
            $table->dropForeign('complaints_complaint_against_foreign');
            $table->dropForeign('complaints_complaint_from_foreign');
            $table->dropIfExists('complaints');
        });
    }
};
