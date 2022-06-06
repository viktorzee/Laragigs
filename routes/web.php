<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  



//all listings
Route::get('/', [ListingController::class, 'index'])->middleware('auth');

//show create listing form
Route::get('/listings/create', [ListingController::class,
 'create'])->middleware('auth');

//store listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//edit listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//show-single
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//show register form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create new user
Route::post('/users', [UserController::class, 'store']);

//show log in page
Route::get('/login', [UserController::class,
 'login'])->name('login')->middleware('guest');

//log in 
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//log out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

