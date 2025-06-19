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
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('designation_name', 191);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'designations_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id', 'designations_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->dropForeign('designations_company_id_foreign');
            $table->dropForeign('designations_department_id_foreign');
            $table->dropIfExists('designations');
        });
    }
};
