<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_image_main');
            $table->string('product_image1')->nullable();
            $table->string('product_image2')->nullable();
            $table->string('product_image3')->nullable();          
            $table->string('product_image4')->nullable();
            $table->string('product_image5')->nullable();
            $table->string('product_name');
            $table->text('product_description');
            $table->integer('category_id'); //category name
            $table->integer('sub_cat_id'); //category name
            $table->integer('brand_id'); //brand name
            $table->string('cgst_rate')->nullable();
            $table->string('sgst_rate')->nullable();
            $table->string('igst_rate')->nullable();
            $table->string('ugst_rate')->nullable();
            $table->string('cgst_amount')->nullable();
            $table->string('sgst_amount')->nullable();
            $table->string('igst_amount')->nullable();
            $table->string('ugst_amount')->nullable();
            $table->integer('unit_id')->nullable(); 
            $table->string('product_buy_price')->default(0);
            $table->string('product_buy_qty')->default(0);
            $table->string('product_buy_date')->nullable();
            $table->string('product_offers')->default(0);//offer percentage
            $table->string('product_sell_price')->default(0);//MRP price
            $table->string('product_sell_price_ex_gst')->default(0);//Ex GST Price
            $table->string('product_sell_price_after_offer')->default(0);//Sell price after adding offer 
            $table->string('product_sell_price_after_offer_ex_gst')->default(0);//Ex Gst price after offer 
            $table->string('product_order_qty')->default(0);
            $table->string('product_delivered_qty')->default(0);
            $table->string('product_in_hand_stock')->default(0);// In-Hand-Qty = In-hand-Qty - Order Qty            
            $table->integer('product_stat')->unsigned()->nullable()->default(0);//publication_status 
            $table->integer('home_show_stat')->unsigned()->nullable()->default(0);//to show on Appshomne page  
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
        Schema::dropIfExists('products');
    }
}
