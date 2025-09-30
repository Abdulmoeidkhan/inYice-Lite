<?php

namespace Database\Seeders;

use App\Models\{User, Company, Country};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call permission seeder first to ensure roles and permissions exist
        $this->call([
            PermissionSeeder::class,
        ]);

        // Create company
        $company = Company::create([
            'name' => 'Flight380',
        ]);

        // Create user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'company_uuid' => $company->uuid,
            'password' => Hash::make('password'),
        ]);

        // Assign role to user (must exist from PermissionSeeder)
        $user->assignRole('developer');

        // Seed countries
        Country::create([
            'name' => 'Pakistan',
            'code' => 'PK',
        ]);

        Country::create([
            'name' => 'United Kingdom',
            'code' => 'UK',
        ]);

        Country::create([
            'name' => 'United States',
            'code' => 'US',
        ]);
    }
}
