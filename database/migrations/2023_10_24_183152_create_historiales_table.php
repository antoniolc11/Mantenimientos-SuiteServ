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
        Schema::create('historiales', function (Blueprint $table) {
            $table->foreignId('incidencia_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('estado_id')->constrained();
            $table->date('fecha')->default(now());
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->text('trabajo_realizado')->nullable();
            $table->primary(['incidencia_id', 'user_id', 'estado_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiales');
    }
};
