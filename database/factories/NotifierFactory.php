<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notifier>
 */
class NotifierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Fake notifier ' . fake()?->word(),
            'notifier_class' => \App\System\Notifiers\LogNotifier::class,
            'config' => [],
            'enabled' =>  true,
        ];
    }
}
