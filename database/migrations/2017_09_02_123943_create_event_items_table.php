<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('day');
            $table->string('category');
            $table->string('time');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();

            $table->text('speaker_name')->nullable();
            $table->text('speaker_description')->nullable();
            $table->string('speaker_img')->nullable();
            $table->string('speaker_link')->nullable();

            $table->string('sponsor_name')->nullable();
            $table->text('sponsor_description')->nullable();
            $table->string('sponsor_img')->nullable();
            $table->string('sponsor_link')->nullable();

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
        Schema::dropIfExists('event_items');
    }
}
