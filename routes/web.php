<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/',[AuthController::class, 'login'])->name('login');
Route::post('/',[AuthController::class, 'handleLogin'])->name('handleLogin');

Route::get('/validate-account/{email}', [AdminController::class, 'defineAccess']);
Route::post('/validate-account/{email}', [AdminController::class, 'submitDefineAccess'])->name('submitDefineAccess');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AppController::class, 'index'])->name('dashboard');



//les routes pour les employers
    Route::prefix('/employers')->group(function () {
        Route::get('/', [EmployerController::class, 'index'])->name('employer.index');
        Route::get('/create', [EmployerController::class, 'create'])->name('employer.create');
        Route::get('/edit/{employer}', [EmployerController::class, 'edit'])->name('employer.edit');

        Route::post('/store', [EmployerController::class, 'store'])->name('employer.store');
        Route::put('/update/{employer}', [EmployerController::class, 'update'])->name('employer.update');
        Route::get('/{employer}', [EmployerController::class, 'delete'])->name('employer.delete');

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
    //les routes pour les configurations
    Route::prefix('configurations')->group(function () {
    Route::get('/', [ConfigurationController::class, 'index'])->name('configurations');
    Route::get('/create', [ConfigurationController::class, 'create'])->name('configurations.create');
    Route::post('/store', [ConfigurationController::class, 'store'])->name('configurations.store');
    Route::get('/{configuration}', [ConfigurationController::class, 'delete'])->name('configurations.delete');
    });
//routes pour les administrateurs
    Route::prefix('administrateurs')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('administrateurs');

        Route::get('/create', [AdminController::class, 'create'])->name('administrateurs.create');

        Route::post('/create', [AdminController::class, 'store'])->name('administrateurs.store');

        Route::get('/edit/{administrateurs}', [AdminController::class, 'edit'])->name('administrateurs.edit');

        Route::put('/edit/{administrateurs}', [AdminController::class, 'update'])->name('administrateurs.update');

        Route::get('/delete/{user}', [AdminController::class, 'delete'])->name('administrateurs.delete');


});

    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payments');
        Route::get('/init', [PaymentController::class, 'initPayment'])->name('payment.init');
        Route::get('/download-invoice/{payment}', [PaymentController::class, 'effectuerPaid'])->name('payment.download');


    });


});

