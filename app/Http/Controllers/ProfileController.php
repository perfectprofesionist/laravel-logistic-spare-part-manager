<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing user profile updates.
 * Allows users to view and update their profile information (name, email, password).
 * Handles validation, password security, and user feedback.
 */
class ProfileController extends Controller
{
    /**
     * Show the profile edit form to the user.
     */
    public function edit()
    {
        return view('profile.index');
    }

    /**
     * Update the authenticated user's profile information.
     * Validates input, updates user data, and provides feedback.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255', // Name is required, must be a string
            'email'    => 'required|email|unique:users,email,' . auth()->id(), // Email must be unique except for current user
            'password' => 'nullable|min:6|confirmed', // Password is optional, must be at least 6 chars and confirmed
        ]);

        $user = Auth::user(); // Get the currently authenticated user
        $user->name  = $request->name;
        $user->email = $request->email;

        // If a new password is provided, hash and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Save changes to the database

        return back()->with('success', 'Profile updated successfully!'); // Provide user feedback
    }
}

