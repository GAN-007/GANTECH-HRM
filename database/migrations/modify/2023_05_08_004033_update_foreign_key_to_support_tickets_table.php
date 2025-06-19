<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropForeign('support_tickets_company_id_foreign');
            $table->dropForeign('support_tickets_department_id_foreign');
            $table->dropForeign('support_tickets_employee_id_foreign');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropForeign('support_tickets_company_id_foreign');
            $table->dropForeign('support_tickets_department_id_foreign');
            $table->dropForeign('support_tickets_employee_id_foreign');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set NULL');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set NULL');
        });
    }
}
