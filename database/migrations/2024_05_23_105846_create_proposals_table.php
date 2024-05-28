<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ProposalStaus;
use App\Enums\BladeViewType;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table->integer('status')->default(ProposalStaus::CREATED); // Enum: created|sent|waiting|accepted|expired|canceled
            $table->timestamp('expires_in')->index()->nullable();
            $table->string('template_view')->nullable();
            $table->string('template_view_plain')->nullable();
            $table->integer('template_view_type')->nullable()->default(BladeViewType::HTML); // Enum: HTML|MARKDOWN
            $table->longText('final_text')->nullable(); // Final rendered text
            $table->timestamp('final_rendered_at')->index()->nullable();
            $table->json('content_data'); // [Item|quantity|sum], discount, final total, etc
            $table->uuid('customer_uuid')?->index()->nullable(); // If is a customer
            $table->string('amount')?->index()->nullable();
            $table->timestamp('accept_date')->index()->nullable();
            $table->string('accept_password');
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
        Schema::dropIfExists('proposals');
    }
};
