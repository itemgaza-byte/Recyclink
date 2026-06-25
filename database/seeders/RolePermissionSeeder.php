<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Daftar semua permissions sistem.
     */
    private array $permissions = [
        // Listings
        'listing.create',
        'listing.update',
        'listing.delete',
        'listing.view-any',

        // Orders
        'order.create',
        'order.view-own',
        'order.update-status',
        'order.cancel',

        // Wallet & Finance
        'wallet.view',
        'wallet.withdraw',
        'withdrawal.approve',

        // Users
        'user.view-any',
        'user.update',
        'user.suspend',
        'user.delete',

        // Reviews
        'review.create',
        'review.delete-any',

        // Complaints
        'complaint.create',
        'complaint.resolve',

        // Education Content
        'education.create',
        'education.update',
        'education.delete',
        'education.publish',

        // Categories
        'category.manage',

        // Reports & Analytics
        'report.view',

        // Admin Panel
        'admin.access',
    ];

    /**
     * Mapping role ke permissions yang diizinkan.
     */
    private array $rolePermissions = [
        'admin' => '*', // Semua permission

        'seller' => [
            'listing.create',
            'listing.update',
            'listing.delete',
            'listing.view-any',
            'order.view-own',
            'order.update-status',
            'wallet.view',
            'wallet.withdraw',
            'review.create',
            'complaint.create',
        ],

        'buyer' => [
            'listing.view-any',
            'order.create',
            'order.view-own',
            'order.cancel',
            'review.create',
            'complaint.create',
        ],
    ];

    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat semua permissions
        foreach ($this->permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web',
            ]);
        }

        $allPermissions = Permission::all();

        // Buat roles dan assign permissions
        foreach ($this->rolePermissions as $roleName => $rolePerms) {
            $role = Role::firstOrCreate([
                'name'       => $roleName,
                'guard_name' => 'web',
            ]);

            if ($rolePerms === '*') {
                $role->syncPermissions($allPermissions);
            } else {
                $role->syncPermissions($rolePerms);
            }

            $this->command->info("Role '{$roleName}' seeded with permissions.");
        }
    }
}
