<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficialDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('official_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('document_type_id')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->string('document_title', 191);
            $table->string('identification_number', 191);
            $table->mediumText('description')->nullable();
            $table->string('document_file', 191)->nullable();
            $table->date('expiry_date');
            $table->boolean('is_notify')->nullable();
            $table->timestamps();

            $table->foreign('added_by', 'official_documents_added_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('company_id', 'official_documents_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('document_type_id', 'official_documents_document_type_id_foreign')->references('id')->on('document_types')->onDelete('set NULL');
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
            $table->dropForeign('official_documents_added_by_foreign');
            $table->dropForeign('official_documents_company_id_foreign');
            $table->dropForeign('official_documents_document_type_id_foreign');
            $table->dropIfExists('official_documents');
        });

    }
}
