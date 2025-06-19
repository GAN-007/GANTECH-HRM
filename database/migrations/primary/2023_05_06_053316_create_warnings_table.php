<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 191);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('warning_to');
            $table->unsignedBigInteger('warning_type')->nullable();
            $table->date('warning_date');
            $table->string('status', 40);
            $table->timestamps();

            $table->foreign('company_id', 'warnings_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('warning_to', 'warnings_warning_to_foreign')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('warning_type', 'warnings_warning_type_foreign')->references('id')->on('warnings_type')->onDelete('set NULL');
        });
    }

    
    public function down()
    {
        Schema::table('warnings', function (Blueprint $table) {
            $table->dropForeign('warnings_company_id_foreign');
            $table->dropForeign('warnings_warning_to_foreign');
            $table->dropForeign('warnings_warning_type_foreign');
            $table->dropIfExists('warnings');
        });
    }
}
