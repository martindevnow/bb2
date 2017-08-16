<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('inventoryable_id'); // this is the product, or meat.. raw materials
            $table->string('inventoryable_type'); // this can also be the packed version of the meals ... (but requires a size parameter)

            $table->string('size')->nullable();

            $table->integer('change');

            $table->integer('changeable_id'); // when change is - , then this is Order->id....
            $table->string('changeable_type'); // when change is + , then this is .. User->id (the purchaser)

            $table->integer('current')->nullable();

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
        Schema::dropIfExists('inventories');
    }
}
