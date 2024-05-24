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
        Schema::create('adiantamentos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_cavalo');
            $table->integer('id_posto');
            $table->integer('id_motorista')->nullable();
            $table->integer('id_transportadora')->nullable();
            $table->integer('id_email')->nullable();
            $table->string('rota', 25);
            $table->date('data_carregamento');
            $table->string('observacao', 200)->nullable();
            $table->integer('valor');
            $table->char('tipo', 3);
            $table->string('status', 15);
            $table->boolean('em_maos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adiantamentos');
    }
};
