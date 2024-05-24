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
        Schema::create('postos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_posto', 100);
            $table->string('rede', 50)->nullable();
            $table->integer('id_contato');
            $table->integer('id_endereco');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postos');
    }
};
