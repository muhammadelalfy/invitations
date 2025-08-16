<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    // Filament specific auth translations
    'login' => [
        'heading' => 'Sign in to your account',
        'submit' => 'Sign in',
        'email' => 'Email address',
        'password' => 'Password',
        'remember' => 'Remember me',
        'forgot_password' => 'Forgot your password?',
        'no_account' => 'Don\'t have an account?',
        'register' => 'Register here',
    ],

    'register' => [
        'heading' => 'Create a new account',
        'submit' => 'Register',
        'name' => 'Full name',
        'email' => 'Email address',
        'password' => 'Password',
        'password_confirmation' => 'Confirm password',
        'already_have_account' => 'Already have an account?',
        'login' => 'Sign in here',
    ],

    'forgot_password' => [
        'heading' => 'Reset your password',
        'submit' => 'Send reset link',
        'email' => 'Email address',
        'back_to_login' => 'Back to login',
        'description' => 'Enter your email address and we\'ll send you a link to reset your password.',
    ],

    'reset_password' => [
        'heading' => 'Reset your password',
        'submit' => 'Reset password',
        'email' => 'Email address',
        'password' => 'New password',
        'password_confirmation' => 'Confirm new password',
        'token' => 'Reset token',
    ],

    'change_password' => [
        'heading' => 'Change password',
        'submit' => 'Update password',
        'current_password' => 'Current password',
        'new_password' => 'New password',
        'new_password_confirmation' => 'Confirm new password',
    ],

    'logout' => [
        'submit' => 'Sign out',
        'confirm' => 'Are you sure you want to sign out?',
    ],

    'messages' => [
        'login_successful' => 'Welcome back!',
        'logout_successful' => 'You have been signed out successfully.',
        'registration_successful' => 'Registration successful! Please check your email to verify your account.',
        'password_reset_sent' => 'Password reset link has been sent to your email.',
        'password_reset_successful' => 'Your password has been reset successfully.',
        'password_changed_successful' => 'Your password has been changed successfully.',
        'invalid_credentials' => 'Invalid email or password.',
        'account_suspended' => 'Your account has been suspended. Please contact support.',
        'email_not_verified' => 'Please verify your email address before continuing.',
        'too_many_requests' => 'Too many login attempts. Please try again later.',
    ],

    'placeholders' => [
        'email' => 'Enter your email address',
        'password' => 'Enter your password',
        'name' => 'Enter your full name',
        'current_password' => 'Enter your current password',
        'new_password' => 'Enter your new password',
        'confirm_password' => 'Confirm your password',
    ],

    'validation' => [
        'email_required' => 'Email address is required.',
        'email_invalid' => 'Please enter a valid email address.',
        'password_required' => 'Password is required.',
        'password_min' => 'Password must be at least 8 characters.',
        'password_confirmed' => 'Password confirmation does not match.',
        'name_required' => 'Name is required.',
        'current_password_required' => 'Current password is required.',
        'current_password_invalid' => 'Current password is incorrect.',
    ],

];
