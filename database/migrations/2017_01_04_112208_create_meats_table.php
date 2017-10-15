<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meats', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type');
            $table->string('variety');
            $table->string('code');
            $table->boolean('has_bone')->default(0);
            $table->integer('cost_per_lb');

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
        Schema::dropIfExists('meats');
    }
}
