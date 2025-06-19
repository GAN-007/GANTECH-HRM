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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('username', 64);
            $table->string('email', 64)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->string('profile_photo', 191)->nullable();
            $table->string('profile_bg', 191)->nullable();
            $table->unsignedBigInteger('role_users_id');
            $table->boolean('is_active')->nullable();
            $table->string('contact_no', 15);
            $table->string('last_login_ip', 32)->nullable();
            $table->timestamp('last_login_date', 2)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('role_users_id', 'users_role_users_id_foreign')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_users_id_foreign');
            $table->dropIfExists('users');
        });
    }
};
