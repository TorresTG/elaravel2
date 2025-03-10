<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('orderNumber')->primary();
            $table->date('orderDate');
            $table->string('status');
            $table->integer('customerNumber');
            $table->foreign('customerNumber')->references('customerNumber')->on('customers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
