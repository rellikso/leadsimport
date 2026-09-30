<?php

use App\Http\Controllers\LeadImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/leads/import', [LeadImportController::class, 'create'])
    ->name('leads.import');

Route::post('/leads/import', [LeadImportController::class, 'store'])
    ->name('leads.import.store');
