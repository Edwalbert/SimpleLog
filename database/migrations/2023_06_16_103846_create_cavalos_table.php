w<?php

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
            Schema::create('cavalos', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_transportadora')->nullable();
                $table->foreign('id_transportadora')->references('id')->on('transportadoras');
                $table->unsignedInteger('id_crlv')->unique()->nullable();
                $table->foreign('id_crlv')->references('id')->on('crlvs');
                $table->unsignedInteger('id_conta_bancaria')->nullable();
                $table->foreign('id_conta_bancaria')->references('id')->on('conta_bancarias');
                $table->char('placa', 7)->unique()->nullable();
                $table->date('vencimento_teste_fumaca')->nullable();
                $table->date('vencimento_cronotacografo')->nullable();
                $table->date('vencimento_opentech_minerva')->nullable();
                $table->date('vencimento_opentech_alianca')->nullable();
                $table->date('vencimento_opentech_seara')->nullable();
                $table->date('checklist_alianca')->nullable();
                $table->date('checklist_minerva')->nullable();
                $table->string('id_rastreador', 8)->nullable();
                $table->string('tecnologia', 20)->nullable();
                $table->string('tipo_pedagio', 6)->nullable();
                $table->string('id_pedagio', 15)->nullable();
                $table->string('rntrc', 15)->nullable();
                $table->string('grupo', 15)->nullable();
                $table->string('status', 7)->nullable();
                $table->string('motivo_desligamento', 100)->nullable();
                $table->string('login_tecnologia', 45)->nullable();
                $table->string('senha_tecnologia', 25)->nullable();
                $table->string('certificado_cronotacografo', 15)->nullable();
                $table->date('brasil_risk_klabin')->nullable();
                $table->string('path_rntrc', 200)->nullable();
                $table->string('path_teste_fumaca', 200)->nullable();
                $table->string('path_foto_cavalo', 200)->nullable();
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('cavalos');
        }
    };
