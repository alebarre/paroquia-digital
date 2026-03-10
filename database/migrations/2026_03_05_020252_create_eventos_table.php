<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['missa', 'retiro', 'novena', 'quermesse', 'reuniao', 'outro'])->default('outro');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim')->nullable();
            $table->string('local')->nullable();
            $table->text('descricao')->nullable();
            $table->boolean('recorrente')->default(false);
            $table->string('recorrencia')->nullable(); // diario, semanal, mensal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};