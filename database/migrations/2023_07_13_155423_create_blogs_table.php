<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('blog_category_id');
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->longText('text')->nullable();
            $table->longText('text_en')->nullable();
            $table->longText('text_ar')->nullable();
            $table->string('image')->nullable();
            $table->boolean('active')->default(0);
            $table->longText('tags')->nullable();
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
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
        Schema::dropIfExists('blogs');
    }
};
