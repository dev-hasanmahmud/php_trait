<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicator_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('component_id');
            $table->integer('indicator_id');
            $table->double('progress_value')->nullable();
            $table->double('achievement_quantity')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('details')->nullable();
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
        Schema::dropIfExists('indicator_datas');
    }
}
