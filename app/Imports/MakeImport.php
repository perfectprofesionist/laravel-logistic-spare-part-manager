<?php
namespace App\Imports;

use App\Models\Make;
use Illuminate\Support\Facades\Log; // Import Log
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * MakeImport Class
 * 
 * This class handles the import functionality for Car Make data from Excel files.
 * It implements Laravel Excel package interfaces to process Excel files containing
 * vehicle make information and import them into the database.
 * 
 * The class processes Excel files with headers and creates or updates Make records
 * in the database, with comprehensive logging for debugging and monitoring.
 * 
 * @package App\Imports
 */
class MakeImport implements ToModel, WithHeadingRow
{
    /**
     * Process each row from the Excel file
     * 
     * This method is called for each row in the Excel file. It validates the data,
     * processes the make information, and creates or updates records in the database.
     * Includes comprehensive logging for debugging and monitoring import progress.
     * 
     * @param array $row The current row data from the Excel file
     * @return \App\Models\Make|null Returns the created/updated Make model or null if validation fails
     */
    public function model(array $row)
    {
        // Log the data coming from the file for debugging purposes
        Log::info('Excel Row Data:', $row);

        // Validate that the required 'make' column exists in the Excel file
        // This prevents errors when processing files with missing or incorrectly named columns
        if (!isset($row['make'])) {
            Log::error('Missing "make" column in uploaded file.', $row);
            return null; // Skip this row and continue with the next one
        }

        // Insert or update the make record in the database
        // Uses firstOrCreate to avoid duplicate entries - if the make already exists,
        // it will return the existing record; otherwise, it creates a new one
        $make = Make::firstOrCreate([
            'name' => trim($row['make']), // Trim whitespace from the make name
        ]);

        // Log successful insertion/retrieval for monitoring and debugging
        Log::info('Inserted Make:', ['name' => $make->name]);
        
        // Return the make model (required by ToModel interface)
        return $make;
    }
}


