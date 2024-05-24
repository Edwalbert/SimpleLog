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
        Schema::create('valor_coletas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_butuca');
            $table->integer('id_terminal_coleta');
            $table->integer('id_terminal_baixa');
            $table->float('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valor_coletas');
    }
};
