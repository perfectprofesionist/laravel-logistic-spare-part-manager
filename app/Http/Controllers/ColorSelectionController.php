<?php

namespace App\Http\Controllers;

use App\Models\ColorSelection;
use App\Models\Vehicle;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorSelectionController extends Controller
{
    /**
     * Store a newly created color selection.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',  // Ensure this field is validated
            'color_id' => 'required|exists:colors,id',
            'price' => 'required|numeric',
            'color_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // dd($validated);
    
        // Handle image upload
        $colorImagePath = $request->file('color_image') ? $request->file('color_image')->store('color_images', 'public') : null;
    
        // Create a new color selection entry
        ColorSelection::create([
            'vehicle_id' => $request->vehicle_id,  // Make sure 'vehicle_id' is passed correctly
            'color_id' => $request->color_id,
            'price' => $request->price,
            'color_image' => $colorImagePath,
        ]);
    
        // Redirect to a specific page after saving
        // return redirect()->route('color_selection.index')->with('success', 'Color selection added successfully!');
        $vehicle = Vehicle::find($validated['vehicle_id']);  // Use validated data for vehicle_id

        // Redirect to the vehicle edit page
        return redirect()->route('vehicle.edit', ['id' => $vehicle->id])
            ->with('success', 'Color added successfully!');
    }
    
    /**
     * Update the specified color selection.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'color_id' => 'required|exists:colors,id',
            'price' => 'required|numeric',
            'color_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

    
        // Find the ColorSelection record
        $colorSelection = ColorSelection::findOrFail($id);
    
        // Handle image upload if there's a new image
        $colorImagePath = $request->file('color_image') ? $request->file('color_image')->store('color_images', 'public') : $colorSelection->color_image;
    
        // Update the color selection entry
        $colorSelection->update([
            'vehicle_id' => $validated['vehicle_id'],
            'color_id' => $validated['color_id'],
            'price' => $validated['price'],
            'color_image' => $colorImagePath,
        ]);
    
        // Redirect to the vehicle edit page
        $vehicle = Vehicle::find($validated['vehicle_id']);
        return redirect()->route('vehicle.edit', ['id' => $vehicle->id])
            ->with('success', 'Color selection updated successfully!');
    }
    

    /**
     * Remove the specified color selection.
     */
    public function destroy($id)
    {
        // Find the ColorSelection record
        $colorSelection = ColorSelection::findOrFail($id);
    
        // Optionally, delete the associated image if it exists
        // if ($colorSelection->color_image) {
        //     Storage::disk('public')->delete($colorSelection->color_image);
        // }
    
        // Delete the color selection entry
        $colorSelection->delete();
    
        // Redirect to the vehicle edit page
        $vehicle = Vehicle::find($colorSelection->vehicle_id);
        return redirect()->route('vehicle.edit', ['id' => $vehicle->id])
            ->with('success', 'Color selection deleted successfully!');
    }
    
}
