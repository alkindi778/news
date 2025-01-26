<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions if they don't exist
        $permissions = [
            // Dashboard
            'view_dashboard',
            
            // User management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Role management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            
            // Permission management
            'view_permissions',
            'create_permissions',
            'edit_permissions',
            'delete_permissions',
            
            // Settings
            'manage_settings',
            
            // Activity logs
            'view_activity_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles if they don't exist and assign permissions
        // Super Admin
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'view_dashboard',
            'view_users',
            'create_users',
            'edit_users',
            'view_roles',
            'view_permissions',
            'manage_settings',
            'view_activity_logs',
        ]);

        // Editor
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $editor->syncPermissions([
            'view_dashboard',
            'view_users',
        ]);

        // Assign super-admin role to first user if not already assigned
        $user = User::first();
        if ($user && !$user->hasRole('super-admin')) {
            $user->assignRole('super-admin');
        }
    }
}
