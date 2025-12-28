<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PaymentController;


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Resourceful routes for contacts (index, create, store, show, edit, update, destroy)
    Route::resource('contacts', ContactController::class)->names('contacts');

    // Manage Roles
    Route::resource('role', RoleController::class)->except('create', 'show', 'edit');
  
    // Manage Permissions
    Route::resource('permission', PermissionController::class)->except('create', 'show', 'edit');

    // Manage Clients
    Route::resource('clients', ClientController::class)->names('clients');

    // Manage Projects
    Route::resource('projects', ProjectController::class)->names('projects');

    // Manage Invoices
    Route::resource('invoices', InvoiceController::class)->names('invoices');
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

    // Manage Payments
    Route::resource('payments', PaymentController::class)->names('payments');

    Route::get('/get-projects-by-client/{client}', [ProjectController::class, 'getProjectsByClient'])->name('get-projects-by-client');
});