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
        Schema::create('employee_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('account_title', 191);
            $table->string('account_number', 191);
            $table->string('bank_name', 191);
            $table->string('bank_code', 191);
            $table->string('bank_branch', 191);
            $table->timestamps();

            $table->foreign('employee_id', 'employee_bank_accounts_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_bank_accounts', function (Blueprint $table) {
            $table->dropForeign('employee_bank_accounts_employee_id_foreign');
            $table->dropIfExists('employee_bank_accounts');
        });
    }
};
