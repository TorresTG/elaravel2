<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('orderDate');
            $table->string('status');
            $table->unsignedBigInteger('customerNumber');
            $table->foreign('customerNumber')->references('id')->on('customers')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
