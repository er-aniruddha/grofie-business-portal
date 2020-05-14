<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('cgst_rate_o')->nullable();
            $table->string('sgst_rate_o')->nullable();
            $table->string('igst_rate_o')->nullable();
            $table->string('ugst_rate_o')->nullable();
            $table->string('cgst_amount_o')->nullable();
            $table->string('sgst_amount_o')->nullable();
            $table->string('igst_amount_o')->nullable();
            $table->string('ugst_amount_o')->nullable();
            $table->string('offers')->nullable();;//offer percentage
            $table->string('sell_price')->nullable();;//MRP price
            $table->string('sell_price_ex_gst')->nullable();;//Ex GST Price
            $table->string('sell_price_after_offer')->nullable();;//Sell price after adding offer 
            $table->string('sell_price_after_offer_ex_gst')->nullable();;//Ex Gst price after offer 
            $table->string('qty')->nullable();
            $table->string('order_id')->nullable();//Random Number
            $table->string('distance')->nullable();
            $table->string('duration')->nullable();
            $table->string('select_city')->nullable();
            $table->string('store_id')->nullable();            
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('place_name')->nullable();
            $table->string('landmark')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('order_date')->nullable();
            $table->string('delivery_date')->nullable();
            $table->integer('order_stat')->nullable();//Confirm Order=1,Cancel Order = 0,Return Order= -1 
                                                      //Out for Delivery = 2  , Delivered = 3   
            $table->string('coupon_code')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('delivery_associates_id')->nullable();
            $table->string('delivery_charges')->nullable();
            $table->string('delivery_km_charges')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
