<?php

namespace Database\Factories;

use App\Enums\RecurrenceMode;
use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recurrence>
 */
class RecurrenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => now()?->subDays(rand(0, 150)),
            'contract_uuid' => Contract::factory()?->create()?->uuid,
            'dispatch_actions' => fake()?->boolean(95),
            'active' => fake()?->boolean(95),
            'amount' => fake()?->regexify(sprintf('[1-9]{%s}\.[1-9]{2}', rand(2, 4))),
            'mode' => \Arr::random(RecurrenceMode::cases()),
        ];
    }
}
