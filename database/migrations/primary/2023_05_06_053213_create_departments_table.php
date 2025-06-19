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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_name', 191);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_head')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'departments_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            // $table->foreign('department_head', 'departments_department_head_foreign')->references('id')->on('employees')->onDelete('set NULL');
        });
    }

    
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign('departments_company_id_foreign');
            $table->dropIfExists('departments');
        });

        // There was an issue that's why we have to use condition
        // if (Schema::hasTable('departments') && Schema::hasForeignKey('departments','departments_department_head_foreign')) {
            // Schema::table('departments', function (Blueprint $table) {
            //     $table->dropForeign('departments_company_id_foreign');
            //     $table->dropForeign('departments_department_head_foreign');
            //     $table->dropIfExists('departments');
            // });
        // }
        // else{
            // Schema::table('departments', function (Blueprint $table) {
            //     $table->dropForeign('departments_company_id_foreign');
            //     $table->dropIfExists('departments');
            // });
        // }

    }
};
