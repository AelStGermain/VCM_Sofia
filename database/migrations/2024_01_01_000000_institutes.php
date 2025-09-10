<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('institutes', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nombre', 200); // Nombre del instituto
            $table->string('codigo', 50)->unique(); // Código institucional
            $table->string('direccion')->nullable(); // Dirección física
            $table->string('correo_contacto', 150)->nullable(); // Email institucional
            $table->string('telefono_contacto', 30)->nullable(); // Teléfono
            $table->text('descripcion')->nullable(); // Descripción general
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void {
        Schema::dropIfExists('institutes');
    }
};