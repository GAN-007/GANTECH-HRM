<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('from_account_id')->nullable();
            $table->unsignedBigInteger('to_account_id')->nullable();
            $table->string('amount', 30);
            $table->string('reference', 191);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'finance_transfers_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('from_account_id', 'finance_transfers_from_account_id_foreign')->references('id')->on('finance_bank_cashes')->onDelete('set NULL');
            $table->foreign('payment_method_id', 'finance_transfers_payment_method_id_foreign')->references('id')->on('payment_methods')->onDelete('set NULL');
            $table->foreign('to_account_id', 'finance_transfers_to_account_id_foreign')->references('id')->on('finance_bank_cashes')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_transfers', function (Blueprint $table) {
            $table->dropForeign('finance_transfers_company_id_foreign');
            $table->dropForeign('finance_transfers_from_account_id_foreign');
            $table->dropForeign('finance_transfers_payment_method_id_foreign');
            $table->dropForeign('finance_transfers_to_account_id_foreign');
            $table->dropIfExists('finance_transfers');
        });
    }
}
