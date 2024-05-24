<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carretas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('placa', 7)->nullable();
            $table->unsignedInteger('id_crlv')->unique()->nullable();
            $table->foreign('id_crlv')->references('id')->on('crlvs');
            $table->date('vencimento_opentech_seara')->nullable();
            $table->date('vencimento_opentech_minerva')->nullable();
            $table->date('vencimento_opentech_alianca')->nullable();
            $table->date('checklist_alianca')->nullable();
            $table->date('checklist_minerva')->nullable();
            $table->string('rntrc', 9); // rntrc == ANTT
            $table->string('path_rntrc', 200)->nullable(); // rntrc == ANTT
            $table->unsignedInteger('id_transportadora')->nullable();
            $table->foreign('id_transportadora')->references('id')->on('transportadoras')->nullable();
            $table->unsignedInteger('id_cavalo')->nullable();
            $table->foreign('id_cavalo')->references('id')->on('cavalos')->nullable();
            $table->string('status', 7)->default('Ativo')->nullable();
            $table->string('motivo_desligamento', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carretas');
    }
};
