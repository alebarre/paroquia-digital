<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('missas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->string('celebrante');
            $table->string('leitores')->nullable(); // CSV of names
            $table->string('ministros')->nullable(); // CSV of names
            $table->string('coroinha')->nullable();
            $table->string('cantor')->nullable();
            $table->text('intencoes')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missas');
    }
};