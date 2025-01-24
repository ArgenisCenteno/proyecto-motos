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
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehicles')->onDelete('cascade')->nullable(); // Relaciona el viaje con un vehículo
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relaciona el viaje con el usuario (conductor)
            $table->string('origen')->nullable();
            $table->string('destino')->nullable();
            $table->decimal('distancia_km', 8, 2)->nullable();
            $table->decimal('precio', 10, 2)->nullable(); // Precio del viaje
            $table->timestamp('hora_salida')->nullable();
            $table->timestamp('hora_llegada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
