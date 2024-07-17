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
            $table->integer('index');
            $table->integer('product_category_id');

            $table->string('title');
            $table->string('subTitle')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();

            $table->string('flavor')->nullable();
            $table->string('flavor_en')->nullable();
            $table->string('flavor_ar')->nullable();

            $table->longText('ingredients')->nullable();
            $table->longText('ingredients_en')->nullable();
            $table->longText('ingredients_ar')->nullable();

            $table->longText('text')->nullable();
            $table->longText('text_en')->nullable();
            $table->longText('text_ar')->nullable();

            $table->longText('image')->nullable();
            $table->string('color')->nullable();
            $table->integer('stock')->default(0);

            $table->longText('features')->nullable();
            $table->longText('features_en')->nullable();
            $table->longText('features_ar')->nullable();

            $table->longText('link')->nullable();

            $table->boolean('active')->default(0);

            $table->integer('price')->default(0);
            $table->integer('off')->default(0);
            $table->integer('view')->default(0);
            $table->integer('sale')->default(0);
            $table->float('score')->default(0);
            $table->integer('score_count')->default(0);

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
