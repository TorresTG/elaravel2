<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('productCode')->primary();
            $table->string('productName');
            $table->string('productLine');
            $table->integer('quantityInStock');
            $table->foreign('productLine')->references('productLine')->on('product_lines');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};