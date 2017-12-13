<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_models', function (Blueprint $table) {
            $table->increments('id');

            $table->string('size');
            $table->integer('max_weight');
            $table->integer('min_weight');
            $table->integer('base_cost');
            $table->integer('incremental_cost');
            $table->integer('upgrade_cost');
            $table->integer('customization_cost');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_models');
    }
}
