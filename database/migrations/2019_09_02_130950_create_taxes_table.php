<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('tax_id');
            // $table->string('tax_name_lm');
            // $table->string('tax_name_sm')->nullable();
            // $table->string('tax_percentage')->nullable();
            $table->string('cgst_name')->nullable();
            $table->string('cgst_rate')->nullable();
            $table->string('sgst_name')->nullable();
            $table->string('sgst_rate')->nullable();
            $table->string('igst_name')->nullable();
            $table->string('igst_rate')->nullable();
            $table->string('ugst_name')->nullable();
            $table->string('ugst_rate')->nullable();
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
        Schema::dropIfExists('taxes');
    }
}
