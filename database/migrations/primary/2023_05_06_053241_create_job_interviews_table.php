<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_interviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->string('interview_place', 191);
            $table->date('interview_date');
            $table->time('interview_time');
            $table->longText('description');
            $table->timestamps();

            $table->foreign('added_by', 'job_interviews_added_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('job_id', 'job_interviews_job_id_foreign')->references('id')->on('job_posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('job_interviews', function (Blueprint $table) {
            $table->dropForeign('job_interviews_added_by_foreign');
            $table->dropForeign('job_interviews_job_id_foreign');
            $table->dropIfExists('job_interviews');
        });
    }
}
