<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->string('full_name', 191);
            $table->string('email', 191);
            $table->string('phone', 191);
            $table->text('address')->nullable();
            $table->longText('cover_letter');
            $table->string('fb_id', 191)->nullable();
            $table->string('linkedin_id', 191)->nullable();
            $table->string('cv', 191);
            $table->string('status', 191);
            $table->string('remarks', 191);
            $table->timestamps();

            $table->foreign('job_id', 'job_candidates_job_id_foreign')->references('id')->on('job_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_candidates', function (Blueprint $table) {
            $table->dropForeign('job_candidates_job_id_foreign');
            $table->dropIfExists('job_candidates');
        });
    }
}
