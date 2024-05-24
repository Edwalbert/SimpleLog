<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retiradas', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->integer('id_cliente');
            $table->string('container', 11);
            $table->integer('id_rota')->nullable();
            $table->integer('id_butuca')->nullable();
            $table->integer('id_solicitado');
            $table->float('valor_butuca')->nullable();
            $table->float('valor_terminal')->nullable();
            $table->integer('id_cavalo')->nullable();
            $table->float('valor_desconto')->nullable();
            $table->string('status', 15)->nullable();
            $table->string('observacao', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retiradas');
    }
};
