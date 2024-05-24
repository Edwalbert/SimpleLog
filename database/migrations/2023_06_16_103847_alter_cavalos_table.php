<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::table('cavalos', function (Blueprint $table) {
            $table->string('id_pedagio', 17)->change();
        });
    }

    public function down(): void
    {
        Schema::table('cavalos', function (Blueprint $table) {
            $table->string('id_pedagio', 16)->change();
        });
    }
};
