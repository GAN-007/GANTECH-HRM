<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('event_name', 191);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_publish')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'holidays_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id', 'holidays_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
        });
    }

    
    public function down()
    {
        Schema::table('holidays', function (Blueprint $table) {
            $table->dropForeign('holidays_company_id_foreign');
            $table->dropForeign('holidays_department_id_foreign');
            $table->dropIfExists('holidays');
        });
    }
}
