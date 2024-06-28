<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('auth')->as('auth.')
    ->controller(AuthController::class)
    ->group(function ($route) {
        $route->get('register', 'showRegistrationForm')->name('register');
        $route->post('register', 'registerUser')->name('register.post');
        $route->get('login', 'showLoginForm')->name('login');
        $route->post('login', 'userLogin')->name('login.post');
        $route->post('logout', 'userLogout')->name('logout');
    });