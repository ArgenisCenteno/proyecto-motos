<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeneroAndReferenciaToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('genero')->nullable(); // Campo genero, nulleable
            $table->string('referencia')->nullable(); // Campo referencia, nulleable
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('genero'); // Eliminar campo genero
            $table->dropColumn('referencia'); // Eliminar campo referencia
        });
    }
}
