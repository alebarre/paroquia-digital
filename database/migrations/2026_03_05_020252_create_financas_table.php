<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('financas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias_financas')->nullOnDelete();
            $table->foreignId('fiel_id')->nullable()->constrained('fieis')->nullOnDelete();
            $table->string('descricao');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->decimal('valor', 10, 2);
            $table->date('data');
            $table->string('forma_pagamento')->nullable(); // dinheiro, pix, transferência, cheque
            $table->string('comprovante')->nullable(); // caminho do arquivo
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financas');
    }
};