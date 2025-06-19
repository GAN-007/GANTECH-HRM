<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToFinanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_transactions', function (Blueprint $table) {
            $table->dropForeign('finance_transactions_account_id_foreign');
            $table->dropForeign('finance_transactions_category_id_foreign');
            $table->dropForeign('finance_transactions_company_id_foreign');
            $table->dropForeign('finance_transactions_payee_id_foreign');
            $table->dropForeign('finance_transactions_payer_id_foreign');
            $table->dropForeign('finance_transactions_payment_method_id_foreign');

            $table->foreign('account_id', 'finance_transactions_account_id_foreign')->references('id')->on('finance_bank_cashes')->onDelete('cascade');
            $table->foreign('category_id', 'finance_transactions_category_id_foreign')->references('id')->on('expense_types')->onDelete('cascade');
            $table->foreign('company_id', 'finance_transactions_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('payee_id', 'finance_transactions_payee_id_foreign')->references('id')->on('finance_payees')->onDelete('cascade');
            $table->foreign('payer_id', 'finance_transactions_payer_id_foreign')->references('id')->on('finance_payers')->onDelete('cascade');
            $table->foreign('payment_method_id', 'finance_transactions_payment_method_id_foreign')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_transactions', function (Blueprint $table) {
            $table->dropForeign('finance_transactions_account_id_foreign');
            $table->dropForeign('finance_transactions_category_id_foreign');
            $table->dropForeign('finance_transactions_company_id_foreign');
            $table->dropForeign('finance_transactions_payee_id_foreign');
            $table->dropForeign('finance_transactions_payer_id_foreign');
            $table->dropForeign('finance_transactions_payment_method_id_foreign');

            $table->foreign('account_id', 'finance_transactions_account_id_foreign')->references('id')->on('finance_bank_cashes')->onDelete('set NULL');
            $table->foreign('category_id', 'finance_transactions_category_id_foreign')->references('id')->on('expense_types')->onDelete('set NULL');
            $table->foreign('company_id', 'finance_transactions_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('payee_id', 'finance_transactions_payee_id_foreign')->references('id')->on('finance_payees')->onDelete('set NULL');
            $table->foreign('payer_id', 'finance_transactions_payer_id_foreign')->references('id')->on('finance_payers')->onDelete('set NULL');
            $table->foreign('payment_method_id', 'finance_transactions_payment_method_id_foreign')->references('id')->on('payment_methods')->onDelete('set NULL');
        });
    }
}
