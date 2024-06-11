<?php

namespace Database\Seeders;

use App\Models\Tenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class FakeTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (tenancy()->initialized) {
            return;
        }

        $tenants = [
            [
                'id' => 'demo1',
                'name' => 'Demo 1',
                'domains' => [
                    'demo1.localhost',
                ],
            ],
        ];

        foreach ($tenants as $tenantData) {
            $tenantDomains = collect($tenantData['domains'] ?? []);
            $tenantData = collect(Arr::except($tenantData, ['domains']));

            $tenant = Tenant::firstOrCreate([
                'id' => $tenantData['id'] ?? uniqid(),
            ]);

            $tenantDomains?->each(function ($domain) use ($tenant, $tenantData) {
                $tenant->domains()->firstOrCreate([
                    'domain' => $domain,
                ]);
            });
        }
    }
}
