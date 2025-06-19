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
        Schema::create('employee_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('relation', 50);
            $table->boolean('is_primary')->default(0);
            $table->boolean('is_dependent')->default(0);
            $table->string('contact_name', 191);
            $table->string('work_phone', 191)->nullable();
            $table->string('work_phone_ext', 191)->nullable();
            $table->string('personal_phone', 191)->nullable();
            $table->string('home_phone', 191)->nullable();
            $table->string('work_email', 191)->nullable();
            $table->string('personal_email', 191)->nullable();
            $table->string('address1', 191)->nullable();
            $table->string('address2', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->string('state', 191)->nullable();
            $table->string('zip', 191)->nullable();
            $table->integer('country_id');
            $table->timestamps();

            $table->foreign('employee_id', 'employee_contacts_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('employee_contacts', function (Blueprint $table) {
            $table->dropForeign('employee_contacts_employee_id_foreign');
            $table->dropIfExists('employee_contacts');
        });
    }
};
