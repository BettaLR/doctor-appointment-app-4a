<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

    //Gestion de Roles
    Route::resource('roles', RoleController::class);

    //Gestion de Usuarios
    Route::resource('users', UserController::class);

    //Gestion de Pacientes
    Route::resource('patients', PatientController::class);
