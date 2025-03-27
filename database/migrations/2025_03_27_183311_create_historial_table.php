<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'mongodb';
    public function up(): void
    {
        Schema::connection('mongodb')->create('historial', function (Blueprint $table) {
            $table->id(); // Genera un ObjectId automáticamente en MongoDB
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('url');
            $table->string('methodo');
            $table->json('header')->nullable();
            $table->string('func')->nullable();
            $table->json('body')->nullable();
            $table->timestamps(); // Agrega `created_at` y `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('historiales');
    }
};
