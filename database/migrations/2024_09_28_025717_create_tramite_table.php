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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // Tipo de trámite
            $table->text('descripcion'); // Descripción del trámite
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con users
            $table->string('estado')->nullable(); // Estado, nulleable
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->onDelete('set null'); // Aprobado por, nulleable
            $table->foreignId('revisado_por')->nullable()->constrained('users')->onDelete('set null'); // Revisado por, nulleable
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
