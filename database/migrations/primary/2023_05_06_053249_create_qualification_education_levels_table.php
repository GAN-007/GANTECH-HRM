<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationEducationLevelsTable extends Migration
{

    public function up()
    {
        Schema::create('qualification_education_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('name', 191)->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'qualification_education_levels_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('qualification_education_levels', function (Blueprint $table) {
            $table->dropForeign('qualification_education_levels_company_id_foreign');
            $table->dropIfExists('qualification_education_levels');
        });

    }
}
