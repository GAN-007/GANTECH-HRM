<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('method_name', 40);
            $table->string('payment_percentage', 100)->nullable();
            $table->string('account_number', 100)->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'payment_methods_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
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
            $table->dropIfExists('payment_methods');
        });

    }
}
