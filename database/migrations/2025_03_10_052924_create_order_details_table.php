<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('orderDetailsNumber');
            $table->integer('orderNumber');
            $table->string('productCode');
            $table->integer('quantityOrdered');
            $table->decimal('priceEach', 10, 2);
            $table->foreign('orderNumber')->references('orderNumber')->on('orders');
            $table->foreign('productCode')->references('productCode')->on('products');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
