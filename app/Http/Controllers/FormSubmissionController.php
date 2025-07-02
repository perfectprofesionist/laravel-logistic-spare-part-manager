<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormSubmission;
use App\Models\AllForm;

class FormSubmissionController extends Controller
{


    public function autoSave(Request $request)
    {
        $submission = FormSubmission::where('guid', $request->guid)->first();

        if ($submission) {
            $submission->update([
                'options' => $request->options,
            
                'form_slug' => $request->form_slug,
            ]);
        }

        return response()->json(['status' => 'saved']);
    }

    public function submit(Request $request)
    {
        $submission = FormSubmission::where('guid', $request->guid)->first();

        if ($submission) {
            $submission->update([
                'summary' => $request->summary,
                'interests' => $request->interests,
                'additional_data' => $request->additional_data,
                'email' => $request->email,
                'form_slug' => $request->form_slug,
                'is_submitted' => true
            ]);

            // TODO: Send email if needed here...
        }

        return response()->json(['status' => 'submitted']);
    }



    public function formSubmissions($form)
    {

        $submissions = FormSubmission::where('form_slug', $form) // filter by form_id (form_slug stores the form's ID)
            ->orderByDesc('created_at') // Order by most recent first
            ->paginate(20); // Paginate results
    
        return view('form_submissions.index', compact('form', 'submissions'));
    }

    public function index()
    {
        $submissions = FormSubmission::orderBy('created_at', 'desc')->get();
        return view('form_submissions.index', compact('submissions'));
    }

    // Show a single submission
    public function show($id)
    {
        $submission = FormSubmission::findOrFail($id);

        $options = [];
        if ($submission->options) {
            $options = json_decode($submission->options, true);
        }

        return view('form_submissions.show', compact('submission', 'options'));
    }
}
