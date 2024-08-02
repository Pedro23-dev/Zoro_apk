<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/',[AuthController::class, 'login'])->name('login');
Route::post('/',[AuthController::class, 'handleLogin'])->name('handleLogin');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AppController::class, 'index'])->name('dashboard');


//les routes pour les employers
    Route::prefix('/employers')->group(function () {
        Route::get('/', [EmployerController::class, 'index'])->name('employer.index');
        Route::get('/create', [EmployerController::class, 'create'])->name('employer.create');
        Route::get('/edit/{employer}', [EmployerController::class, 'edit'])->name('employer.edit');

        Route::post('/store', [EmployerController::class, 'store'])->name('employer.store');

    });
    //les routes pour les départements
    Route::prefix('/departements')->group(function () {
        Route::get('/', [DepartementController::class, 'index'])->name('departement.index');
        Route::get('/create', [DepartementController::class, 'create'])->name('departement.create');
        Route::post('/create', [DepartementController::class, 'store'])->name('departement.store');
        Route::get('/edit/{departement}', [DepartementController::class, 'edit'])->name('departement.edit');
        Route::put('/update/{departement}', [DepartementController::class, 'update'])->name('departement.update');

        Route::get('/{departement}', [DepartementController::class, 'delete'])->name('departement.delete');

    });

});

