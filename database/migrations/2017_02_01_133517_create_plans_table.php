<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_id');
            $table->integer('delivery_address_id')->nullable();
            $table->integer('shipping_cost');

            $table->integer('pet_id');
            $table->integer('pet_weight');
            $table->integer('pet_activity_level');

            $table->integer('package_id');

            // TODO: Remove or change this
            $table->string('package_stripe_code')->nullable();

            // TODO: Make this seedable??
            $table->integer('package_base')->nullable();

            $table->integer('weekly_cost');
            $table->integer('weeks_at_a_time');
            $table->dateTime('last_delivery_at')->nullable();

            $table->boolean('active')->default(true);
            $table->string('hash')->nullable();

            $table->enum('payment_method', [
                'cash',
                'interac',
                'e-transfer',
                'stripe',
                'paypal',
            ])->default('stripe');

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
        Schema::dropIfExists('plans');
    }
}
