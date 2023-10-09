<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Retrieve a user's public profile information
    public function show($username)
    {
        // Find the user by username
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return the user's public profile information
        return response()->json(['user' => $user]);
    }

    // Update a user's profile
    public function updateProfile(Request $request, $username)
    {
        // Find the user by username
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the authenticated user is the owner of this profile
        if ($user->id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the request data (e.g., profile picture format, size, etc.)
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust as needed
            // Add more validation rules for other fields if necessary
        ]);

        // Implement profile update logic here
        // Example: Updating profile picture
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePicturePath = $profilePicture->store('profile_pictures', 'public');

            // Save the new profile picture path in the user's record
            $user->profile_picture = $profilePicturePath;
        }

        // Save other profile updates here, e.g., bio, name, etc.

        // Save the user's record
        $user->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }






        public function getUserRole()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's role
            $userRole = Auth::user()->role; // Assuming 'role' is the field name for the user's role

            return response()->json(['role' => $userRole]);
        }

        // Return an error response if the user is not authenticated
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

