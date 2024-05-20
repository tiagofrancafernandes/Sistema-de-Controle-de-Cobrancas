<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table?->string('name')?->index();
            $table?->integer('type')?->index(); // Enum: service|product|custom
            $table?->integer('status')?->index(); // Enum: available|unavailable|temporary unavailable
            $table?->string('price')?->nullable()?->index();
            $table->longText('description')->nullable();
            $table?->string('image_path')?->nullable();
            $table?->string('image_disk')?->nullable();
            $table?->string('icon')?->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
