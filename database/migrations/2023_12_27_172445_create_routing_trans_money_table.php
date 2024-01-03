<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutingTransMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('routing_trans_moneys', function (Blueprint $table) {
            $table->id();
            $table->string('name_routing_trans', 255);
            $table->string('description_routing_trans', 255);
            $table->float('percentage_routing_trans');
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
        Schema::dropIfExists('routing_trans_moneys');
    }
}
