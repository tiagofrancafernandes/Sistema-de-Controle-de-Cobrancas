<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ItemType;
use App\Enums\ItemStatus;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucwords(fake()->words(rand(2, 4), true)),
            'type' => Arr::random(ItemType::cases()),
            'status' => Arr::random(ItemStatus::cases()),
            'price' => fake()?->regexify(sprintf('[1-9]{%s}\.[1-9]{2}', rand(2, 4))),
            'description' => fake()?->paragraphs(2, true),
            'image_path' => null,
            'image_disk' => null,
            'icon' => null,
        ];
    }
}
