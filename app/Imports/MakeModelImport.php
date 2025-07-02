<?php

namespace App\Imports;

use App\Models\Make;
use App\Models\CarModel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Import class for handling Make and CarModel data from Excel/CSV files.
 * Reads each row, creates or updates Make and CarModel records, and logs errors.
 * Handles data cleaning for price and series fields.
 */
class MakeModelImport implements ToModel, WithHeadingRow
{
    /**
     * Process a single row from the import file.
     * Creates or updates Make and CarModel records, cleans data, and logs errors.
     */
    public function model(array $row)
    {
        // CarModel::query()->delete();  // deletes all car models
        // Make::query()->delete();      // deletes all makes

        // Log::info('--- Starting Row Import ---');
        // Log::info('Raw Row Data:', $row);

        try {
            // Step 1: Create or find Make by name (case-insensitive, trimmed)
            $make = Make::updateOrCreate(
                ['name' => trim($row['make'])],
                ['created_at' => now(), 'updated_at' => now()]
            );

            // Step 2: Store series in "years" field (comma-separated string)
            $series = '';
            if (!empty($row['series'])) {
                $series = trim($row['series']);
            }

            // Step 3: Clean price (remove non-numeric characters except dot)
            $price = null;
            if (!empty($row['model_price'])) {
                $price = preg_replace('/[^\d.]/', '', $row['model_price']);
            }

            // Step 4: Create or update CarModel with imported data
            CarModel::updateOrCreate(
                [
                    'model_name' => trim($row['model']),
                    'make_id' => $make->id,
                ],
                [
                    'truck_type' => trim($row['truck_type']),
                    'price' => $price,
                    'years' => $series,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        } catch (\Throwable $e) {
            // Log error with row data for debugging
            Log::error('Error Importing Row', [
                'row' => $row,
                'error' => $e->getMessage(),
            ]);
        }

        // Log::info('--- End Row Import ---');
    }
}
