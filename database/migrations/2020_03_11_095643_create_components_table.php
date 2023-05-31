<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name_en')->nullable();
            $table->string('name_bn')->nullable();
            $table->integer('type_id')->nullable();
            $table->string('dpp_head')->nullable();
            $table->string('economic_head')->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('qty')->nullable();
            $table->integer('proc_method_id')->nullable();
            $table->integer('approving_authority_id')->nullable();
            $table->integer('source_of_fund_id')->nullable();
            $table->double('cost_tk_est')->nullable();
            $table->double('cost_tk_act')->nullable();
            $table->double('cost_usd_est')->nullable();
            $table->double('cost_usd_act')->nullable();
            $table->string('invitation_for_tender_est')->nullable();
            $table->string('invitation_for_tender_act')->nullable();
            $table->string('signing_of_contact_est')->nullable();
            $table->string('signing_of_contact_act')->nullable();
            $table->string('complition_of_contact_est')->nullable();
            $table->string('complition_of_contact_act')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('components');
    }
}
