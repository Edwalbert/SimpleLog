<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('email', 60);
            $table->char('cpf', 11)->nullable();
            $table->string('setor', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 200);
            $table->rememberToken();
            $table->string('status', 7);
            $table->boolean('cadastro')->default(0);
            $table->boolean('administrativo')->default(0);
            $table->boolean('operacao')->default(0);
            $table->boolean('monitoramento')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
