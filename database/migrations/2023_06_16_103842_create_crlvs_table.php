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
        Schema::create('crlvs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_endereco')->nullable();
            $table->foreign('id_endereco')->references('id')->on('enderecos');
            $table->string('renavam', 11)->unique()->nullable();
            $table->year('ano_fabricacao')->nullable();
            $table->year('ano_modelo')->nullable();
            $table->string('numero_crv', 12)->nullable();
            $table->string('path_crlv', 200)->nullable();
            $table->string('codigo_seguranca_cla', 11)->unique()->nullable();
            $table->date('emissao_crlv')->nullable();
            $table->date('vencimento_crlv')->nullable();
            $table->string('modelo', 80)->nullable();
            $table->string('cor', 10)->nullable();
            $table->string('chassi', 17)->nullable();
            $table->string('cnpj_crlv', 14)->nullable();
            $table->string('cpf_crlv', 11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crlvs');
    }
};
