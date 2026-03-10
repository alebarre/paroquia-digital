<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fieis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('familia_id')->nullable()->constrained('familias')->nullOnDelete();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('cpf')->unique()->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('sexo')->nullable(); // M / F
            $table->string('estado_civil')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('cep')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'falecido'])->default('ativo');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fieis');
    }
};