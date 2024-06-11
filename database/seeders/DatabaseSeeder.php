<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (tenancy()?->initialized) {
            app(DatabaseTenantSeeder::class)->run();

            return;
        }

        static::seedInitialData($this);
        static::seedFakeData($this);
    }

    public static function seedInitialData(?self $instance = null): void
    {
        $instance ??= app(static::class);

        static::initialAdminUsers();
    }

    public static function seedFakeData(?self $instance = null): void
    {
        $instance ??= app(static::class);

        if (app()?->environment(['stage', 'production']) || app()?->isProduction()) {
            return;
        }

        $instance->call([
            FakeTenantSeeder::class,
        ]);

        // User::factory(2)->create();
    }

    public static function initialAdminUsers(?self $instance = null): void
    {
        if (tenancy()->initialized) {
            return;
        }

        $instance ??= app(static::class);

        $adminUsers = [
            [
                'email' => 'admin@mail.com',
                'name' => 'Admin',
                'password' => Hash::make('power@123'),
            ]
        ];

        foreach ($adminUsers as $adminUser) {
            $user = User::updateOrCreate([
                'email' => $adminUser['email'],
            ], $adminUser);
        }
    }
}
