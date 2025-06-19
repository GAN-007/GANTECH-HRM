<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('training_types', function (Blueprint $table) {
            $table->dropForeign('training_types_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }

    public function down()
    {
        if(!Schema::hasColumn('training_types', 'company_id')) {
            Schema::table('training_types', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->after('id')->nullable();
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('set NULL');
            });
        }

    }
};
