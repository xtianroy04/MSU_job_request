<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backpack\Base Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\Base package.
|
*/

Route::group(
    [
        'namespace' => 'App\Http\Controllers',
        'middleware' => config('backpack.base.web_middleware', 'web'),
        'prefix' => config('backpack.base.route_prefix'),
    ],
    function () {
            // Authentication Routes...
            Route::get('login', 'Auth\LoginController@showLoginForm')->name('backpack.auth.login');
            Route::post('login', 'Auth\LoginController@login');
            Route::get('logout', 'Auth\LoginController@logout')->name('backpack.auth.logout');
            Route::post('logout', 'Auth\LoginController@logout');

            // Registration Routes...
            Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
            Route::post('register', 'Auth\RegisterController@register');

            // Password Reset
            Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('backpack.auth.password.reset');
            Route::post('password/reset', 'Auth\ResetPasswordController@reset');
            Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('backpack.auth.password.reset.token');
            Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('backpack.auth.password.email')->middleware('backpack.throttle.password.recovery:'.config('backpack.base.password_recovery_throttle_access'));
    

            // Email verification
            Route::get('email/verify', 'Auth\VerifyEmailController@emailVerificationRequired')->name('verification.notice');
            Route::get('email/verify/{id}/{hash}', 'Auth\VerifyEmailController@verifyEmail')->name('verification.verify');
            Route::post('email/verification-notification', 'Auth\VerifyEmailController@resendVerificationEmail')->name('verification.send');
    
            // Dashboard
            Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
            Route::get('/', 'AdminController@redirect')->name('backpack');
     
            // Update Account
            Route::get('edit-account-info', 'MyAccountController@getAccountInfoForm')->name('backpack.account.info');
            Route::post('edit-account-info', 'MyAccountController@postAccountInfoForm')->name('backpack.account.info.store');
            Route::post('change-password', 'MyAccountController@postChangePasswordForm')->name('backpack.account.password');
       
    });
