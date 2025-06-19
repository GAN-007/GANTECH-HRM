<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('email', 191);
            $table->string('contact_no', 15);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->mediumText('address')->nullable();
            $table->mediumText('expertise');
            $table->string('status', 30);
            $table->timestamps();

            $table->foreign('company_id', 'trainers_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropForeign('trainers_company_id_foreign');
            $table->dropIfExists('trainers');
        });
    }
}
