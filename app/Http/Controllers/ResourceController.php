<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        $resource = Resource::with('user')->find($id);



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

    public function update(Request $request, Resource $resource)
    {
        // Validate the request data, you can customize the validation rules
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|string',
        ]);

        // Update the resource
        $resource->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'size' => $request->input('size'),
        ]);

        return response()->json(['message' => 'Resource updated successfully', 'resource' => $resource]);
    }

    public function destroy(Resource $resource)
    {
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

    public function showid($id)
    {
        try {
            $resource = Resource::findOrFail($id);
            $resource->user;
            // Replace 'Resource' with your actual model name
            return response()->json($resource, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }




    public function showSeller($resourceId)
    {
        // Find the resource by its ID
        $seller = User::find($resourceId);
    
        if (!$seller) {
            return response()->json(['message' => 'Seller not found'], 404);
        }
    
        // You can customize the response data as needed
        $sellerInfo = [
            'user_id' => $seller->id,
            'email' => $seller->email,
            'location' => $seller->location, // Add any other user-related information you need
        ];
    
        return response()->json($sellerInfo);
    }
    
}



