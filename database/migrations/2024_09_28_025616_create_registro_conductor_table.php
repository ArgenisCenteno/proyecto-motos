<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registro_conductor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con users
            $table->string('estado')->nullable(); // Estado, nulleable
            $table->string('documento_conducir')->nullable(); // Documento de conducir, nulleable
            $table->string('documento_contrato')->nullable(); // Documento de contrato, nulleable
            $table->string('documento_propiedad')->nullable(); // Documento de propiedad del vehículo, nulleable
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_conductor');
    }
};
