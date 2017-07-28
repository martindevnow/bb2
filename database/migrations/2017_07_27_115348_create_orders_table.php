<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('plan_id');
            $table->integer('customer_id');
            $table->integer('delivery_address_id');

            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('total_cost');

            $table->boolean('paid')->default(false);
            $table->boolean('packed')->default(false);
            $table->boolean('picked')->default(false);
            $table->boolean('shipped')->default(false);
            $table->boolean('delivered')->default(false);

            $table->dateTime('deliver_by');

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
        Schema::dropIfExists('orders');
    }
}
