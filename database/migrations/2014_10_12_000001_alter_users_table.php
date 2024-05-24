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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('solicitar_adiantamento')->default(0)->after('monitoramento');
            $table->boolean('enviar_adiantamento')->default(0)->after('solicitar_adiantamento');
            $table->boolean('autorizar_adiantamento')->default(0)->after('enviar_adiantamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('solicitar_adiantamento');
            $table->dropColumn('enviar_adiantamento');
            $table->dropColumn('autorizar_adiantamento');
        });
    }
};
