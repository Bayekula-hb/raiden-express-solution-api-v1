<?php

use App\Models\Package;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->array('items');
            $table->string('otp', 10);
            $table->string('weight', 50);
            $table->string('volume', 50);
            $table->text('description');
            $table->string('parcel_code', 20);
            $table->string('price', 20);
            $table->foreignIdFor(User::class)
                  ->references('id')
                  ->on('users');
            $table->foreignIdFor(Sender::class)
                  ->references('id')
                  ->on('senders');
            $table->foreignIdFor(Package::class)
                  ->references('id')
                  ->on('packages');
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
        Schema::dropIfExists('parcels');
    }
}
