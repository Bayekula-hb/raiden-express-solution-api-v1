<?php

use App\Models\Package;
use App\Models\TypeTransaction;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('money_trans', function (Blueprint $table) {
            $table->id();
            $table->string('otp', 10);
            $table->string('costs', 255);
            $table->string('amount_send', 255);
            $table->foreignIdFor(User::class)
                  ->references('id')
                  ->on('users');
            $table->json('receives');
            $table->json('step');
            $table->text('destination');
            $table->foreignIdFor(TypeTransaction::class)
                  ->references('id')
                  ->on('type_transactions');
            $table->foreignId('customer_id')
                  ->references('id')
                  ->on('users');
            $table->foreignId('routing_trans_money_id')
                  ->references('id')
                  ->on('routing_trans_moneys');
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
        Schema::dropIfExists('money_trans');
    }
}
