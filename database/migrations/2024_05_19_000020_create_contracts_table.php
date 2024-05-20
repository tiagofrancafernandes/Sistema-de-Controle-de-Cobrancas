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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table->uuid('customer_uuid')?->index()->unique();
            $table->longText('content')->nullable();
            $table->timestamp('valid_from')?->nullable()?->index();
            $table->timestamp('valid_to')?->nullable()?->index();
            $table->timestamp('finished_at')?->nullable()?->index();
            $table->integer('finish_reason')?->nullable()?->index(); // Reason for the finish of contract
            $table->json('extra_data')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('customer_uuid')->references('uuid')
                ->on('customers')->onDelete('cascade'); // cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
