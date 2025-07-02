<?php

namespace App\Http\Controllers;

use App\Models\Logics;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeOrUpdate(Request $request)
    {
        $formId = '';
        $ids = [];
        // print_r($request->post());
        // die();
        if (count($request->post()) > 0) {
            foreach ($request->post() as $logic) {
                if (isset($logic['id'])) {
                    $ids[] = $logic['id'];
                }
                // Skip invalid entries
                if (!isset($logic['recipe_id']) || !isset($logic['form_id'])) {
                    continue;
                }

                $formId = $logic['form_id'];

                // Check if parameters are provided and valid
                if (!isset($logic['parameters']) || empty($logic['parameters'])) {
                    continue; // Skip entries without parameters
                }

                if (isset($logic['parameters']) && is_array($logic['parameters'])) {
                    $logic['parameters'] = json_encode($logic['parameters']);
                }

                // Use updateOrCreate to simplify logic
                $logicRecord = Logics::updateOrCreate(
                    ['id' => $logic['id'] ?: null], // Search by ID (or create if not provided)
                    $logic // Fields to update or insert
                );

               $ids [] = $logicRecord->id;
            }
            array_unique($ids);
            Logics::where('form_id', $logic['form_id'])->whereNotIn('id',  $ids)->delete();
        } else {
            // Logics::where('form_id', $request['form_id'])->delete();
           $formId = $request->get('form_id');
            Logics::where('form_id', $formId)->delete();
        }

        $logics = Logics::where("form_id", $formId)->get();
        return response()->json(['message' => 'Logics stored/updated successfully', "logics" => $logics], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Logics $logics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logics $logics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logics $logics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logics $logics)
    {
        //
    }

    /**
     * Get all logics for a specific form
     */
    public function getLogicsForForm($formId)
    {
        $logics = Logics::with('recipe')->where('form_id', $formId)->get();

        // Decode parameters JSON string to object for each logic
        $logics->each(function($logic) {
            if (is_string($logic->parameters)) {
                $logic->parameters = json_decode($logic->parameters, true);
            }
        });

        return response()->json($logics);
    }
}
