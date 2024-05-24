<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCavalosTable extends Migration
{
    public function up(): void
    {
        Schema::table('cavalos', function (Blueprint $table) {
            $table->boolean('telemetria')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cavalos', function (Blueprint $table) {
            $table->dropColumn('telemetria');
        });
    }
};
