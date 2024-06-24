<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {

            $table->dropIndex('items_name_index');
            $table->text('name')->index()->nullable()->change();
            $table->foreignId('location_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropIndex('items_name_index');
            $table->text('name')->index()->change();
            $table->foreignId('location_id')->change();
        });
    }
};
