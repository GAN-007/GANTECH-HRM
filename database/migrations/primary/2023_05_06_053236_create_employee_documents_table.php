<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('document_type_id')->nullable();
            $table->string('document_title', 191);
            $table->mediumText('description')->nullable();
            $table->string('document_file', 191)->nullable();
            $table->date('expiry_date');
            $table->boolean('is_notify')->nullable();
            $table->timestamps();

            $table->foreign('document_type_id', 'employee_documents_document_type_id_foreign')->references('id')->on('document_types')->onDelete('set NULL');
            $table->foreign('employee_id', 'employee_documents_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_documents', function (Blueprint $table) {
            $table->dropForeign('employee_documents_document_type_id_foreign');
            $table->dropForeign('employee_documents_employee_id_foreign');
            $table->dropIfExists('employee_documents');
        });
    }
};
