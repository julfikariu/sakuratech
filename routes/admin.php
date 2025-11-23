<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ContactController;


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Resourceful routes for contacts (index, create, store, show, edit, update, destroy)
    Route::resource('contacts', ContactController::class)->names('contacts');

    // Manage Roles
    Route::resource('role', RoleController::class)->except('create', 'show', 'edit');
});