<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_id');
            $table->integer('collector_id')->nullable();

            $table->integer('paymentable_id')->nullable();
            $table->string('paymentable_type')->nullable();

            $table->dateTime('received_at');
            $table->enum('format', [
                'cash',
                'interac',
                'e-transfer',
                'stripe',
                'paypal',
            ]);
            $table->integer('amount_paid');

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
        Schema::dropIfExists('payments');
    }
}
