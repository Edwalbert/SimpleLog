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
        Schema::create('butucas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->integer('id_endereco');
            $table->integer('id_conta_bancaria');
            $table->integer('id_contato');
            $table->boolean('butuca')->nullable();
            $table->boolean('terminal')->nullable();
            $table->boolean('depot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('butucas');
    }
};
