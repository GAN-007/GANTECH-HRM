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
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('document_type', 191)->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'document_types_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (Schema::hasColumn('document_types', 'company_id')) {
        //     Schema::table('document_types', function (Blueprint $table) {
        //         $table->dropForeign('document_types_company_id_foreign');
        //         $table->dropColumn('company_id');
        //         $table->dropIfExists('document_types');
        //     });
        // }else{
        //     Schema::dropIfExists('document_types');
        // }

        Schema::table('document_types', function (Blueprint $table) {
            $table->dropForeign('document_types_company_id_foreign');
            $table->dropIfExists('document_types');
        });
    }
};
