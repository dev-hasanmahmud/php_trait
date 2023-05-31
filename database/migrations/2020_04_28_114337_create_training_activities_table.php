<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_activities', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('training_category_id')->nullable();
            $table->integer('training_id')->nullable();
            $table->integer('number_of_event')->nullable();
            $table->integer('number_of_batch')->nullable();
            $table->text('reference')->nullable();
            $table->integer('number_of_benefactor')->nullable();
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_activities');
    }
}
