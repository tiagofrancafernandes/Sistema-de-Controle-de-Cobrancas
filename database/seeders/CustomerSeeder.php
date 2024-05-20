<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initialCustomers = [
            [
                'name' => 'Demo Customer',
                'email' => 'demo1@mail.com',
                'email_for_billing' => 'demo1@mail.com',
                'password' => Hash::make('password'),
            ]
        ];

        foreach ($initialCustomers as $initialCustomer) {
            Customer::updateOrCreate([
                'email' => $initialCustomer['email'],
            ], $initialCustomer);
        }
    }
}
