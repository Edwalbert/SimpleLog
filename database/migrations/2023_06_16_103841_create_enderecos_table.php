<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rua', 45)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('bairro', 45)->nullable();
            $table->string('cidade', 45)->nullable();
            $table->char('uf', 2)->nullable();
            $table->char('cep', 8)->nullable();
            $table->string('complemento', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
