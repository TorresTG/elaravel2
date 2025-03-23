<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('check');
            $table->date('paymentDate');
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('customerNumber');
            $table->foreign('customerNumber')->references('id')->on('customers')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
