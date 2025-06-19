<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('department_id');
            $table->string('event_title', 191);
            $table->mediumText('event_note');
            $table->date('event_date');
            $table->string('event_time', 191);
            $table->string('status', 30);
            $table->boolean('is_notify')->default(0);
            $table->timestamps();

            $table->foreign('company_id', 'events_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id', 'events_department_id_foreign')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_company_id_foreign');
            $table->dropForeign('events_department_id_foreign');
            $table->dropIfExists('events');
        });
    }
}
