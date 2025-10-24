<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

    //Gestion de Roles
    Route::resource('roles', RoleController::class);
