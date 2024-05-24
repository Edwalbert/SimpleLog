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
        Schema::create('transportadoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj', 14)->unique();
            $table->string('inscricao_estadual', 14);
            $table->string('razao_social', 100);
            $table->string('codigo_transportadora', 5); //Codigo id da transportadora para fazer adiantamentos no sistema Senior
            $table->string('codigo_cliente', 5); //Codigo id da transportadora para realizar cobranças no sistema Senior
            $table->string('codigo_fornecedor', 5); //Codigo id da transportadora para realizar pagamentos no sistema Senior
            $table->string('rntrc', 9);
            $table->string('path_rntrc', 200)->nullable();
            $table->string('path_cnpj', 200)->nullable();
            $table->float('comissao')->nullable();
            $table->string('situacao', 10)->nullable();
            $table->string('status', 7);
            $table->string('motivo_desligamento', 100)->nullable();
            $table->unsignedInteger('id_contador');
            $table->foreign('id_contador')->references('id')->on('contatos');
            $table->unsignedInteger('id_conta_bancaria');
            $table->foreign('id_conta_bancaria')->references('id')->on('bancos');
            $table->unsignedInteger('id_responsavel');
            $table->foreign('id_responsavel')->references('id')->on('contatos');
            $table->unsignedInteger('id_endereco');
            $table->foreign('id_endereco')->references('id')->on('enderecos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportadoras');
    }
};
