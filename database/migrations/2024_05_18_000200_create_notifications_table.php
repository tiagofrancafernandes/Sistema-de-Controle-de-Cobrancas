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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table->timestamp('to_sent_on')->nullable();
            $table->timestamp('was_sent_on')->nullable();
            $table->uuid('notifier_uuid')->index();
            $table->uuid('customer_uuid')->index();
            $table->json('data')->nullable();
            $table->longText('errors')->nullable();
            $table->timestamps();

            $table->foreign('notifier_uuid')->references('uuid')
                ->on('notifiers')->onDelete('cascade'); // cascade|set null

            $table->foreign('customer_uuid')->references('uuid')
                ->on('customers')->onDelete('cascade'); // cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
