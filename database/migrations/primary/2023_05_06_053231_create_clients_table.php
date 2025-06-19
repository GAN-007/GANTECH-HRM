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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('email', 191)->nullable();
            $table->string('contact_no', 15);
            $table->string('username', 64);
            $table->string('profile', 191)->nullable();
            $table->string('company_name', 191);
            $table->string('gender', 40);
            $table->string('website', 40)->nullable();
            $table->mediumText('address1')->nullable();
            $table->mediumText('address2')->nullable();
            $table->string('city', 191)->nullable();
            $table->string('state', 191)->nullable();
            $table->string('zip', 191)->nullable();
            $table->tinyInteger('country')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();

            $table->foreign('id', 'clients_id_foreign')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_id_foreign');
            $table->dropIfExists('clients');
        });
    }
};
