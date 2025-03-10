<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('customerNumber')->primary();
            $table->string('customerName');
            $table->string('phone');
            $table->integer('salesRepEmployeeNumber')->nullable();
            $table->foreign('salesRepEmployeeNumber')->references('employeeNumber')->on('employees');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};