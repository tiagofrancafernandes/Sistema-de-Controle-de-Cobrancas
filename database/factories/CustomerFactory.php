<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()?->name(),
            'email' => str()?->random(5) . '_' . fake()?->email(),
            'email_for_billing' => fn (array $attr) => $attr['email'] ?? str()?->random(5) . '_' . fake()?->email(),
            'password' => Hash::make('password'),
            'know_about_us_by' => null,
            'customer_since' => null,
            'doc1_type' => null,
            'doc1' => null,
            'phones' => null,
            'extra_data' => null,
            'internal_note' => 'Created by factory on ' . date('c'),
        ];
    }
}
