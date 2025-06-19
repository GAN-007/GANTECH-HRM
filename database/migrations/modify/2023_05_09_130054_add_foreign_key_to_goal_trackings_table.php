<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToGoalTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goal_trackings', function (Blueprint $table) {
            $table->foreign('company_id', 'goal_trackings_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('goal_type_id', 'goal_trackings_goal_type_id_foreign')->references('id')->on('goal_types')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('goal_trackings', function (Blueprint $table) {
            $table->dropForeign('goal_trackings_company_id_foreign');
            $table->dropForeign('goal_trackings_goal_type_id_foreign');
        });
    }
}
