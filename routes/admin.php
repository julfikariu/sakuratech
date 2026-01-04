<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TicketController;
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
    Route::get('clients/{client}/projects', [ClientController::class, 'projects'])->name('clients.projects');
    Route::get('clients/{client}/invoices', [ClientController::class, 'invoices'])->name('clients.invoices');
    Route::get('clients/{client}/payments', [ClientController::class, 'payments'])->name('clients.payments');
    Route::get('clients/{client}/change-password', [ClientController::class, 'changePasswordForm'])->name('clients.change-password.form');
    Route::post('clients/{client}/change-password', [ClientController::class, 'changePassword'])->name('clients.change-password');

    // Manage Projects
    Route::resource('projects', ProjectController::class)->names('projects');
    Route::get('projects/{project}/files', [ProjectController::class, 'files'])->name('projects.files');
    Route::post('projects/{project}/upload-file', [ProjectController::class, 'uploadFile'])->name('projects.upload-file');
    Route::delete('projects/delete-file/{attachment}', [ProjectController::class, 'deleteFile'])->name('projects.delete-file');

    // Manage Tickets
    Route::resource('tickets', TicketController::class)->names('tickets');
    Route::post('tickets/{ticket}/change-status', [\App\Http\Controllers\Admin\TicketController::class, 'changeStatus'])->name('tickets.change-status');

    // Ticket replies
    Route::post('tickets/{ticket}/replies', [\App\Http\Controllers\Admin\TicketReplyController::class, 'store'])->name('tickets.replies.store');
    Route::delete('tickets/{ticket}/replies/{reply}', [\App\Http\Controllers\Admin\TicketReplyController::class, 'destroy'])->name('tickets.replies.destroy');

    // Manage Invoices
    Route::resource('invoices', InvoiceController::class)->names('invoices');
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

    // Manage Payments
    Route::resource('payments', PaymentController::class)->names('payments');

    Route::get('/get-projects-by-client/{client}', [ProjectController::class, 'getProjectsByClient'])->name('get-projects-by-client');
});