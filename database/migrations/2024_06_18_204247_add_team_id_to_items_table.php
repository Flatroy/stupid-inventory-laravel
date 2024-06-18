<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        DB::table('items')->truncate();

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('team_id');
        });
    }
};
