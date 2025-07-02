<?php

namespace App\Exports;

use App\Models\CarModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * MakeModelExport Class
 * 
 * This class handles the export functionality for Car Make and Model data to Excel format.
 * It implements Laravel Excel package interfaces to generate downloadable Excel files
 * containing vehicle make and model information with their associated details.
 * 
 * @package App\Exports
 */
class MakeModelExport implements FromCollection, WithHeadings
{
    /**
     * Get the data collection for Excel export
     * 
     * This method retrieves all car models from the database along with their
     * associated make information, then transforms the data into a format
     * suitable for Excel export with specific column mappings.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Retrieve all car models with their associated make relationship
        return CarModel::with('make')
            ->get()
            ->map(function ($item) {
                // Transform each car model record into a flat array structure
                // suitable for Excel export with specific column names
                return [
                    'Make' => $item->make->name ?? 'N/A',        // Vehicle make name, fallback to 'N/A' if null
                    'Model' => $item->model_name,                // Vehicle model name
                    'Truck Type' => $item->truck_type,           // Type/category of the truck
                    'Model Price' => $item->price,               // Price of the model
                    'Series' => $item->years,                    // Year series or range
                ];
            });
    }

    /**
     * Define the column headings for the Excel file
     * 
     * This method returns an array of column headers that will appear
     * as the first row in the exported Excel file. The headers should
     * match the keys used in the collection() method's return array.
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            'Make',           // Column for vehicle manufacturer
            'Model',          // Column for vehicle model name
            'Truck Type',     // Column for truck category/type
            'Model Price',    // Column for model pricing
            'Series',         // Column for year series information
        ];
    }
}
