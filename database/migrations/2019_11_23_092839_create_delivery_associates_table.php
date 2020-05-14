<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_associates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('f_name');
            $table->string('s_name');    
            $table->string('phone');
            $table->string('email');
            $table->string('pin')->nullable();
            $table->string('verify_stat')->nullable();
            $table->string('live_stat')->nullable()->default(0);
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
        Schema::dropIfExists('delivery_associates');
    }
}
