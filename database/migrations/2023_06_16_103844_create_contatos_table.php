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
        Schema::create('contatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 45)->nullable();
            $table->string('telefone_1', 11)->nullable();
            $table->string('telefone_2', 11)->nullable();
            $table->string('telefone_3', 11)->nullable();
            $table->string('telefone_4', 11)->nullable();
            $table->string('email_1', 45)->nullable();
            $table->string('email_2', 45)->nullable();
            $table->string('email_3', 45)->nullable();
            $table->string('email_4', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};
