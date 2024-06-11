<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminUser>
 */
class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => function (array $attr) {
                $superAdmin = $attr['super_admin'] ?? false;

                if ($superAdmin) {
                    return null;
                }

                return fake()->boolean(80)
                    ? (
                        Tenant::inRandomOrder()->first()?->id ?: Tenant::factory()->createOne()?->id
                    ) : null;
            },
            'user_id' => function (array $attr) {
                $tenantId = $attr['tenant_id'] ?? null;

                if (!$tenantId) {
                    return User::factory()->createOne([
                        'tenant_id' => null,
                    ])->id ?? null;
                }

                return User::factory()->createOne([
                    'tenant_id' => $tenantId,
                ])->id ?? null;
            },
            'super_admin' => function (array $attr) {
                $tenantId = $attr['tenant_id'] ?? null;
                $userId = $attr['user_id'] ?? null;

                return $userId && is_null($tenantId);
            },
        ];
    }
}
