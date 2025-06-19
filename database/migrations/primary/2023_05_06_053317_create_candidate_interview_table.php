<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateInterviewTable extends Migration
{
    public function up()
    {
        Schema::create('candidate_interview', function (Blueprint $table) {
            $table->unsignedBigInteger('interview_id');
            $table->unsignedBigInteger('candidate_id');

            $table->primary(['interview_id', 'candidate_id']);
            $table->foreign('candidate_id', 'candidate_interview_candidate_id_foreign')->references('id')->on('job_candidates');
            $table->foreign('interview_id', 'candidate_interview_interview_id_foreign')->references('id')->on('job_interviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::table('candidate_interview', function (Blueprint $table) {
            $table->dropForeign('candidate_interview_candidate_id_foreign');
            $table->dropForeign('candidate_interview_interview_id_foreign');
            $table->dropIfExists('candidate_interview');
        });
    }
};
