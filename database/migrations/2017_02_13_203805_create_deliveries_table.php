<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('deliverer_id');
            $table->integer('recipient_id');

            $table->integer('deliverable_id');
            $table->string('deliverable_type');

            $table->dateTime('delivered_at');

            // Only applies if the deliverable_type is Subscription
            $table->integer('days_of_food_delivered')->nullable();

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
        Schema::dropIfExists('deliveries');
    }
}
