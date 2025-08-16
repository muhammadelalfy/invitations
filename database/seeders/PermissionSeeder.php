<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'description' => 'Can create users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'description' => 'Can edit users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'description' => 'Can delete users'],
            
            // Role management
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'description' => 'Can view roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'description' => 'Can create roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'description' => 'Can edit roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles'],
            
            // Staff management
            ['name' => 'staff.view', 'display_name' => 'View Staff', 'description' => 'Can view staff'],
            ['name' => 'staff.create', 'display_name' => 'Create Staff', 'description' => 'Can create staff'],
            ['name' => 'staff.edit', 'display_name' => 'Edit Staff', 'description' => 'Can edit staff'],
            ['name' => 'staff.delete', 'display_name' => 'Delete Staff', 'description' => 'Can delete staff'],
            
            // Guest management
            ['name' => 'guests.view', 'display_name' => 'View Guests', 'description' => 'Can view guests'],
            ['name' => 'guests.create', 'display_name' => 'Create Guests', 'description' => 'Can create guests'],
            ['name' => 'guests.edit', 'display_name' => 'Edit Guests', 'description' => 'Can edit guests'],
            ['name' => 'guests.delete', 'display_name' => 'Delete Guests', 'description' => 'Can delete guests'],
            
            // Invitation management
            ['name' => 'invitations.view', 'display_name' => 'View Invitations', 'description' => 'Can view invitations'],
            ['name' => 'invitations.create', 'display_name' => 'Create Invitations', 'description' => 'Can create invitations'],
            ['name' => 'invitations.edit', 'display_name' => 'Edit Invitations', 'description' => 'Can edit invitations'],
            ['name' => 'invitations.delete', 'display_name' => 'Delete Invitations', 'description' => 'Can delete invitations'],
            ['name' => 'invitations.send', 'display_name' => 'Send Invitations', 'description' => 'Can send invitations'],
            
            // Template management
            ['name' => 'templates.view', 'display_name' => 'View Templates', 'description' => 'Can view templates'],
            ['name' => 'templates.create', 'display_name' => 'Create Templates', 'description' => 'Can create templates'],
            ['name' => 'templates.edit', 'display_name' => 'Edit Templates', 'description' => 'Can edit templates'],
            ['name' => 'templates.delete', 'display_name' => 'Delete Templates', 'description' => 'Can delete templates'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Get roles
        $superAdmin = Role::where('name', 'super_admin')->first();
        $admin = Role::where('name', 'admin')->first();
        $staff = Role::where('name', 'staff')->first();

        // Assign all permissions to super admin
        $superAdmin->permissions()->attach(Permission::all());

        // Assign admin permissions
        $adminPermissions = Permission::whereIn('name', [
            'users.view', 'users.create', 'users.edit',
            'staff.view', 'staff.create', 'staff.edit', 'staff.delete',
            'guests.view', 'guests.create', 'guests.edit', 'guests.delete',
            'invitations.view', 'invitations.create', 'invitations.edit', 'invitations.send',
            'templates.view'
        ])->get();
        $admin->permissions()->attach($adminPermissions);

        // Assign staff permissions
        $staffPermissions = Permission::whereIn('name', [
            'guests.view', 'guests.edit',
            'invitations.view'
        ])->get();
        $staff->permissions()->attach($staffPermissions);
    }
}
