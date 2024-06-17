<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid');
            $table->text('name')->index();
            $table->text('description')->nullable();
            $table->text('import_ref')->nullable();
            $table->text('notes')->nullable();
            $table->integer('quantity')->default(1);
            $table->boolean('insured')->nullable()->default(false);
            $table->boolean('archived')->nullable()->default(false);
            $table->unsignedBigInteger('asset_id')->nullable()->index();
            $table->string('serial_number')->nullable()->index();
            $table->string('model_number')->nullable()->index();
            $table->string('manufacturer')->nullable();
            $table->boolean('lifetime_warranty')->nullable()->default(false);
            $table->dateTime('warranty_expires')->nullable();
            $table->text('warranty_details')->nullable();
            $table->dateTime('purchase_time')->nullable();
            $table->string('purchase_from')->nullable();
            $table->double('purchase_price')->nullable();
            $table->dateTime('sold_time')->nullable();
            $table->string('sold_to')->nullable();
            $table->double('sold_price')->nullable();
            $table->text('sold_notes')->nullable();
            $table->foreignId('location_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
