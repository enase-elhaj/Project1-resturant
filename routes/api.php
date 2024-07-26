<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MenuController;

use App\Http\Controllers\Api\BookingController;

use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Api\AdminController;

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Middleware\CheckAdmin;



Route::get('/menu', [MenuController::class, 'index']);


// Route::middleware(['auth:sanctum','CheckAdmin'])->post('/items', [MenuController::class, 'store']);

// Update menu item
// Route::middleware(['auth:sanctum', 'role:admin'])->put('/menu/{id}', [MenuItemController::class, 'update']);

// Delete menu item
// Route::middleware(['auth:sanctum', 'role:admin'])->delete('/menu/{id}', [MenuItemController::class, 'destroy']);


// Route::middleware('CheckAdmin')->group(function () {
//     // Route::put('/menu/{id}', [MenuItemController::class, 'update']);
//     // Route::delete('/menu/{id}', [MenuItemController::class, 'destroy']);
//     // Route::post('/items', [MenuController::class, 'store']);
// });
Route::middleware(['auth:sanctum','CheckAdmin'])->post('/items', [MenuController::class, 'store']);
Route::middleware(['auth:sanctum','CheckAdmin'])->put('/menu/{id}', [MenuItemController::class, 'update']);
Route::middleware(['auth:sanctum','CheckAdmin'])->delete('/menu/{id}', [MenuItemController::class, 'destroy']);


// Route::post('/bookings', [BookingController::class, 'store']);
Route::middleware('auth:sanctum')->post('/bookings', [BookingController::class, 'store']);


Route::middleware(['auth:sanctum','CheckAdmin'])->get('/bookings', [BookingController::class, 'index']);

Route::middleware(['auth:sanctum','CheckAdmin'])->delete('/bookings/{id}', [BookingController::class, 'destroy']);
Route::middleware(['auth:sanctum','CheckAdmin'])->post('/approve_book/{id}', [BookingController::class, 'approve']);
Route::middleware(['auth:sanctum','CheckAdmin'])->post('/reject_book/{id}', [BookingController::class, 'reject']);



Route::post('/register', [UserController::class, 'register']);

////the one wa goood
// Route::post('/login', [UserController::class, 'login']);

// Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::get('/my_users', [UserController::class, 'all']);



// Route::middleware('auth:api')->group(function () {
//     // Fetch user profile data
//     Route::get('/profile', 'ProfileController@index');

//     // Update user profile data
//     Route::put('/profile/update', 'ProfileController@update');

//     // Fetch user bookings
//     Route::get('/bookingsp', 'ProfileController@bookings');
// });

// Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth:sanctum');
// Route::get('/bookingsp', [ProfileController::class, 'bookings'])->middleware('auth:sanctum');
// Route::put('/profile_update', [ProfileController::class, 'update'])->middleware('auth:sanctum');
// Route::get('/somepage', 'SomeController@MyMethod')->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/bookingsp', [ProfileController::class, 'bookings']);
    // Route::put('/profile', [ProfileController::class, 'update']);
});

Route::put('/profile', [ProfileController::class, 'update'])->middleware('auth:sanctum');


Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware(['auth:sanctum']);





Route::middleware(['auth:sanctum', 'CheckAdmin'])->get('/logged-in-users', [AdminController::class, 'getLoggedInUsers']);


