<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('address_id');
            $table->string('user_id')->nullable();
            $table->string('distance')->nullable();
            $table->string('duration')->nullable();
            $table->string('select_city')->nullable();
            $table->string('store_id')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('place_name')->nullable();
            $table->string('landmark')->nullable();
            $table->string('alt_phone')->nullable();
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
        Schema::dropIfExists('address');
    }
}
