<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            ['name' => 'view-users', 'display_name' => 'View Users', 'description' => 'Can view user list and details'],
            ['name' => 'create-users', 'display_name' => 'Create Users', 'description' => 'Can create new users'],
            ['name' => 'edit-users', 'display_name' => 'Edit Users', 'description' => 'Can edit existing users'],
            ['name' => 'delete-users', 'display_name' => 'Delete Users', 'description' => 'Can delete users'],
            
            // Role management
            ['name' => 'view-roles', 'display_name' => 'View Roles', 'description' => 'Can view role list and details'],
            ['name' => 'create-roles', 'display_name' => 'Create Roles', 'description' => 'Can create new roles'],
            ['name' => 'edit-roles', 'display_name' => 'Edit Roles', 'description' => 'Can edit existing roles'],
            ['name' => 'delete-roles', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles'],
            
            // Permission management
            ['name' => 'view-permissions', 'display_name' => 'View Permissions', 'description' => 'Can view permission list and details'],
            ['name' => 'create-permissions', 'display_name' => 'Create Permissions', 'description' => 'Can create new permissions'],
            ['name' => 'edit-permissions', 'display_name' => 'Edit Permissions', 'description' => 'Can edit existing permissions'],
            ['name' => 'delete-permissions', 'display_name' => 'Delete Permissions', 'description' => 'Can delete permissions'],
            
            // Invitation management
            ['name' => 'view-invitations', 'display_name' => 'View Invitations', 'description' => 'Can view invitation list and details'],
            ['name' => 'create-invitations', 'display_name' => 'Create Invitations', 'description' => 'Can create new invitations'],
            ['name' => 'edit-invitations', 'display_name' => 'Edit Invitations', 'description' => 'Can edit existing invitations'],
            ['name' => 'delete-invitations', 'display_name' => 'Delete Invitations', 'description' => 'Can delete invitations'],
            ['name' => 'send-invitations', 'display_name' => 'Send Invitations', 'description' => 'Can send invitations via WhatsApp'],
            
            // Template management
            ['name' => 'view-templates', 'display_name' => 'View Templates', 'description' => 'Can view template list and details'],
            ['name' => 'create-templates', 'display_name' => 'Create Templates', 'description' => 'Can create new templates'],
            ['name' => 'edit-templates', 'display_name' => 'Edit Templates', 'description' => 'Can edit existing templates'],
            ['name' => 'delete-templates', 'display_name' => 'Delete Templates', 'description' => 'Can delete templates'],
            
            // Staff management
            ['name' => 'view-staff', 'display_name' => 'View Staff', 'description' => 'Can view staff list and details'],
            ['name' => 'create-staff', 'display_name' => 'Create Staff', 'description' => 'Can create new staff members'],
            ['name' => 'edit-staff', 'display_name' => 'Edit Staff', 'description' => 'Can edit existing staff members'],
            ['name' => 'delete-staff', 'display_name' => 'Delete Staff', 'description' => 'Can delete staff members'],
            
            // Guest management
            ['name' => 'view-guests', 'display_name' => 'View Guests', 'description' => 'Can view guest list and details'],
            ['name' => 'create-guests', 'display_name' => 'Create Guests', 'description' => 'Can create new guests'],
            ['name' => 'edit-guests', 'display_name' => 'Edit Guests', 'description' => 'Can edit existing guests'],
            ['name' => 'delete-guests', 'display_name' => 'Delete Guests', 'description' => 'Can delete guests'],
            ['name' => 'assign-staff', 'display_name' => 'Assign Staff', 'description' => 'Can assign staff to guests'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Create super-admin role with all permissions
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super-admin'],
            [
                'display_name' => 'Super Administrator',
                'description' => 'Full system access with all permissions',
            ]
        );

        $superAdminRole->permissions()->sync(Permission::all());

        // Create admin role with limited permissions
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Event management and guest coordination',
            ]
        );

        $adminPermissions = Permission::whereIn('name', [
            'view-staff', 'create-staff', 'edit-staff', 'delete-staff',
            'view-guests', 'create-guests', 'edit-guests', 'delete-guests', 'assign-staff',
            'view-invitations', 'view-templates',
        ])->get();

        $adminRole->permissions()->sync($adminPermissions);
    }
}
