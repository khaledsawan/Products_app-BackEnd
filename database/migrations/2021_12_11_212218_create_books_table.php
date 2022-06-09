<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("author_id");
            $table->String("name", 120);
            $table->date("exp_date");
            $table->Integer("date_one");
            $table->Integer("date_two");
            $table->Integer("date_three");
            $table->Integer("price");
            $table->Integer("dis_one");
            $table->Integer("dis_two");
            $table->Integer("dis_three");
            // $table->foreignId('categories_id');
            $table->Integer("quantity");
            $table->Integer("phone_number");
            $table->string("image")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
