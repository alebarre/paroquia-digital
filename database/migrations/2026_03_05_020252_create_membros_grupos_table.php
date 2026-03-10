<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('membros_grupos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos')->cascadeOnDelete();
            $table->foreignId('fiel_id')->constrained('fieis')->cascadeOnDelete();
            $table->string('funcao')->nullable(); // coordenador, secretário, membro, etc.
            $table->date('data_entrada')->nullable();
            $table->date('data_saida')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique(['grupo_id', 'fiel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membros_grupos');
    }
};