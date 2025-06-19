<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_lists', function (Blueprint $table) {
            $table->id();
            $table->mediumText('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('training_cost', 191);
            $table->string('status', 30);
            $table->mediumText('remarks')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->unsignedBigInteger('training_type_id')->nullable();
            $table->timestamps();

            $table->foreign('company_id', 'training_lists_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('trainer_id', 'training_lists_trainer_id_foreign')->references('id')->on('trainers')->onDelete('set NULL');
            $table->foreign('training_type_id', 'training_lists_training_type_id_foreign')->references('id')->on('training_types')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_lists', function (Blueprint $table) {
            $table->dropForeign('training_lists_company_id_foreign');
            $table->dropForeign('training_lists_trainer_id_foreign');
            $table->dropForeign('training_lists_training_type_id_foreign');
            $table->dropIfExists('training_lists');
        });
    }
}
