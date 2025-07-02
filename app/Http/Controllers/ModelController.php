<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarModel;
use App\Models\Make;

/**
 * ModelController Class
 * 
 * This controller handles all car model management operations including creation, editing,
 * deletion, and data retrieval. It manages the relationship between car makes and models,
 * handles model pricing, and provides AJAX endpoints for dynamic form population.
 * 
 * The controller supports CRUD operations for car models and includes methods for
 * retrieving related data for dropdown menus and pricing calculations.
 * 
 * @package App\Http\Controllers
 */
class ModelController extends Controller
{
    /**
     * Display the index page with all car models
     * 
     * Shows a paginated list of all car models, ordered by latest first.
     * Displays 20 models per page for better performance and user experience.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Paginate car models, 20 per page for better performance
        $model = CarModel::latest()->paginate(20);

        return view('model.index', compact('model')); // Pass the paginated models to the view
    }

    /**
     * Show the car model creation page
     * 
     * Displays the form for creating a new car model with all available makes
     * for selection in a dropdown menu.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $makes = Make::all(); // Fetch all makes for dropdown selection
        return view('model.create', compact('makes')); // Pass makes to the view
    }

    /**
     * Store a new car model
     * 
     * Validates and creates a new car model record in the database.
     * Includes validation for model name, truck type, price, make relationship,
     * and years (stored as comma-separated string).
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'model_name' => 'required|string|max:255',
            'truck_type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'make_id' => 'required|exists:make,id', // Ensure make exists
            /*'years' => 'required|array', // Expecting an array of years
            'years.*' => 'integer'*/

            'years' => 'required|string', // Years stored as comma-separated string
        ]);

        //$validated['years'] = implode(',', $validated['years']); // Convert array to string if needed
        // Create the car model record
        CarModel::create($validated);

        return redirect()->route('model.index')->with('success', 'Product added successfully!');
    }


    /**
     * Show the car model edit page
     * 
     * Displays the form for editing an existing car model. Loads the current
     * model data and all available makes for selection. Converts the years
     * string back to an array for form population.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $model = CarModel::findOrFail($id);
        $makes = Make::all(); // Fetch all makes for dropdown selection
        $selectedYears = explode(',', $model->years); // Convert years string to array
        return view('model.edit', compact('model', 'makes', 'selectedYears'));
    }


    /**
     * Update an existing car model
     * 
     * Validates and updates an existing car model record in the database.
     * Uses the same validation rules as the store method for consistency.
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'model_name' => 'required|string|max:255',
            'truck_type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'make_id' => 'required|exists:make,id', // Ensure make exists
            /*'years' => 'required|array',
            'years.*' => 'integer'*/
            'years' => 'required|string', // Years stored as comma-separated string
        ]);

        //$validated['years'] = implode(',', $validated['years']); // Convert array to string if needed

        // Find and update the car model
        $model = CarModel::findOrFail($id);
        $model->update($validated);

        return redirect()->route('model.index')->with('success', 'Model updated successfully!');
    }


    /**
     * Delete a car model
     * 
     * Performs a soft delete on the car model record. The method includes
     * commented code for handling related vehicle records if needed in the future.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $model = CarModel::findOrFail($id);

        // // Soft delete all related vehicles (commented for future use)
        // $model->vehicles()->each(function ($vehicle) {
        //     $vehicle->delete();
        // });

        // Soft delete the car model
        $model->delete();

        return redirect()->route('model.index')->with('success', 'Model deleted successfully!');
    }


    /**
     * Get car models for a specific make (AJAX endpoint)
     * 
     * Returns HTML options for a dropdown menu containing all models
     * associated with the specified make. Used for dynamic form population.
     * 
     * @param int $makeId
     * @return string HTML options for dropdown
     */
    public function getModel($makeId)
    {
        // Fetch models for the specified make
        $models =  CarModel::select('id', 'model_name')->where('make_id', $makeId)->get();

?>
        <option value="">Select Model</option>
        <?php

        // Generate HTML options for each model
        foreach ($models as $model) {
        ?>
            <option value="<?= $model->model_name ?>" data-id="<?= $model->id ?>"><?= $model->model_name ?></option>
        <?php

        }
    }


    /**
     * Get years for a specific car model (AJAX endpoint)
     * 
     * Returns HTML options for a dropdown menu containing all years
     * associated with the specified model. Includes truck type and price
     * as data attributes for JavaScript processing.
     * 
     * @param int $modelId
     * @return string HTML options for dropdown
     */
    public function getYear($modelId)
    {
        // Fetch model details including years, truck type, and price
        $model =  CarModel::select('id', 'years', 'truck_type', 'price')->where('id', $modelId)->first();
        $years = [];
        if (!empty($model)) {
            $years = explode(',', $model->years); // Convert years string to array
        }

        ?>
        <option value="">Select Year</option>
        <?php

        // Generate HTML options for each year with additional data attributes
        foreach ($years as $year) {
        ?>
            <option value="<?= $year ?>" data-truck-type="<?= $model->truck_type ?>" data-price="<?= $model->price ?>"><?= $year ?></option>
<?php
        }
    }


    /**
     * Get price for specific car model configuration (AJAX endpoint)
     * 
     * Returns the price for a car model based on make, model, year, and truck type.
     * Used for dynamic pricing calculations in forms.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrice(Request $request)
    {
        // Extract parameters from the request
        $make = $request->input('make');
        $model = $request->input('model');
        $year = $request->input('year');
        $truckType = $request->input('truckType');

        // Find the specific model with matching criteria
        $model = CarModel::select('price')->where('id', $model)->where('make_id', $make)->where('years', $year)->where('truck_type', $truckType)->first();
        return response()->json(['price' => $model->price]);
    }
}
