<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cuenta_por_cobrar', function (Blueprint $table) {
            $table->unsignedBigInteger('pago_id')->nullable()->after('id'); // Cambia 'id' por la columna antes de la que quieras agregar 'pago_id'
        });
    }

    public function down()
    {
        Schema::table('cuenta_por_cobrar', function (Blueprint $table) {
            $table->dropColumn('pago_id');
        });
    }
};
