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
        Schema::create('recurrences', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table->timestamp('start_date')?->index();
            $table->uuid('contract_uuid')?->index();
            $table->boolean('dispatch_actions')?->index()?->default(true); // Notifications, invoices etc
            $table->boolean('active')?->index()?->default(true);
            $table->string('amount')?->index();
            $table->integer('mode')?->index(); // Enum: daily|weekly|biweekly|monthly|yearly

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('contract_uuid')->references('uuid')
                ->on('contracts')->onDelete('cascade'); // cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurrences');
    }
};
