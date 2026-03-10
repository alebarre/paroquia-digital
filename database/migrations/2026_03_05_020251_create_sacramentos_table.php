<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sacramentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiel_id')->constrained('fieis')->cascadeOnDelete();
            $table->enum('tipo', [
                'batismo',
                'primeira_eucaristia',
                'crisma',
                'matrimonio',
                'uncao_enfermos',
                'ordenacao',
            ]);
            $table->date('data');
            $table->string('celebrante')->nullable();
            $table->string('local')->nullable();
            $table->string('padrinho')->nullable();
            $table->string('madrinha')->nullable();
            $table->string('conjuge')->nullable(); // para matrimônio
            $table->string('testemunha1')->nullable(); // para matrimônio
            $table->string('testemunha2')->nullable(); // para matrimônio
            $table->string('numero_registro')->nullable(); // número no livro
            $table->string('livro')->nullable();
            $table->string('folha')->nullable();
            $table->string('termo')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sacramentos');
    }
};