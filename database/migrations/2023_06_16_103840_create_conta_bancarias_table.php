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
        Schema::create('conta_bancarias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_conta_bancaria', 10)->nullable();
            $table->string('agencia', 10)->nullable();
            $table->unsignedInteger('codigo_banco')->nullable();
            $table->foreign('codigo_banco')->references('id')->on('bancos');
            $table->string('nome_banco', 45)->nullable();
            $table->char('titularidade', 2)->nullable();
            $table->char('tipo_conta', 8)->nullable();
            $table->string('pix', 45)->nullable();
            $table->string('cpf_cnpj_titular', 14)->nullable();
            $table->string('chave_pix', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conta_bancarias');
    }
};
