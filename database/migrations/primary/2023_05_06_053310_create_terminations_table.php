<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminations', function (Blueprint $table) {
            $table->id();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('terminated_employee');
            $table->unsignedBigInteger('termination_type')->nullable();
            $table->date('termination_date');
            $table->date('notice_date');
            $table->string('status', 40);
            $table->timestamps();

            $table->foreign('company_id', 'terminations_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('terminated_employee', 'terminations_terminated_employee_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('termination_type', 'terminations_termination_type_foreign')->references('id')->on('termination_types')->onDelete('set NULL');
        });
    }

    
    public function down()
    {
        Schema::table('terminations', function (Blueprint $table) {
            $table->dropForeign('terminations_company_id_foreign');
            $table->dropForeign('terminations_terminated_employee_foreign');
            $table->dropForeign('terminations_termination_type_foreign');
            $table->dropIfExists('terminations');
        });
    }
}
