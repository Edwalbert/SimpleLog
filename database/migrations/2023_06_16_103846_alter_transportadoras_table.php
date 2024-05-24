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
        Schema::table('transportadoras', function (Blueprint $table) {
            $table->string('codigo_transportadora', 10)->change(); //Codigo id da transportadora para fazer adiantamentos no sistema Senior
            $table->string('codigo_cliente', 10)->change(); //Codigo id da transportadora para realizar cobranças no sistema Senior
            $table->string('codigo_fornecedor', 10)->change(); //Codigo id da transportadora para realizar pagamentos no sistema Senior
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transportadoras', function (Blueprint $table) {
            $table->dropColumn('codigo_transportadora');
            $table->dropColumn('codigo_cliente');
            $table->dropColumn('codigo_fornecedor');
        });
    }
};
