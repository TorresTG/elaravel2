<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantityOrdered');
            $table->decimal('priceEach', 10, 2);
            $table->unsignedBigInteger('orderNumber');
            $table->unsignedBigInteger('productCode');
            $table->foreign('orderNumber')->references('id')->on('orders')->onDelete('cascade');;
            $table->foreign('productCode')->references('id')->on('products')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
