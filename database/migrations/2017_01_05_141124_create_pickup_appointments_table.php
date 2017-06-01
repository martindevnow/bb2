<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('code');
            $table->integer('pickup_location_id');
            $table->string('day_of_the_week');
            $table->string('time_of_day');
            $table->boolean('active')->default(false);

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
        Schema::dropIfExists('pickup_appointments');
    }
}
