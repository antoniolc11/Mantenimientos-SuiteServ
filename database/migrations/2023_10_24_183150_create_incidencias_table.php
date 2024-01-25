<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->date('fecha')->default(DB::raw('CURRENT_DATE'));
            $table->bigInteger('usuario_creador');
            $table->bigInteger('usuario_asignado');
            $table->text('descripcion');
            $table->foreignId('estado_id')->constrained();
            $table->foreignId('ubicacion_id')->constrained('ubicaciones');
            $table->foreignId('departamento_id')->constrained();
            $table->foreignId('categoria_id')->constrained();
            $table->foreign('usuario_creador')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_asignado')->references('id')->on('users')->onDelete('cascade');
            $table->enum('prioridad', ['Alta', 'Media', 'Baja'])->default('Media');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
