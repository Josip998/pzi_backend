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
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');


Route::get('/resources/{id}', [ResourceController::class, 'showid']);



//Route for getting Seller informations
Route::get('resources/sellers/{SellerId}', [ResourceController::class, 'showSeller']);


// Resource Routes with User ID
Route::get('/resource', [ResourceController::class, 'index']); 
Route::get('/user/{user_id}/resource/{id}', [ResourceController::class, 'show'])->middleware('auth:sanctum'); 
Route::post('/user/{user_id}/resource', [ResourceController::class, 'store']); 
Route::put('/user/{user_id}/resource/{id}', [ResourceController::class, 'update'])->middleware('auth:sanctum'); 
Route::delete('/user/{user_id}/resource/{id}', [ResourceController::class, 'destroy'])->middleware('auth:sanctum');

Route::resource('resources', ResourceController::class)->middleware('auth:sanctum'); 

Route::get('/user/role', [ProfileController::class, 'getUserRole'])->middleware('auth:sanctum');

// Custom Resource Request Routes
Route::post('/custom-resource-request', [CustomResourceRequestController::class, 'store']);
Route::get('/custom-resource-request/{id}', [CustomResourceRequestController::class, 'show']);
Route::put('/custom-resource-request/{id}', [CustomResourceRequestController::class, 'update']);
Route::delete('/custom-resource-request/{id}', [CustomResourceRequestController::class, 'destroy']);

Route::resource('custom-resource-requests', CustomResourceRequestController::class)->only(['index']);

Route::get('/user/{user_id}/resources', [ResourceController::class, 'getResourcesByUser']);


// Profile Routes
Route::get('/profile/{username}', [ProfileController::class, 'show']);
Route::put('/profile/{username}', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');


// Search Routes (if applicable)
Route::get('/search', [SearchController::class, 'search']);

// Upload Routes (if applicable)
Route::post('/upload', [UploadController::class, 'store']);

use Illuminate\Support\Facades\Storage;

// Add this route to api.php
Route::get('/images2/{filename}', function ($filename) {
    // Use Laravel's Storage facade to retrieve the image file
    $path = 'public/images2/' . $filename;

    if (Storage::exists($path)) {
        $file = Storage::get($path);
        $mimeType = Storage::mimeType($path);

        return response($file)
            ->header('Content-Type', $mimeType);
    } else {
        // Handle the case where the image does not exist
        return response('Image not found', 404);
    }
});




