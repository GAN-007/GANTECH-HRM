<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('meeting_title', 191);
            $table->mediumText('meeting_note');
            $table->date('meeting_date');
            $table->string('meeting_time', 191);
            $table->string('status', 30);
            $table->boolean('is_notify')->default(0);
            $table->timestamps();

            $table->foreign('company_id', 'meetings_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropForeign('meetings_company_id_foreign');
            $table->dropIfExists('meetings');
        });
    }
}
