<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('type', 40);
            $table->timestamps();

            $table->foreign('company_id', 'expense_types_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_types', function (Blueprint $table) {
            $table->dropForeign('expense_types_company_id_foreign');
            $table->dropIfExists('expense_types');
        });
    }
}
