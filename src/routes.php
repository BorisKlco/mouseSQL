<?php

use Controller\Home;
use Controller\User;
use Controller\Dashboard;
use Core\App;

App::get('/', [Home::class, 'index'])
    ->name('home');

//Dashboard
App::get('/dashboard', [Dashboard::class, 'index'])
    ->name('dashboard')
    ->only('auth');

App::get('/db_info', [Dashboard::class, 'info'])
    ->name('info')
    ->only('auth');

App::get('/change_db_password', [Dashboard::class, 'DbPasswordChangeShow'])
    ->name('changePsw')
    ->only('auth');

App::post('/change_db_password', [Dashboard::class, 'DbPasswordChange'])
    ->only('auth');

App::get('/profile', [Dashboard::class, 'profileShow'])
    ->name('profile')
    ->only('auth');

App::post('/profile', [Dashboard::class, 'profileChange'])
    ->only('auth');

App::post('/delete_acc', [Dashboard::class, 'deleteAcc'])
    ->only('auth');

//Auth section
App::get('/login', [User::class, 'login'])
    ->name('login')
    ->only('guest');

App::get('/register', [User::class, 'register'])
    ->name('register')
    ->only('guest');

App::post('/login', [User::class, 'auth'])
    ->name('post-login')
    ->only('guest');

App::post('/register', [User::class, 'create'])
    ->name('post-register')
    ->only('guest');

App::post('/logout', [User::class, 'destroy'])
    ->name('logout')
    ->only('auth');

App::get('/verification', [User::class, 'verification'])
    ->name('verification');
