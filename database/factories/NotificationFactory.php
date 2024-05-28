<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Notifier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'to_sent_on' => null,
            'was_sent_on' => null,
            'notifier_uuid' => Notifier::factory()?->create()?->uuid,
            'target_class' => Customer::class,
            'target_col_name' => 'uuid',
            'target_col_value' => Customer::factory()?->create()?->uuid,
            'data' => null,
            'errors' => null,
        ];
    }
}
