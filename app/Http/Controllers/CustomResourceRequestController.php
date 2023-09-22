<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomResourceRequest;

class CustomResourceRequestController extends Controller
{
    // Handle form submissions and return JSON response
    public function store(Request $request)
    {
        // Validate the form data, including the image upload
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure it's an image file
            'email' => 'required|email',
            // Add other validation rules as needed
        ]);

        // Store the uploaded image
        $imagePath = $request->file('image')->store('custom-resource-images', 'public');

        // Create a new custom resource request record
        $customResourceRequest = CustomResourceRequest::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'email' => $request->input('email'),
            // Add other fields if needed
        ]);

        // Return a JSON response with the created resource request
        return response()->json(['message' => 'Resource request submitted successfully', 'request' => $customResourceRequest]);
    }
}


