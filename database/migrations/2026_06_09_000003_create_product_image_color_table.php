<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_image_color', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_image_id');
            $table->unsignedBigInteger('color_id');
            $table->timestamps();

            $table->unique(['product_image_id', 'color_id']);
            $table->foreign('product_image_id')->references('id')->on('product_image')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('color')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_image_color');
    }
};
