<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CustomResourceRequestController;


// ... (other code)

// User Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user']);

// Resource Routes with User ID
Route::get('/user/{user_id}/resource', [ResourceController::class, 'index']); // Updated route
Route::get('/user/{user_id}/resource/{id}', [ResourceController::class, 'show']); // Updated route
Route::post('/user/{user_id}/resource', [ResourceController::class, 'store']); // Updated route
Route::put('/user/{user_id}/resource/{id}', [ResourceController::class, 'update']); // Updated route
Route::delete('/user/{user_id}/resource/{id}', [ResourceController::class, 'destroy']); // Updated route

// Custom Resource Request Routes
Route::post('/custom-resource-request', [CustomResourceRequestController::class, 'store']);
Route::get('/custom-resource-request/{id}', [CustomResourceRequestController::class, 'show']);
Route::put('/custom-resource-request/{id}', [CustomResourceRequestController::class, 'update']);
Route::delete('/custom-resource-request/{id}', [CustomResourceRequestController::class, 'destroy']);


// Profile Routes
Route::get('/profile/{username}', [ProfileController::class, 'show']);
Route::put('/profile/{username}', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');


// Search Routes (if applicable)
Route::get('/search', [SearchController::class, 'index']);

// Upload Routes (if applicable)
Route::post('/upload', [UploadController::class, 'store']);



