<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToOfficialDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('official_documents', function (Blueprint $table) {
            $table->dropForeign('official_documents_company_id_foreign');
            $table->dropForeign('official_documents_document_type_id_foreign');
            $table->foreign('company_id', 'official_documents_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('document_type_id', 'official_documents_document_type_id_foreign')->references('id')->on('document_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('official_documents', function (Blueprint $table) {
            $table->dropForeign('official_documents_company_id_foreign');
            $table->dropForeign('official_documents_document_type_id_foreign');
            $table->foreign('company_id', 'official_documents_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('document_type_id', 'official_documents_document_type_id_foreign')->references('id')->on('document_types')->onDelete('set NULL');
        });
    }
}
