<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('staff_id', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('contact_no', 15)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender', 191)->nullable();
            $table->unsignedBigInteger('office_shift_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('role_users_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->string('marital_status', 191)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 64)->nullable();
            $table->string('state', 64)->nullable();
            $table->string('country', 64)->nullable();
            $table->string('zip_code', 24)->nullable();
            $table->string('cv', 64)->nullable();
            $table->string('skype_id', 64)->nullable();
            $table->string('fb_id', 64)->nullable();
            $table->string('twitter_id', 64)->nullable();
            $table->string('linkedIn_id', 64)->nullable();
            $table->string('whatsapp_id', 64)->nullable();
            $table->double('basic_salary')->default(0);
            $table->string('payslip_type', 191)->nullable();
            $table->string('attendance_type', 191)->nullable();
            $table->string('pension_type', 50)->nullable();
            $table->double('pension_amount', 8, 2)->default(0.00);
            $table->boolean('is_active')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'employees_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('department_id', 'employees_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
            $table->foreign('designation_id', 'employees_designation_id_foreign')->references('id')->on('designations')->onDelete('set NULL');
            $table->foreign('id', 'employees_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('location_id', 'employees_location_id_foreign')->references('id')->on('locations')->onDelete('set NULL');
            $table->foreign('office_shift_id', 'employees_office_shift_id_foreign')->references('id')->on('office_shifts')->onDelete('set NULL');
            $table->foreign('role_users_id', 'employees_role_users_id_foreign')->references('id')->on('roles')->onDelete('set NULL');
            $table->foreign('status_id', 'employees_status_id_foreign')->references('id')->on('statuses')->onDelete('set NULL');
        });
    }


    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_location_id_foreign');
            $table->dropForeign('employees_office_shift_id_foreign');
            $table->dropForeign('employees_role_users_id_foreign');
            $table->dropForeign('employees_status_id_foreign');
            $table->dropForeign('employees_company_id_foreign');
            $table->dropForeign('employees_department_id_foreign');
            $table->dropForeign('employees_designation_id_foreign');
            $table->dropForeign('employees_id_foreign');
            $table->dropIfExists('employees');
        });

    }
};
