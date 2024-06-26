<?php

use App\Models\Package;
use App\Models\TypeTransaction;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColiPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('coli_packages', function (Blueprint $table) {
            $table->id();
            $table->json('items');
            $table->string('otp', 10);
            $table->string('weight', 50);
            $table->string('volume', 50);
            $table->text('description')->nullable(true);
            $table->string('parcel_code', 20);
            $table->string('price', 20);
            // $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('customer_id');
            $table->foreignIdFor(User::class)
                  ->references('id')
                  ->on('users');
            $table->json('sender');
            $table->json('receives');
            $table->text('destination');
            $table->foreignIdFor(Package::class)
                  ->references('id')
                  ->on('packages');
            $table->foreignIdFor(TypeTransaction::class)
                  ->references('id')
                  ->on('type_transactions');

            $table->foreignId('customer_id')
                  ->references('id')
                  ->on('users');
            $table->boolean('using_raiden_point')->default(false);
            // $table->foreignId('user_id')
            //       ->references('id')
            //       ->on('users');

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
        Schema::dropIfExists('coli_packages');
    }
}
