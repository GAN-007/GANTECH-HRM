<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceBankCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_bank_cashes', function (Blueprint $table) {
            $table->id();
            $table->string('account_name', 50);
            $table->string('account_balance', 191);
            $table->string('initial_balance', 191);
            $table->string('account_number', 191);
            $table->string('branch_code', 191);
            $table->string('bank_branch', 191);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_bank_cashes');
    }
}
