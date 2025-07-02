<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Make;

/**
 * Controller for managing car makes (brands).
 * Handles CRUD operations: listing, creating, updating, and deleting makes.
 * Provides user feedback and validation for all actions.
 */
class MakeController extends Controller
{
    /**
     * Display a paginated list of makes.
     */
    public function index()
    {
        $make = Make::latest()->paginate(20); // Paginate makes, 20 per page
        return view('make.index', compact('make'));
    }

    /**
     * Show the form for creating a new make.
     */
    public function create()
    {
        return view('make.create');
    }

    /**
     * Store a newly created make in the database after validation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Validate make name
        ]);
        Make::create($validated); // Create new make
        return redirect()->route('make.index')->with('success', 'Product added successfully!');
    }

    /**
     * Show the form for editing an existing make.
     */
    public function edit($id)
    {
        $make = Make::findOrFail($id); // Find make or fail
        return view('make.edit', compact('make'));
    }

    /**
     * Update the specified make in the database after validation.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Validate make name
        ]);
        $make = Make::findOrFail($id); // Find make or fail
        $make->update($validated); // Update make
        return redirect()->route('make.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete the specified make from the database.
     */
    public function destroy($id)
    {
        $make = Make::findOrFail($id); // Find make or fail
        $make->delete(); // Delete make
        return redirect()->route('make.index')->with('success', 'Product deleted successfully!');
    }
}
