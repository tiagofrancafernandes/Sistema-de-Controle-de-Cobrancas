<?php

namespace Database\Factories;

use App\Enums\InvoiceOverdueNotifyCycle;
use App\Enums\InvoiceStatus;
use App\Models\Recurrence;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recurrence_uuid' => Recurrence::factory()?->create()?->uuid,
            'status' => Arr::random(InvoiceStatus::cases()),
            'overdue_notify_cycle' => Arr::random(InvoiceOverdueNotifyCycle::cases()),
            'extra_text' => 'Invoice extra text',
            'amount' => fake()?->regexify(sprintf('[1-9]{%s}\.[1-9]{2}', rand(2, 4))),
            'due_date' => Arr::random([now()?->subDays(rand(3, 15)), now()?->addDays(rand(0, 3))]),
            'notifiers' => null,
            'content_data' => [
                'items' => [
                    [
                        'name' => ucwords(fake()->words(rand(2, 4), true)),
                        'price' => $price = fake()?->regexify(sprintf('[1-9]{%s}\.[1-9]{2}', rand(2, 4))),
                        'quantity' => $quantity = rand(1, 4),
                        'amount' => $amount = floatval($price * $quantity),
                    ],
                    [
                        'name' => ucwords(fake()->words(rand(2, 4), true)),
                        'price' => $price = fake()?->regexify(sprintf('[1-9]{%s}\.[1-9]{2}', rand(2, 4))),
                        'quantity' => $quantity = rand(1, 4),
                        'amount' => $amount += floatval($price * $quantity),
                    ],
                ],
                'discount' => [
                    'type' => 'percent',
                    'value' => 0,
                ],
                'sum' => $amount,
                'final_value' => $amount,
            ],
        ];
    }
}
