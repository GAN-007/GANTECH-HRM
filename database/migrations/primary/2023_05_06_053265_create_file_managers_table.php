<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_managers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->string('file_name', 191);
            $table->string('file_size', 191)->nullable();
            $table->string('file_extension', 191)->nullable();
            $table->string('external_link', 191)->nullable();
            $table->timestamps();

            $table->foreign('department_id', 'file_managers_department_id_foreign')->references('id')->on('departments')->onDelete('set NULL');
            $table->foreign('added_by', 'file_managers_added_by_foreign')->references('id')->on('users')->onDelete('set NULL');
        });
    }


    public function down()
    {
        Schema::table('file_managers', function (Blueprint $table) {
            $table->dropForeign('file_managers_department_id_foreign');
            $table->dropForeign('file_managers_added_by_foreign');
            $table->dropIfExists('file_managers');
        });
    }
}
