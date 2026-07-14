<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes (Login)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'show'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| All pages are browsable without login (acting as the jefe). Items hidden
| from the jefe and the visibility toggles require login (the dev), enforced
| inside the controllers.
*/
Route::group([], function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Projects Directory
    |--------------------------------------------------------------------------
    */
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('/projects/new', [ProjectsController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectsController::class, 'destroy'])->name('projects.destroy');

    /*
    |--------------------------------------------------------------------------
    | Tickets List
    |--------------------------------------------------------------------------
    */
    Route::get('/tickets', [TicketsController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/new', [TicketsController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketsController::class, 'store'])->name('tickets.store');

    /*
    |--------------------------------------------------------------------------
    | Ticket Detail
    |--------------------------------------------------------------------------
    */
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.status');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    /*
    |--------------------------------------------------------------------------
    | Ticket Subtasks
    |--------------------------------------------------------------------------
    */
    Route::post('/tickets/{ticket}/subtasks', [TicketController::class, 'storeSubtask'])->name('tickets.subtasks.store');
    Route::patch('/tickets/{ticket}/subtasks/{subtask}', [TicketController::class, 'toggleSubtask'])->name('tickets.subtasks.toggle');
    Route::delete('/tickets/{ticket}/subtasks/{subtask}', [TicketController::class, 'destroySubtask'])->name('tickets.subtasks.destroy');

    /*
    |--------------------------------------------------------------------------
    | Ticket Comments
    |--------------------------------------------------------------------------
    */
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'storeComment'])->name('tickets.comments.store');
    Route::delete('/tickets/{ticket}/comments/{comment}', [TicketController::class, 'destroyComment'])->name('tickets.comments.destroy');

    /*
    |--------------------------------------------------------------------------
    | Ticket Files
    |--------------------------------------------------------------------------
    */
    Route::post('/tickets/{ticket}/files', [TicketController::class, 'storeFile'])->name('tickets.files.store');
    Route::get('/tickets/{ticket}/files/{file}', [TicketController::class, 'downloadFile'])->name('tickets.files.download');
    Route::delete('/tickets/{ticket}/files/{file}', [TicketController::class, 'destroyFile'])->name('tickets.files.destroy');

});
