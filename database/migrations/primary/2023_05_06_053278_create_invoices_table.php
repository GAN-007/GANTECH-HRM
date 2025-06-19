<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 191);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->date('invoice_date');
            $table->date('invoice_due_date');
            $table->double('sub_total');
            $table->tinyInteger('discount_type')->nullable();
            $table->double('discount_figure');
            $table->double('total_tax');
            $table->double('total_discount');
            $table->double('grand_total');
            $table->mediumText('invoice_note')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();

            $table->foreign('client_id', 'invoices_client_id_foreign')->references('id')->on('clients')->onDelete('set NULL');
            $table->foreign('project_id', 'invoices_project_id_foreign')->references('id')->on('projects')->onDelete('set NULL');
        });
    }


    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_client_id_foreign');
            $table->dropForeign('invoices_project_id_foreign');
            $table->dropIfExists('invoices');
        });
    }
}
