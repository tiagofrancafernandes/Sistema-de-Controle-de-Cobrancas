<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => uniqid(),
            'data' => [
                'note' => 'Created by factory on ' . date('c'),
            ],
            'tenancy_db_name' => function (array $attr) {
                $id = $attr['id'] ?? uniqid();

                return implode(
                    '',
                    array_filter([
                        config('tenancy.database.prefix'),
                        $id,
                        config('tenancy.database.suffix'),
                    ])
                );
            },
        ];
    }
}
