<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->unsignedInteger("author_id");
            // $table->increments('id');
            $table->String("name", 120);
            $table->date("exp_date");
            $table->Integer("date_one");
            $table->Integer("date_two");
            $table->Integer("date_three");
            $table->Integer("price");
            $table->Integer("dis_one");
            $table->Integer("dis_two");
            $table->Integer("dis_three");
            $table->foreignId('category_id')->references('id')->on('categories')->constrained()->onDelete('cascade');
            $table->Integer("quantity");
            $table->Integer("phone_number");
            $table->string("image")->nullable();
            $table->string("common_info")->nullable();
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
