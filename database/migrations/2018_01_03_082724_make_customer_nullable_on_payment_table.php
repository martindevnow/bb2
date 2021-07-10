<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCustomerNullableOnPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TODO: This isn't working for some reason.. it's throwing and error related to enum...
//        Schema::table('payments', function (Blueprint $table) {
//            $table->integer('customer_id')->nullable()->change();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // nothing to do...
    }
}
