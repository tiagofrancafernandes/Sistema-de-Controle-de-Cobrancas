<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ContractFinishReason;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_uuid' => Customer::factory()?->create()?->uuid,
            'content' => fake()->paragraphs(4, true),
            'valid_from' => now()?->subDays(rand(1, 60)),
            'valid_to' => fn (array $attr) => now()?->parse($attr['valid_from'] ?? now())?->addDays(rand(200, 300)),
            'finished_at' => null,
            'finish_reason' => \Arr::random(ContractFinishReason::cases()),
            'extra_data' => null,
        ];
    }
}
