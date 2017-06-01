<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');

            // These preserve the relationships between the other tables
            // so as to reference the different options that were
            // selected at sign up
            $table->integer('plan_id')->nullable();         // only for stripe customers
            $table->integer('plan_quantity')->nullable();   // only for stripe customers
            $table->integer('user_id');
            $table->integer('pet_id');
            $table->integer('pet_weight_lbs');


            $table->integer('sub_package_id');
            $table->integer('sub_activity_level_id');
            $table->integer('sub_delivery_frequency_id');
            $table->integer('sub_payment_frequency_id');


            // At the time of setting up the subscription, the following are taken
            // from their respective tables. This is in case there is a price
            // change, it won't affect the existing subscriptions here
            $table->integer('sub_package_external_lb_cost')->nullable();
            $table->integer('sub_activity_level_multiplier')->nullable();
            $table->integer('sub_payment_frequency_multiplier')->nullable();
            $table->integer('sub_payment_frequency_discount_percent')->nullable();


            /**
             * Details related to the pickup of the order
             */
            $table->integer('pickup_location_id');
            $table->integer('pickup_appointment_id');

            $table->integer('cost')->nullable();

            $table->string('stripe_customer_id')->nullable();
            $table->boolean('active')->default(true);
            $table->dateTime('expires_on')->nullable();
            $table->dateTime('first_delivery_at')->nullable();

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
        Schema::dropIfExists('subscriptions');
    }
}
