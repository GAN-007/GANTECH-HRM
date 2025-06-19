<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('ticket_code', 15)->unique('support_tickets_ticket_code_unique');
            $table->string('subject', 191);
            $table->string('ticket_priority', 40);
            $table->mediumText('description')->nullable();
            $table->mediumText('ticket_remarks')->nullable();
            $table->string('ticket_status', 40);
            $table->string('ticket_note', 191)->nullable();
            $table->boolean('is_notify')->nullable();
            $table->string('ticket_attachment', 191)->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'support_tickets_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id', 'support_tickets_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
            $table->foreign('employee_id', 'support_tickets_employee_id_foreign')->references('id')->on('employees')->onDelete('set NULL');
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
            $table->dropIfExists('support_tickets');
        });
    }
}
