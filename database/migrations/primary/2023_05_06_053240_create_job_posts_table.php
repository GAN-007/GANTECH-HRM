<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('job_category_id');
            $table->string('job_title', 191);
            $table->string('job_type', 191);
            $table->integer('no_of_vacancy');
            $table->string('job_url', 191);
            $table->string('gender', 30);
            $table->string('min_experience', 20);
            $table->mediumText('short_description');
            $table->longText('long_description');
            $table->date('closing_date');
            $table->tinyInteger('status');
            $table->boolean('is_featured');
            $table->timestamps();

            $table->foreign('company_id', 'job_posts_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('job_category_id', 'job_posts_job_category_id_foreign')->references('id')->on('job_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropForeign('job_posts_company_id_foreign');
            $table->dropForeign('job_posts_job_category_id_foreign');
            $table->dropIfExists('job_posts');
        });
    }
}
