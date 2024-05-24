<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('senhas', function (Blueprint $table) {
            $table->id();
            $table->string('acesso', 20);
            $table->string('sistema', 200);
            $table->string('link', 200);
            $table->string('login', 80);
            $table->string('password', 200);
            $table->string('descricao', 200)->nullable();
            $table->integer('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senhas');
    }
};
