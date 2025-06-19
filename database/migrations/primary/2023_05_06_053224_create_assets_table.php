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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name', 50);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('asset_code', 80);
            $table->unsignedBigInteger('assets_category_id');
            $table->mediumText('Asset_note')->nullable();
            $table->string('manufacturer', 191);
            $table->string('serial_number', 191);
            $table->string('invoice_number', 191);
            $table->string('asset_image', 191)->nullable();
            $table->date('purchase_date');
            $table->date('warranty_date');
            $table->string('status', 191);
            $table->timestamps();

            $table->foreign('assets_category_id', 'assets_assets_category_id_foreign')->references('id')->on('asset_categories')->onDelete('cascade');
            $table->foreign('company_id', 'assets_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('employee_id', 'assets_employee_id_foreign')->references('id')->on('employees')->onDelete('set NULL');
        });
    }


    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign('assets_assets_category_id_foreign');
            $table->dropForeign('assets_company_id_foreign');
            $table->dropForeign('assets_employee_id_foreign');
            $table->dropIfExists('assets');
        });
    }
};
