<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('name', 191)->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'qualification_languages_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qualification_languages', function (Blueprint $table) {
            $table->dropForeign('qualification_languages_company_id_foreign');
            $table->dropIfExists('qualification_languages');
        });
    }
}
