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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table->uuid('recurrence_uuid')->nullable()->index(); // If empty, is a single item
            $table->integer('status'); // Enum: paid|waiting 3rd|open|canceled
            $table->longText('extra_text')->nullable(); // Aditional text on SMZ, WA, invoice etc
            $table->string('amount')?->index();
            $table->timestamp('due_date')?->index();
            $table->json('notifiers')->nullable();
            $table->integer('overdue_notify_cycle')?->index(); // Enum once|daily|weekly
            $table->json('content_data')->nullable(); // Item|quantity|sum, discount, final total
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('recurrence_uuid')->references('uuid')
                ->on('recurrences')->onDelete('cascade'); // cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
