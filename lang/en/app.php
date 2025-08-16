<?php

return [
    'name' => 'Invitation Management System',
    'description' => 'A comprehensive system for managing invitations, guests, and events',
    
    'navigation' => [
        'dashboard' => 'Dashboard',
        'users' => 'Users',
        'roles' => 'Roles',
        'permissions' => 'Permissions',
        'invitations' => 'Invitations',
        'templates' => 'Templates',
        'staff' => 'Staff',
        'guests' => 'Guests',
    ],
    
    'auth' => [
        'login' => 'Login',
        'register' => 'Register',
        'logout' => 'Logout',
        'email' => 'Email',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password',
        'forgot_password' => 'Forgot Password?',
        'reset_password' => 'Reset Password',
        'change_password' => 'Change Password',
        'current_password' => 'Current Password',
        'new_password' => 'New Password',
        'remember_me' => 'Remember Me',
    ],
    
    'roles' => [
        'super_admin' => 'Super Administrator',
        'admin' => 'Administrator',
        'user' => 'User',
    ],
    
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'draft' => 'Draft',
        'sent' => 'Sent',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'invited' => 'Invited',
        'confirmed' => 'Confirmed',
        'arrived' => 'Arrived',
        'no_show' => 'No Show',
        'on_leave' => 'On Leave',
    ],
    
    'actions' => [
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'view' => 'View',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'back' => 'Back',
        'send' => 'Send',
        'assign' => 'Assign',
        'mark_arrived' => 'Mark Arrived',
    ],
    
    'messages' => [
        'created' => 'Record created successfully',
        'updated' => 'Record updated successfully',
        'deleted' => 'Record deleted successfully',
        'error' => 'An error occurred',
    ],

    'languages' => [
        'english' => 'US English',
        'arabic' => 'SA العربية',
    ],
];
