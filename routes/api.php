<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Becomes GET /api/dashboard/stats automatically
Route::get('/dashboard/stats', [DashboardController::class, 'stats']);