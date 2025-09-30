<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $exclusivePermissions = [
            'company-view', 'company-create', 'company-edit', 'company-delete',
        ];

        $adminPermissions = [
            'users-view', 'users-create', 'users-edit', 'users-delete',
            'roles-view', 'roles-create', 'roles-edit', 'roles-delete',
            'salesItems-view', 'salesItems-create', 'salesItems-edit', 'salesItems-delete',
        ];

        $salesPermissions = [
            'orders-view', 'orders-create', 'orders-edit', 'orders-delete',
            'passengers-view', 'passengers-create', 'passengers-edit', 'passengers-delete',
        ];

        $accountsPermissions = [
            'customers-view', 'customers-create', 'customers-edit', 'customers-delete',
            'payments-view', 'payments-create', 'payments-edit', 'payments-delete',
            'paymentReceipts-view', 'paymentReceipts-create', 'paymentReceipts-edit', 'paymentReceipts-delete',
            'invoices-view', 'invoices-create', 'invoices-edit', 'invoices-delete',
            'vendors-view', 'vendors-create', 'vendors-edit', 'vendors-delete',
        ];

        $operationsAccountsPermissions = [
            'expenses-view', 'expenses-create', 'expenses-edit', 'expenses-delete',
            'expenseCategories-view', 'expenseCategories-create', 'expenseCategories-edit', 'expenseCategories-delete',
        ];

        $reportablePermissions = [
            'reportable-view', 'reportable-edit',
        ];

        $marketingPermissions = [
            'queries-view', 'queries-create', 'queries-edit', 'queries-delete',
        ];

        $customerPermissions = [
            'queries-view', 'invoices-view', 'orders-view', 'company-view',
        ];

        // Create all permissions
        $allPermissions = array_unique([
            ...$exclusivePermissions,
            ...$adminPermissions,
            ...$salesPermissions,
            ...$accountsPermissions,
            ...$operationsAccountsPermissions,
            ...$marketingPermissions,
            ...$reportablePermissions,
        ]);

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $developerRole = Role::firstOrCreate(['name' => 'developer']);
        $ownerRole     = Role::firstOrCreate(['name' => 'owner']);
        $adminRole     = Role::firstOrCreate(['name' => 'admin']);
        $salesRole     = Role::firstOrCreate(['name' => 'sales']);
        $accountsRole  = Role::firstOrCreate(['name' => 'accounts']);
        $marketingRole = Role::firstOrCreate(['name' => 'marketing']);
        $customerRole  = Role::firstOrCreate(['name' => 'customers']);
        $userRole      = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to roles
        $adminAndDevPermissions = [
            ...$adminPermissions,
            ...$salesPermissions,
            ...$accountsPermissions,
            ...$operationsAccountsPermissions,
            ...$marketingPermissions,
        ];

        $developerRole->syncPermissions($adminAndDevPermissions);
        $adminRole->syncPermissions($adminAndDevPermissions);
        $salesRole->syncPermissions($salesPermissions);
        $accountsRole->syncPermissions([...$salesPermissions, ...$accountsPermissions]);
        $marketingRole->syncPermissions([...$salesPermissions, ...$marketingPermissions]);
        $customerRole->syncPermissions($customerPermissions);
        $ownerRole->syncPermissions($allPermissions);
    }
}
