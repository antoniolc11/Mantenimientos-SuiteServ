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
        Schema::create('departamento_user', function (Blueprint $table) {
            $table->foreignId('departamento_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->primary(['departamento_id', 'user_id']);
            // Definición de clave primaria compuesta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamento_user');
    }
};
