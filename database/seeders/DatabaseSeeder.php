<?php

namespace Database\Seeders;

use App\Models\{User, Company, Country};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Constraint\Count;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $company = Company::create([
            'name' => 'Flight380',
        ]);

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'company_uuid' => $company->uuid,
            'password' => Hash::make('password'),
        ]);

        $country = Country::insert([[
            'name' => 'Pakistan',
            'code' => 'PK',
        ], [
            'name' => 'United Kingdom',
            'code' => 'UK',
        ], [
            'name' => 'United States',
            'code' => 'US',
        ]]);

        $this->call([
            PermissionSeeder::class,
        ]);

        $user->assignRole('developer');
    }
}
