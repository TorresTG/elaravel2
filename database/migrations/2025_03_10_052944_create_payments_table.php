<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('paymentNumber');
            $table->integer('customerNumber');
            $table->string('checkNumber');
            $table->date('paymentDate');
            $table->decimal('amount', 10, 2);
            $table->foreign('customerNumber')->references('customerNumber')->on('customers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
