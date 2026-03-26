<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\PatientImportController;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

//Gestion de Roles
Route::resource('roles', RoleController::class);

//Gestion de Usuarios
Route::resource('users', UserController::class);

//Gestion de Pacientes
Route::resource('patients', PatientController::class);

//Gestion de Doctores
Route::resource('doctors', DoctorController::class);

//Gestion de Convenios de Seguro
Route::resource('insurances', InsuranceController::class);

//Importación masiva de pacientes
Route::get('patient-imports', [PatientImportController::class, 'index'])->name('patient-imports.index');
Route::post('patient-imports', [PatientImportController::class, 'store'])->name('patient-imports.store');
Route::get('patient-imports/download-example', [PatientImportController::class, 'downloadExample'])->name('patient-imports.download-example');
Route::get('patient-imports/{patientImport}/status', [PatientImportController::class, 'status'])->name('patient-imports.status');

