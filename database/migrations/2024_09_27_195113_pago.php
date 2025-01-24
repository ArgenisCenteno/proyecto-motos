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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viaje_id')->constrained('viajes')->onDelete('cascade'); // Relaciona el pago con un viaje
            $table->decimal('monto', 10, 2); // Monto pagado
            $table->string('metodo_pago', 70); // Ejemplo: efectivo, tarjeta, transferencia
            $table->string('banco_origen', 80); // Ejemplo: efectivo, tarjeta, transferencia
            $table->string('banco_destino', 80); // Ejemplo: efectivo, tarjeta, transferencia
            $table->string('referencia'); // Ejemplo: efectivo, tarjeta, transferencia

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            Schema::dropIfExists('pagos');
        });
    }
};
