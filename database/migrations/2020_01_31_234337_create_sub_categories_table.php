<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->bigIncrements('sub_cat_id');
            $table->string('sub_cat_image');
            $table->string('sub_cat_name');
            $table->string('sub_cat_description');  
            $table->integer('category_id')->nullable();        
            $table->integer('publication_status')->unsigned()->nullable()->default(0);
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
        Schema::dropIfExists('sub_categories');
    }
}
