<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('from_department_id')->nullable();
            $table->unsignedBigInteger('to_department_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->date('transfer_date');
            $table->timestamps();

            $table->foreign('company_id', 'transfers_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('employee_id', 'transfers_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('from_department_id', 'transfers_from_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('to_department_id', 'transfers_to_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_company_id_foreign');
            $table->dropForeign('transfers_employee_id_foreign');
            $table->dropForeign('transfers_from_department_id_foreign');
            $table->dropForeign('transfers_to_department_id_foreign');
            $table->dropIfExists('transfers');
        });
    }
}
