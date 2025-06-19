<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToFileManagersTable extends Migration
{
    public function up()
    {
        Schema::table('file_managers', function (Blueprint $table) {
            $table->dropForeign('file_managers_department_id_foreign');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('file_managers', function (Blueprint $table) {
            $table->dropForeign('file_managers_department_id_foreign');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set NULL');
        });
    }
}
