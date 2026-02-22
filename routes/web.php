<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.loading');
});


/*
|--------------------------------------------------------------------------
| Dashboard عام
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        | Dashboard
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        | Roles
        */

        Route::resource('roles', RoleController::class);


        /*
        | Users
        */

        Route::get('users', [UserController::class, 'index'])
            ->name('users.index');

        Route::get('users/{user}/editRoles', [UserController::class, 'editRoles'])
            ->name('users.editRoles');

        Route::put('users/{user}/updateRoles', [UserController::class, 'updateRoles'])
            ->name('users.updateRoles');


        /*
        | Settings
        | هذا الجزء هو سبب حل المشكلة
        */

        Route::get('settings', [SettingsController::class, 'index'])
            ->name('settings.index');

        Route::post('settings', [SettingsController::class, 'update'])
            ->name('settings.update');

    });


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Customers
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('customers', [CustomerController::class, 'index'])
        ->name('customers.index');

    Route::get('customers/create', [CustomerController::class, 'create'])
        ->middleware('is_admin_or_permission:customers.create')
        ->name('customers.create');

    Route::post('customers', [CustomerController::class, 'store'])
        ->middleware('is_admin_or_permission:customers.create')
        ->name('customers.store');

    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])
        ->middleware('is_admin_or_permission:customers.edit')
        ->name('customers.edit');

    Route::put('customers/{customer}', [CustomerController::class, 'update'])
        ->middleware('is_admin_or_permission:customers.edit')
        ->name('customers.update');

    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('is_admin_or_permission:customers.delete')
        ->name('customers.destroy');

});


/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('products/create', [ProductController::class, 'create'])
        ->middleware('is_admin_or_permission:products.create')
        ->name('products.create');

    Route::post('products', [ProductController::class, 'store'])
        ->middleware('is_admin_or_permission:products.create')
        ->name('products.store');

    Route::get('products/{product}/edit', [ProductController::class, 'edit'])
        ->middleware('is_admin_or_permission:products.edit')
        ->name('products.edit');

    Route::put('products/{product}', [ProductController::class, 'update'])
        ->middleware('is_admin_or_permission:products.edit')
        ->name('products.update');

    Route::delete('products/{product}', [ProductController::class, 'destroy'])
        ->middleware('is_admin_or_permission:products.delete')
        ->name('products.destroy');

});


/*
|--------------------------------------------------------------------------
| Invoices
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('invoices', [InvoiceController::class, 'index'])
        ->name('invoices.index');

    Route::get('invoices/create', [InvoiceController::class, 'create'])
        ->middleware('is_admin_or_permission:invoices.create')
        ->name('invoices.create');

    Route::post('invoices', [InvoiceController::class, 'store'])
        ->middleware('is_admin_or_permission:invoices.create')
        ->name('invoices.store');

    Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])
        ->middleware('is_admin_or_permission:invoices.edit')
        ->name('invoices.show');

    Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])
        ->middleware('is_admin_or_permission:invoices.edit')
        ->name('invoices.edit');

    Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])
        ->middleware('is_admin_or_permission:invoices.edit')
        ->name('invoices.update');

    Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])
        ->middleware('is_admin_or_permission:invoices.delete')
        ->name('invoices.destroy');

});


/*
|--------------------------------------------------------------------------
| Purchases
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('purchases', [PurchaseController::class, 'index'])
        ->name('purchases.index');


    // ✅ هذا هو الراوت المفقود
    Route::get('purchases/create', [PurchaseController::class, 'create'])
        ->name('purchases.create');


    Route::post('purchases', [PurchaseController::class, 'store'])
        ->name('purchases.store');


    Route::get('purchases/{purchase}/edit', [PurchaseController::class, 'edit'])
        ->name('purchases.edit');


    Route::put('purchases/{purchase}', [PurchaseController::class, 'update'])
        ->name('purchases.update');


    Route::delete('purchases/{purchase}', [PurchaseController::class, 'destroy'])
        ->name('purchases.destroy');


    // add product
    Route::post(
        'purchases/{purchase}/add-product',
        [PurchaseController::class, 'addProduct']
    )->name('purchases.addProduct');


    // remove product
    Route::delete(
        'purchases/{purchase}/remove-product/{product}',
        [PurchaseController::class, 'removeProduct']
    )->name('purchases.removeProduct');

});
 /*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('reports/pdf', [ReportController::class, 'pdf'])
        ->name('reports.pdf');

});


/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
