<?php

use App\Http\Controllers\DebtController;
use Illuminate\Support\Facades\Route;

Route::get('/debts', [DebtController::class, 'index']);
Route::get('/debts/{id}/suggest', [DebtController::class, 'suggestAction']);
Route::post('/debts/{id}/apply', [DebtController::class, 'applyAction']);
