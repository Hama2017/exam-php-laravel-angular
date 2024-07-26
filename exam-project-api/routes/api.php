<?php

use App\Http\Controllers\EtudiantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/etudiants', [EtudiantController::class, 'store']);
Route::get('/etudiants', [EtudiantController::class, 'index']);
Route::get('/etudiants/classe/{classe_id}', [EtudiantController::class, 'showByClasse']);

