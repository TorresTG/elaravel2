<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customerName');
            $table->string('phone');
            $table->unsignedBigInteger('salesRepEmployeeNumber');
            $table->foreign('salesRepEmployeeNumber')->references('id')->on('employees')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};