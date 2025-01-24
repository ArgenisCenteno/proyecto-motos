<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained('pagos')->onDelete('cascade'); // Relaciona el recibo con un pago
            $table->string('numero_recibo')->unique(); // Número de recibo
            $table->date('fecha_emision');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recibos');
    }
};