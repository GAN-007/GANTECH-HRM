<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_client_id_foreign');
            $table->dropForeign('invoices_project_id_foreign');
            $table->foreign('client_id', 'invoices_client_id_foreign')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('project_id', 'invoices_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_client_id_foreign');
            $table->dropForeign('invoices_project_id_foreign');
            $table->foreign('client_id', 'invoices_client_id_foreign')->references('id')->on('clients')->onDelete('set NULL');
            $table->foreign('project_id', 'invoices_project_id_foreign')->references('id')->on('projects')->onDelete('set NULL');
        });
    }
}
