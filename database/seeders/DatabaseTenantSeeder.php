<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseTenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!tenancy()->initialized) {
            return;
        }

        static::seedInitialData($this);
        static::seedFakeData($this);
    }

    protected static function seedInitialData(?self $instance = null): void
    {
        if (!tenancy()->initialized) {
            return;
        }

        $instance ??= app(static::class);

        static::initialTenantAdminUsers();
    }

    protected static function seedFakeData(?self $instance = null): void
    {
        if (!tenancy()->initialized) {
            return;
        }

        $instance ??= app(static::class);

        if (app()?->environment(['stage', 'production']) || app()?->isProduction()) {
            return;
        }

        $instance->call([
            //
        ]);
    }

    protected static function initialTenantAdminUsers(?self $instance = null): void
    {
        if (!tenancy()->initialized) {
            return;
        }

        $instance ??= app(static::class);

        $tenantAdminUsers = [
            // [
            //     'email' => 'admin@mail.com',
            //     'name' => 'Admin',
            //     'password' => Hash::make('power@123'),
            // ]
        ];

        foreach ($tenantAdminUsers as $adminUser) {
            $user = User::updateOrCreate([
                'email' => $adminUser['email'],
            ], $adminUser);
        }
    }
}
