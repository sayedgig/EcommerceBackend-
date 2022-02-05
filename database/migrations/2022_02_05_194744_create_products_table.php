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
            $table->id();
            $table->integer('category_id');
            $table->string('slug');
            $table->string('name');
            $table->longText('desscription')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();

            $table->string('selling_price');
            $table->string('original_price');
            $table->string('meta_quantity');
            $table->string('brand');
            $table->string('image');
            $table->tinyInteger('feature')->defaultValue('0')->nullable();
            $table->tinyInteger('popular')->defaultValue('0')->nullable();
            $table->tinyInteger('status')->defaultValue('0');
            





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
