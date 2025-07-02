<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MakeModelImport;
use App\Imports\MakeImport;
use Illuminate\Support\Facades\Log;
use App\Exports\MakeModelExport;

use App\Models\Make;
use App\Models\CarModel;

/**
 * Controller for handling Excel/CSV import and export of Make and Model data.
 * Provides endpoints for uploading, validating, importing, and exporting car make/model data.
 * Handles user feedback, error handling, and logging for import operations.
 */
class ExcelImportController extends Controller
{
    /**
     * Show the import page for models.
     */
    public function importModel()
    {
        return view('model.import');
    }

    /**
     * Show the import page for makes.
     */
    public function importMake()
    {
        return view('make.import');
    }

    /**
     * Handle import of Make & Model data from uploaded file.
     * Validates file type, imports data, and provides user feedback.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv', // Only allow Excel or CSV files
        ]);

        // CarModel::query()->delete();  // deletes all car models
        // Make::query()->delete();      // deletes all makes

        try {
            // Import data using the MakeModelImport class
            Excel::import(new MakeModelImport, $request->file('file'));
            return back()->with('success', 'File imported successfully!');
            // return redirect()->route('make.index')->with('success', 'File imported successfully!');
        } catch (\Exception $e) {
            // Return error message if import fails
            return back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    /**
     * Handle import of Make data from uploaded file, with detailed logging.
     * Validates file, logs process, and provides user feedback.
     */
    public function makeimport(Request $request)
    {
        Log::info('Request received:', ['file' => $request->file('file')]);
    
        try {
            // Log before validation
            Log::info('Starting validation.');
            Log::info('File MIME Type:', ['mime' => $request->file('file')->getMimeType()]);

            $validated = $request->validate([
                'file' => 'required|mimes:xlsx,csv', // Only allow Excel or CSV files
            ]);
    
            // Log after validation
            Log::info('Validation Passed');
    
            // Import data using the MakeImport class
            Excel::import(new MakeImport, $request->file('file'));
    
            Log::info('File imported successfully.');
            return back()->with('success', 'Make data imported successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed:', $e->errors());
            return back()->with('error', 'Validation failed: ' . json_encode($e->errors()));
        } catch (\Exception $e) {
            // Log general errors
            Log::error('Error importing make data: ' . $e->getMessage());
            return back()->with('error', 'Error importing make data: ' . $e->getMessage());
        }
    }

    /**
     * Export all Make & Model data as an Excel file.
     */
    public function exportModel()
    {       
        return Excel::download(new MakeModelExport, 'make_models.xlsx');
    }
}

 
