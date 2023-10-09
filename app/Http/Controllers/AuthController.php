<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    
    // Register a new user
    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'location' => 'required', // Add validation for location
            'role' => 'user', // Default role for regular users
        ]);

        // Create a new user
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->location = $request->location; // Set the location
        $user->save();

        return response()->json(['message' => 'User registered successfully']);
    }

// Authenticate a user and issue an access token
public function login(Request $request)
{
    $credentials = $request->only(['email', 'password']);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'location' => $user->location,
                // Add other user-related properties here
            ],
            'token' => $user->createToken('authToken')->plainTextToken,
        ]);
    } else {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}

    // Invalidate the user's access token (for logging out)
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'User logged out successfully']);
    }

    // Retrieve the authenticated user's information
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}


