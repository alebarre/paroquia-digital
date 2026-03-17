<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->integer('tipoCadastro')->comment('1 - Intenções da santa missa, 2 - Avisos da missa, 3 - Avisos gerais');
            $table->date('dataCadastro');
            $table->string('nomeAviso');
            $table->text('descricaoAviso')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};