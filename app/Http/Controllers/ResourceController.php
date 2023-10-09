<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    // Retrieve a list of resources
    public function index()
    {
        // Fetch all resources
        $resources = Resource::all();

        return response()->json(['resources' => $resources]);
    }

    // Retrieve a single resource by ID
    public function show($id)
    {
        // Find the resource by ID
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        return response()->json(['resource' => $resource]);
    }

    // Create a new resource with file upload handling
    public function store(Request $request, $user_id)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Define file validation rules (max size is 2MB)
            // Add other validation rules for your fields
        ]);

        // Store the uploaded image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images2', 'public'); // Store image in the 'public' disk under 'images2' directory
        }

        // Create a new resource
        $resource = Resource::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'size' => $request->input('size'),
            'user_id' => $user_id, // Set the user_id from the route parameter
            'image' => $imagePath ?? null, // Save the image file path if provided
            // Add other fields here
        ]);

        return response()->json(['message' => 'Resource created successfully', 'resource' => $resource], 201);
    }

    // Update an existing resource by ID
    public function update(Request $request, $id)
    {
        // Find the resource by ID
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        // Validate request data here if needed

        // Update the resource
        $resource->update($request->all());

        return response()->json(['message' => 'Resource updated successfully', 'resource' => $resource]);
    }

    // Delete a resource by ID
    public function destroy($id)
    {
        // Find the resource by ID
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        // Delete the resource
        $resource->delete();

        return response()->json(['message' => 'Resource deleted successfully']);
    }

    
    public function getResourcesByUser($user_id)
    {
        // Fetch all resources belonging to the specified user
        $resources = Resource::where('user_id', $user_id)->get();

        return response()->json(['resources' => $resources]);
    }
}



