<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->foreignId('sector_id')->constrained('sectors')->after('id')->nullable();
            $table->foreignId('conductor_id')->constrained('users')->after('sector_id')->nullable();
            $table->string('direccion')->after('conductor_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->dropForeign(['conductor_id']);
            $table->dropColumn(['sector_id', 'conductor_id', 'direccion']);
        });
    }
};
