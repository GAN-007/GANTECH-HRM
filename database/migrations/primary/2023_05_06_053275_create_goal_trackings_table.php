<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('goal_type_id');
            $table->string('subject', 191);
            $table->string('target_achievement', 191);
            $table->text('description')->nullable();
            $table->string('start_date', 191);
            $table->string('end_date', 191);
            $table->integer('progress');
            $table->string('status', 191)->nullable();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('goal_trackings');
    }
}
