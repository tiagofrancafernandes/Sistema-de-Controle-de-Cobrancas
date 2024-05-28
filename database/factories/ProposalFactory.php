<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProposalStaus;
use Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => Arr::random(ProposalStaus::cases()),
            'expires_in' => fake()->boolean(10) ? now()->addDays(rand(15, 30)) : null,
            'template_view' => 'proposal-templates.fake.demo',
            'template_view_plain' => null,
            'template_view_type' => null,
            'content_data' => fn (array $attr) => static::fakeContentData([
                'attr' => $attr,
            ]),
            'final_text' => null,
            'customer_uuid' => null,
            'amount' => rand(100, 1500) . '.' . rand(10, 90),
            'accept_date' => null,
            'accept_password' => \Hash::make('123456'),
            'final_rendered_at' => null,
        ];
    }

    public static function fakeContentData(array $toMerge = []): array
    {
        $fakeItem = fn () => fluent([
            'title' => ucwords(fake()->words(3, true)),
            'inline_note' => 'A fake item',
            'price' => $price = rand(45, 120) . '.' . rand(10, 90),
            'quantity' => $quantity = rand(1, 5),
            'amount_sum' => $amountSum = floatval($price * $quantity),
            'discount_after' => $discountAfter = Arr::random([1, 5, 10, 15]),
            'discount_pre_paid' => $discountPrePaid = $discountAfter * 2,
            'after_amount_sum' => $amountSum - ($amountSum / 100 * $discountAfter),
            'pre_paid_amount_sum' => $amountSum - ($amountSum / 100 * $discountPrePaid),
        ]);

        return array_merge([
            'customer' => [
                'name' => fake()->name(),
                'email' => fake()->email(),
            ],
            'items' => [
                $fakeItem(),
                $fakeItem(),
                $fakeItem(),
                $fakeItem(),
            ],
        ], $toMerge);
    }
}
