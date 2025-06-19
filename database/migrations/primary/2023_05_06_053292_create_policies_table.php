<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('added_by', 40)->nullable()->index('policies_added_by_foreign');
            $table->timestamps();

            $table->foreign('company_id', 'policies_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policies', function (Blueprint $table) {
            $table->dropForeign('policies_company_id_foreign');
            $table->dropIfExists('policies');
        });

    }
}
