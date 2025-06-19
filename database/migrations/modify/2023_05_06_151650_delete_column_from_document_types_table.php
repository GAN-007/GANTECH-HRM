<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnFromDocumentTypesTable extends Migration
{
    public function up()
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->dropForeign('document_types_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }

    public function down()
    {
        if(!Schema::hasColumn('document_types', 'company_id')) {
            Schema::table('document_types', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->after('id')->nullable();
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('set NULL');
            });
        }

    }
}
