<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();

            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['pendiente', 'en progreso', 'completada'])->default('pendiente');
            $table->date('fecha_entrega')->nullable();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('asignada_a')->nullable();

            $table->timestamps();

            // Claves foráneas
            $table->foreign('project_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('docente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('asignada_a')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
}
