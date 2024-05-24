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
        Schema::create('telemetria', function (Blueprint $table) {
            $table->id();
            $table->datetime('data_hora');
            $table->char('veiculo',7);
            $table->string('motorista',50);
            $table->string('descricao_evento',70);
            $table->string('nome_cerca',70);
            $table->integer('velocidade');
            $table->string('hodometro',10);
            $table->time('duracao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telemetria');
    }
};
