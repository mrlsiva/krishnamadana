<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'admin.auth.login')->name('admin.login');
