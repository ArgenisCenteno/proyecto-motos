<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatosBancariosToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_bancarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Clave foránea para la relación con users
            $table->string('banco');  // Banco
            $table->string('dni');  // DNI del titular
            $table->enum('tipo_cuenta', ['CORRIENTE', 'AHORRO']);  // Tipo de cuenta
            $table->string('numero_cuenta');  // Número de cuenta
            $table->enum('estatus', ['ACTIVO', 'INACTIVO']);  // Estatus de la cuenta
            $table->timestamps();  // Fechas de creación y actualización

            // Agregar la clave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_bancarios');
    }
}
