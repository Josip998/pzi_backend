<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload; // Import the Upload model

class UploadController extends Controller
{
    // Handle file uploads (e.g., user profile picture)
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules
        ]);

        // Store the uploaded file in a public directory (e.g., storage/app/public)
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public', $fileName);

        // You can save the file name or its path in your database for future reference

        return response()->json(['message' => 'File uploaded successfully']);
    }
}
