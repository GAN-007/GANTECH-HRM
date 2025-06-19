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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('added_by', 40)->nullable();
            $table->boolean('is_notify')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'announcements_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'announcements_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign('announcements_company_id_foreign');
            $table->dropForeign('announcements_department_id_foreign');
            $table->dropIfExists('announcements');
        });
    }
};
