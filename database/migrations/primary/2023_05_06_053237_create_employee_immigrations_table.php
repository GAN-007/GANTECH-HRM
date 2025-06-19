<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeImmigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_immigrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('document_type_id')->nullable();
            $table->string('document_number', 191);
            $table->string('document_file', 191)->nullable();
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->date('eligible_review_date')->nullable();
            $table->integer('country_id');
            $table->timestamps();

            $table->foreign('document_type_id', 'employee_immigrations_document_type_id_foreign')->references('id')->on('document_types')->onDelete('set NULL');
            $table->foreign('employee_id', 'employee_immigrations_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_immigrations', function (Blueprint $table) {
            $table->dropForeign('employee_immigrations_document_type_id_foreign');
            $table->dropForeign('employee_immigrations_employee_id_foreign');
            $table->dropIfExists('employee_immigrations');
        });
    }
}
