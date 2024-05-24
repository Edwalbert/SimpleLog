<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('motoristas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 45)->nullable();
            $table->unsignedInteger('id_cavalo')->nullable();
            $table->foreign('id_cavalo')->references('id')->on('cavalos')->nullable();
            $table->unsignedInteger('id_transportadora')->nullable();
            $table->foreign('id_transportadora')->references('id')->on('transportadoras')->nullable();
            $table->unsignedInteger('id_local_residencia')->nullable();
            $table->foreign('id_local_residencia')->references('id')->on('enderecos');
            $table->string('codigo_senior', 6)->nullable(); //Id do motorista no sistema Senior
            $table->date('integracao_cotramol')->nullable();
            $table->string('telefone', 11)->nullable();
            $table->date('admissao')->nullable();
            $table->date('vencimento_aso')->nullable(); //Exame médico
            $table->date('vencimento_tox')->nullable(); //Exame toxicológico
            $table->date('vencimento_tdd')->nullable(); //Treinamento de direção defensiva
            $table->date('vencimento_opentech_brf')->nullable();
            $table->date('vencimento_opentech_alianca')->nullable();
            $table->date('vencimento_opentech_minerva')->nullable();
            $table->date('vencimento_opentech_seara')->nullable();
            $table->date('brasil_risk_klabin')->nullable();
            $table->unsignedInteger('id_contato_pessoal_1')->nullable();
            $table->foreign('id_contato_pessoal_1')->references('id')->on('contatos')->nullable();
            $table->string('contato_pessoal_1_parentesco', 45)->nullable();
            $table->unsignedInteger('id_contato_pessoal_2')->nullable();
            $table->foreign('id_contato_pessoal_2')->references('id')->on('contatos')->nullable();
            $table->string('contato_pessoal_2_parentesco', 45)->nullable();
            $table->unsignedInteger('id_contato_pessoal_3')->nullable();
            $table->foreign('id_contato_pessoal_3')->references('id')->on('contatos')->nullable();
            $table->string('contato_pessoal_3_parentesco', 45)->nullable();
            $table->string('registro_cnh', 11)->nullable()->unique();
            $table->string('espelho_cnh', 10)->nullable();
            $table->date('emissao_cnh')->nullable();
            $table->date('vencimento_cnh')->nullable();
            $table->date('primeira_cnh')->nullable();
            $table->string('renach', 11)->nullable();
            $table->string('ear', 3)->nullable();
            $table->string('categoria_cnh', 2)->nullable();
            $table->string('municipio_cnh', 45)->nullable();
            $table->char('uf_cnh', 2)->nullable();
            $table->string('cpf', 11)->unique();
            $table->string('numero_rg', 11)->unique();
            $table->string('nome_pai', 45);
            $table->string('nome_mae', 45);
            $table->string('municipio_nascimento', 45)->nullable();
            $table->char('uf_nascimento', 2)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('status', 7)->default('Ativo')->nullable();
            $table->string('rescisao', 80)->nullable();
            $table->string('motivo_desligamento', 100)->nullable();
            $table->string('obs_desligamento', 200)->nullable();
            $table->string('path_cnh', 200)->nullable();
            $table->string('path_foto_motorista', 200)->nullable();
            $table->string('path_ficha_registro', 200)->nullable();
            $table->string('path_aso', 200)->nullable();
            $table->string('path_tox', 200)->nullable();
            $table->string('path_tdd', 200)->nullable();
            $table->string('path_integracao_brf', 200)->nullable();
            $table->string('path_comprovante_residencia', 200)->nullable();
            $table->string('path_treinamento_anti_tombamento', 200)->nullable();
            $table->string('path_treinamento_3ps', 200)->nullable();
            $table->float('pontuacao_demarco')->nullable();
            $table->string('status_demarco', 200)->nullable();
            $table->string('motivo_bloqueio', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motoristas');
    }
};
