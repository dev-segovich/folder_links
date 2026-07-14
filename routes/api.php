<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (token auth via Laravel Sanctum)
|--------------------------------------------------------------------------
| Every request must send a personal access token:
|   Authorization: Bearer <token>
|   Accept: application/json
|
| A "dev" token sees everything (including items hidden from the boss).
| A "boss" token cannot see or touch tickets/projects hidden from him.
| Mint tokens with:  php artisan api:token <email>
*/
Route::middleware('auth:sanctum')->group(function () {
    // Who am I (the token's user)
    Route::get('/user', fn (Request $request) => $request->user());

    // Projects (read-only)
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);

    // Tickets
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::match(['put', 'patch'], '/tickets/{ticket}', [TicketController::class, 'update']);
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus']);
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);

    // Comments
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'storeComment']);
    Route::delete('/tickets/{ticket}/comments/{comment}', [TicketController::class, 'destroyComment']);

    // Subtasks
    Route::post('/tickets/{ticket}/subtasks', [TicketController::class, 'storeSubtask']);
    Route::patch('/tickets/{ticket}/subtasks/{subtask}', [TicketController::class, 'toggleSubtask']);
    Route::delete('/tickets/{ticket}/subtasks/{subtask}', [TicketController::class, 'destroySubtask']);
});
