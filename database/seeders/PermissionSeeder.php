<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Owner permissions
        $exclusivePermissions = [
            'company-view',
            'company-create',
            'company-edit',
            'company-delete',
        ];

        // Admin permissions
        $adminPermissions = [
            'users-view',
            'users-create',
            'users-edit',
            'users-delete',
            'roles-view',
            'roles-create',
            'roles-edit',
            'roles-delete',
            'salesItems-view',
            'salesItems-create',
            'salesItems-edit',
            'salesItems-delete',
        ];

        // Sales permissions
        $salesPermissions = [
            'orders-view',
            'orders-create',
            'orders-edit',
            'orders-delete',
            'passengers-view',
            'passengers-create',
            'passengers-edit',
            'passengers-delete',
        ];

        // Accounts permissions
        $accountsPermissions = [
            'customers-view',
            'customers-create',
            'customers-edit',
            'customers-delete',
            'payments-view',
            'payments-create',
            'payments-edit',
            'payments-delete',
            'paymentReceipts-view',
            'paymentReceipts-create',
            'paymentReceipts-edit',
            'paymentReceipts-delete',
            'invoices-view',
            'invoices-create',
            'invoices-edit',
            'invoices-delete',
            'vendors-view',
            'vendors-create',
            'vendors-edit',
            'vendors-delete',
        ];

        // Operations Accounts permissions
        $operationsAccountsPermissions = [
            'expenses-view',
            'expenses-create',
            'expenses-edit',
            'expenses-delete',
            'expenseCategories-view',
            'expenseCategories-create',
            'expenseCategories-edit',
            'expenseCategories-delete',
        ];

        // Reports permissions
        $reportablePermissions = [
            'reportable-view',
            'reportable-edit',
        ];

        // Marketing permissions
        $marketingPermissions = [
            'quries-view',
            'quries-create',
            'quries-edit',
            'quries-delete',
        ];

        // Customer and Passenger permissions
        $customerPermissions = [
            'quries-view',
            'invoices-view',
            'orders-view',
            'company-view',
        ];


        foreach ([...$exclusivePermissions, ...$adminPermissions, ...$salesPermissions, ...$accountsPermissions, ...$operationsAccountsPermissions, ...$marketingPermissions, ...$reportablePermissions] as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create-roles
        $developerRole = Role::create(['name' => 'developer']);
        $ownerRole = Role::create(['name' => 'owner']);
        $adminRole = Role::create(['name' => 'admin']);
        $salesRole = Role::create(['name' => 'sales']);
        $accountsRole = Role::create(['name' => 'accounts']);
        $marketingRole = Role::create(['name' => 'marketing']);
        $customerRole = Role::create(['name' => 'customers']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $ownerRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo([...$adminPermissions, ...$salesPermissions, ...$accountsPermissions, ...$operationsAccountsPermissions, ...$marketingPermissions]);
        $salesRole->givePermissionTo([...$salesPermissions]);
        $accountsRole->givePermissionTo([...$salesPermissions, ...$accountsPermissions]);
        $marketingRole->givePermissionTo([...$salesPermissions, ...$marketingPermissions]);
        $customerRole->givePermissionTo($customerPermissions);
    }
}
