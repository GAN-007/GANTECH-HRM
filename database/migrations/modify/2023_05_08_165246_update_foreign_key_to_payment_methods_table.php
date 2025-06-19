<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign('payment_methods_company_id_foreign');
            $table->foreign('company_id', 'payment_methods_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign('payment_methods_company_id_foreign');
            $table->foreign('company_id', 'payment_methods_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }
}
