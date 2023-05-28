<?php

Route::middleware('web')->group(function () {
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Auth\RegisterController@register');

    Route::get('register/verify_email', 'Auth\RegisterController@viewVerifyEmail');
    Route::get('register/verify_email/resend', 'Auth\RegisterController@verifyEmailResend');
    Route::get('register/verify_email/{token}', 'Auth\RegisterController@verifyEmail');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/create/{token}', ['as' => 'password.create', 'uses' => 'Auth\RegisterController@showCreateForm']);
    Route::post('password/create', ['as' => '', 'uses' => 'Auth\RegisterController@createPassword']);

    Route::get('logout', function () {
        Auth::logout();
        return redirect('/login');
    });

    Route::middleware(['auth', 'setTenant'])->group(function () {
        Route::get('/', function () {
            return redirect('passwords');
        });

        Route::get('security-center', 'System\PasswordController@securityCenterIndex');
        Route::get('passwords', 'System\PasswordController@view');
        Route::get('folders', 'System\FolderController@view');
        Route::get('users', 'System\UserController@view');
        Route::get('groups', 'System\GroupController@view');

        Route::group(['prefix' => 'api'], function () {

            Route::middleware('isAdmin')->group(function () {
                Route::put('my-plan', 'System\MyPlanController@update');
            });

            Route::put('my-user', 'System\MyUserController@update');

            Route::resource('passwords', 'System\PasswordController');
            Route::post('passwords/{id}/favorite', 'System\PasswordController@favorite');
            Route::get('passwords/{id}/groups/available', 'System\PasswordSharedController@groupsAvailable');
            Route::get('passwords/{id}/users/available', 'System\PasswordSharedController@usersAvailable');
            Route::get('passwords/{id}/shareds', 'System\PasswordSharedController@shareds');
            Route::post('passwords/{id}/shareds', 'System\PasswordSharedController@add');
            Route::delete('passwords/{id}/shareds', 'System\PasswordSharedController@delete');

            Route::get('folders/compact', 'System\FolderController@compact');
            Route::resource('folders', 'System\FolderController');

            Route::resource('users', 'System\UserController');

            Route::resource('groups', 'System\GroupController');
            Route::get('groups/{id}/users', 'System\GroupController@users');
            Route::get('groups/{id}/users/available', 'System\GroupController@usersAvailable');
            Route::post('groups/{id}/users', 'System\GroupController@usersAdd');
            Route::delete('groups/{id}/user/{user_id}/delete', 'System\GroupController@userDelete');

        });
    });
});

Route::get('presentation', function () {
    return view('emails.marketing.presentation');
});
