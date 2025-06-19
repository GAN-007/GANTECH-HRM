<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyToTerminationsTable extends Migration
{
    
    public function up()
    {
        Schema::table('terminations', function (Blueprint $table) {
            $table->dropForeign('terminations_termination_type_foreign');
            $table->foreign('termination_type', 'terminations_termination_type_foreign')->references('id')->on('termination_types')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('terminations', function (Blueprint $table) {
            $table->dropForeign('terminations_termination_type_foreign');
            $table->foreign('termination_type', 'terminations_termination_type_foreign')->references('id')->on('termination_types')->onDelete('set NULL');
        });
    }
}
