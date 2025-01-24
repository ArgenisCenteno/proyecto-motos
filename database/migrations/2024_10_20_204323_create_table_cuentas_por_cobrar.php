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
    public function up()
    {
        Schema::create('cuenta_por_cobrar', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->decimal('monto', 10, 2);
            $table->string('status');
            $table->unsignedBigInteger('viaje_id')->nullable(); // Relación con viajes
            $table->unsignedBigInteger('user_id'); // Relación con users
            $table->unsignedBigInteger('procesado_por')->nullable(); // Relación con users
            $table->timestamps();

            // Claves foráneas
            $table->foreign('viaje_id')->references('id')->on('viajes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('procesado_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuenta_por_cobrar');
    }
};
