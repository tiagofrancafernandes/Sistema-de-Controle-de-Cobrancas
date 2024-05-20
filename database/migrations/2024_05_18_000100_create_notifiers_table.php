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
        Schema::create('notifiers', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table?->string('title');
            $table?->string('notifier_class');
            $table->json('config')->nullable();
            $table?->boolean('enabled')?->index()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifiers');
    }
};
