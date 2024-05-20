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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table?->uuid('uuid')?->unique()?->index();
            $table->string('name')?->index();
            $table->string('email')?->unique()->index();
            $table->string('email_for_billing')?->index();
            $table->string('password');
            $table->string('know_about_us_by')?->nullable();
            $table->integer('doc1_type')?->nullable()?->index(); // ENUM CPF/CNPJ
            $table->string('doc1')?->nullable()?->index();
            $table->json('phones')->nullable();
            $table->json('extra_data')->nullable();
            $table->timestamp('customer_since')?->nullable()?->index();
            $table->longText('internal_note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
