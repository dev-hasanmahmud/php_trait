<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_indicators', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->unsignedInteger('activity_category_id');
            $table->unsignedInteger('component_id');
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
        Schema::dropIfExists('activity_indicators');
    }
}
