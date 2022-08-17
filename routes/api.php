<?php

use App\Http\Controllers\ArticalController;
use App\Http\Controllers\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// CRUD API for article 
Route::apiResource('artical', ArticalController::class);

// Get candidates :: api/candidates
Route::get('candidates', [Candidate::class,'index']);

// Filter candidates :: api/candidates/filter?employment=fulltime&location=Barrybury&skills=php
Route::get('candidates/filter', [Candidate::class,'filter']);