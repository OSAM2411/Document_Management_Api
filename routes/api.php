<?php

use App\Http\Controllers\Api\authcontroller;
use App\Http\Controllers\Api\documentcontroller;
use App\Http\Controllers\Api\usercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//this route just for register  customer
Route::post('/register', [authcontroller::class, 'register']);

//this rout for login 
Route::post('/login', [authcontroller::class, 'login'])->middleware('throttle:5,1');


//Route For logout users change profile and password 
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [authcontroller::class, 'logout']);
    Route::post('/profile', [usercontroller::class, 'profile']);
    Route::post('/changePassword', [usercontroller::class, 'changepassword']);
});

//just  admin can creat and update user and admin and accountant 
Route::middleware(['auth:sanctum', 'role:admin,superadmin'])->prefix('super')->group(function () {
    Route::post('/store', [usercontroller::class, 'store']);
    Route::post('/update/{user}', [userController::class, 'update']);
});

//Route to create and update document
Route::middleware(['auth:sanctum', 'role:admin,user,superadmin'])->prefix('doc')->group(function () {
    Route::post('/store', [documentcontroller::class, 'store']);
    Route::post('/update/{id}', [documentcontroller::class, 'update']);
});


//Route to delete document
Route::middleware(['auth:sanctum', 'role:admin,superadmin'])->group(function () {
    Route::post('/delete/{id}', [usercontroller::class, 'delete']);
});
