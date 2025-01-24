<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id(); // Campo id
            $table->string('nombre'); // Campo nombre
            $table->unsignedBigInteger('parroquia_id'); // Cambiar a unsignedBigInteger
            $table->foreign('parroquia_id')->references('id')->on('parishes')->onDelete('cascade');
            $table->string('estado', '30'); // Campo estado
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};
