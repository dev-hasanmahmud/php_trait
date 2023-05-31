<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_targets', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('package_id')->nullable();
            $table->date('date')->nullable();
            $table->integer('target_qty')->nullable();
            $table->double('gov_amount')->nullable();
            $table->double('pa_amount')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('financial_targets');
    }
}
