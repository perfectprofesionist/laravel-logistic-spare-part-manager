<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllForm;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\DraftForm;
use App\Models\PublishedForm;
use Illuminate\Support\Facades\Storage;
use App\Models\Make;
use App\Models\CarModel;
use App\Models\Logics;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Support\Facades\Mail;
use App\Mail\SummaryMail;
use App\Mail\UserThankYouMail;

use App\Models\ProductRule;

/**
 * FormNewController Class
 *
 * Handles all form management operations including creation, editing,
 * publishing, and form submission processing. Manages both draft and published forms,
 * handles file uploads, form logic, and email notifications.
 */
class FormNewController extends Controller
{
    /**
     * Display the index page with all forms (drafts and published status)
     */
    public function index()
    {
        // Get all draft forms with their published form relationships
        $forms = DraftForm::with('publishedForm')
        ->orderBy('created_at', 'desc')
        ->get();

        // Get the form that is set as the home page
        $home_form = DraftForm::with('publishedForm')->where('set_as_home', 1)->get();
        
        return view('forms-new.index', compact('forms', 'home_form'));
    }
    
    /**
     * Show the form creation page
     */
    public function create()
    {
        return view('forms-new.create');
    }
    
    /**
     * Store a new form (draft)
     *
     * Validates input, generates a unique slug, and creates a new draft form.
     */
    public function store(Request $request)
    {
        // Validate form input with unique name constraint
        $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z0-9\- ]+$/',
                'max:30',
                'unique:draft_forms,name', // Ensure form name is unique
            ],
            'admin_emails' => 'required',
        ]);
 
        // Generate a unique slug for the form
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;

        // Check if the slug exists and increment until it's unique
        while (DraftForm::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Initialize empty steps array for the form
        $defaultSteps = [];

        // Create the new draft form
        $form = DraftForm::create([
            'name' => $request->name,
            'slug' => $slug,
            'steps' => $defaultSteps,
            'logic' => [],
            'admin_emails' => $request->admin_emails,
        ]);
        
        return redirect()->route('forms-new.edit', $form->id)->with('success', 'Form created successfully! You can now start building your form.');
    }
    
    /**
     * Store form steps configuration
     *
     * Updates the form steps based on a comma-separated list of step names.
     * Preserves existing step data while updating the step structure.
     */
      public function storeOnlyFormSteps(Request $request)
    {
         // Validate the form steps input
         $request->validate([
            'form_steps_list_input' => [
                'required',
                'string',
                'max:255',
                'regex:/^([A-Za-z0-9\- ]+)(,\s*[A-Za-z0-9\- ]+)*$/'
            ],
            'id' => 'required|integer',
        ]);

        // Split the comma-separated steps into an array
        $formStepsList = explode(",", $request->form_steps_list_input);

        // Find the draft form
        $draftForm = DraftForm::find($request->id);

        if (!$draftForm) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found.',
            ], 404);
        }

        // Get existing steps or initialize empty array
        $existingSteps = $draftForm->steps ?? [];

        $newSteps = [];

        // Process each step and preserve existing data
        foreach ($formStepsList as $index => $stepTitle) {
            $stepId = "step-$index";

            // Try to find existing step by ID to preserve data
            $existingStep = collect($existingSteps)->firstWhere('id', $stepId);

            $newSteps[] = [
                'id' => $stepId,
                'title' => $stepTitle,
                'label' => $stepTitle,
                'order' => $existingStep['order'] ?? 0,
                'mainHeading' => $existingStep['mainHeading'] ?? '',
                'subheading' => $existingStep['subheading'] ?? '',
                'sideHeading' => $existingStep['sideHeading'] ?? '',
                'template' => $existingStep['template'] ?? '',
                'fields' => $existingStep['fields'] ?? [],
            ];
        }

        // Update the form with new steps
        $draftForm->steps = $newSteps;
        $draftForm->save();

        return response()->json([
            'success' => true,
            'message' => 'Form steps updated successfully.',
        ]);
    }
    
    /**
     * Publish a draft form (creates or updates a published form)
     */
    public function publish($id)
    {
        $draftForm = DraftForm::findOrFail($id);
        
        // Check if already published
        if ($draftForm->publishedForm) {
            // Update existing published form
            $draftForm->publishedForm->update([
                'name' => $draftForm->name,
                'steps' => $draftForm->steps,
                'logic' => $draftForm->logic
            ]);
            $publishedForm = $draftForm->publishedForm;
        } else {
            // Create new published form
            $publishedForm = $draftForm->publish();
        }
        
        return response()->json([
            'message' => 'Form published successfully',
            'form' => $publishedForm
        ]);
    }
    
    /**
     * Show the form builder interface for a specific form
     */
    public function form_builder($id)
    {
        $form = DraftForm::findOrFail($id);
        return view('forms.form_builder', compact('form'));
    }
    
    /**
     * Show the form edit page with all related data (recipes, logics, products, makes)
     */
    public function edit($id)
    {
        $form = DraftForm::findOrFail($id);
        $recipes = Recipe::select('id', 'title', 'display_text')->get();
        $logics = Logics::with('recipe')->get();
        $products = Product::all();
        $makes = Make::all();
        return view('forms-new.edit', compact('form', 'recipes', 'logics','products', 'makes'));
    }
    
    /**
     * Upload color selection images to public/color_images
     */
    public function uploadColorImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $destinationPath = public_path('color_images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $imagePath = asset("color_images/{$filename}");
            $path = parse_url($imagePath, PHP_URL_PATH);
            
            return response()->json([
                'filePath' => $imagePath,
                'path' => $path
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    /**
     * Upload white color option images to public/radio_images/white
     */
    public function uploadWhiteImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $destinationPath = public_path('radio_images/white');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $imagePath = asset("radio_images/white/{$filename}");
            $path = parse_url($imagePath, PHP_URL_PATH);
            
            return response()->json([
                'filePath' => $imagePath,
                'path' => $path
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    /**
     * Delete white color option images from the server
     */
    public function deleteWhiteImage(Request $request)
    {
        $imageUrl = $request->input('image_url');
        if (!$imageUrl) {
            return response()->json(['error' => 'Image URL required'], 400);
        }
        
        $path = parse_url($imageUrl, PHP_URL_PATH); // e.g., /radio_images/white/xxx.jpg
        $filePath = public_path($path);
        
        if (file_exists($filePath)) {
            unlink($filePath);
            return response()->json(['message' => 'Deleted']);
        }
        
        return response()->json(['message' => 'File not found'], 404);
    }
    
    /**
     * Upload black color option images to public/radio_images/black
     */
    public function uploadBlackImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $destinationPath = public_path('radio_images/black');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $imagePath = asset("radio_images/black/{$filename}");
            $path = parse_url($imagePath, PHP_URL_PATH);
            
            return response()->json([
                'filePath' => $imagePath,
                'path' => $path
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    /**
     * Delete black color option images from the server
     */
    public function deleteBlackImage(Request $request)
    {
        $imageUrl = $request->input('image_url');
        if (!$imageUrl) {
            return response()->json(['error' => 'Image URL required'], 400);
        }
        
        $path = parse_url($imageUrl, PHP_URL_PATH); // /radio_images/black/xxx.jpg
        $filePath = public_path($path);
        
        if (file_exists($filePath)) {
            unlink($filePath);
            return response()->json(['message' => 'Deleted']);
        }
        
        return response()->json(['message' => 'File not found'], 404);
    }
    
    /**
     * Upload slide images to public/slide_images
     */
    public function uploadSlideImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $destinationPath = public_path('slide_images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $imagePath = asset("slide_images/{$filename}");
            $path = parse_url($imagePath, PHP_URL_PATH);
            
            return response()->json([
                'filePath' => $imagePath,
                'path' => $path
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    /**
     * Update form step data (single step)
     *
     * Updates a specific step within a form with new data.
     */
    public function update(Request $request, $id)
    {
        $inputStep = json_decode(json_encode($request->steps), true);
        $formData = DraftForm::where(['id' => $id])->first();
        $formSteps =   json_decode(json_encode($formData->steps), true);
        
        // Find and update the specific step
        foreach($formSteps as $key => $fStep){
            if($fStep["id"] == $inputStep["id"]) {
                $formSteps[$key] = $inputStep;
                $formData->update([
                    'steps' => $formSteps
                ]);
                return response()->json([
                    'message' => 'Form updated successfully'
                ]);
            }
        }
    }
    
    /**
     * Soft delete a form (prefix slug and soft delete record)
     */
    public function destroy($id)
    {
        $form = DraftForm::findOrFail($id);
        
        // Prefix the slug with a UUID and double slashes for soft delete
        $form->slug = Str::uuid() . '--' . $form->slug;
        $form->save(); // Save updated slug before soft delete
        
        $form->delete(); // Soft delete
        
        return response()->json([
            'message' => 'Form deleted successfully'
        ]);
    }
    
    /**
     * Duplicate a form (copy all steps, logic, and data)
     */
    public function duplicate($id)
    {
        $originalForm = DraftForm::findOrFail($id);
        
        // Start with base slug
        $slugBase = $originalForm->slug . '-Copy';
        $slug = $slugBase;
        
        // Check if slug exists already and generate unique one
        $counter = 0;
        while (DraftForm::where('slug', $slug)->exists()) {
            // Append a random 2–4 digit number
            $slug = $slugBase . '-' . rand(10, 9999);
            if (++$counter > 10) {
                return response()->json(['message' => 'Failed to generate a unique slug'], 500);
            }
        }
        
        // Create the duplicated form
        $duplicatedForm = DraftForm::create([
            'name' => $originalForm->name . ' (Copy)',
            'slug' => $slug,
            'steps' => $originalForm->steps,
            'logic' => $originalForm->logic,
            'admin_emails' => $originalForm->admin_emails,
        ]);
        
        // Duplicate associated logics
        $logics = Logics::where('form_id', $originalForm->id)->get();
        
        foreach ($logics as $logic) {
            Logics::create([
                'recipe_id' => $logic->recipe_id,
                'parameters' => $logic->parameters,
                'form_id' => $duplicatedForm->id,
                "name" => $logic->name,
            ]);
        }
        
        return response()->json([
            'message' => 'Form duplicated successfully new',
            'form' => $duplicatedForm
        ]);
    }
    
    /**
     * Display a form for public viewing (published or if user is authenticated)
     */
    public function showForm($slug)
    {
        $draftForm = DraftForm::where('slug', $slug)->first();
        
        if (!$draftForm) {
            throw new NotFoundHttpException();
        }
        
        // Check if form is published or user is authenticated
        if ($draftForm->status !== 'published' && !Auth::check()) {
            throw new NotFoundHttpException();
        }
        
        // Load all necessary data for form rendering
        $makes = Make::with('models')->orderBy('name', "asc")->get();
        $models = CarModel::all();
        $products = Product::all();
        $logics = Logics::with(["recipe"])->where('form_id', $draftForm->id)->get();
        $productRules = ProductRule::get();
        
        // Create a new form submission (with empty data)
        $submitguid = (string) Str::uuid();
        
        FormSubmission::create([
            'guid' => $submitguid,
        ]);
        $messages = Message::pluck('text', 'id')->toArray();
        return view('forms.formView', [
            'form' => $draftForm,
            'submitguid' => $submitguid,
            'makes' => $makes,
            'models' => $models,
            'products' => $products,
            'logics' => $logics,
            'productRules' => $productRules,
             'messages' => $messages
        ]); // Changed 'forms.show' to 'forms.view'
    }
    
    /**
     * Display the home form (set as home page)
     */
    public function homeform()
    {
        $homeForm = DraftForm::where('set_as_home', true)->first();
        
        if (!$homeForm) {
            throw new NotFoundHttpException();
        }
        
        // Check if form is published or user is authenticated
        if ($homeForm->status !== 'published' && !Auth::check()) {
            throw new NotFoundHttpException();
        }
        
        // Load all necessary data for form rendering
        $makes = Make::with('models')->get();
        $models = CarModel::all();
        $products = Product::all();
        $logics = Logics::with(["recipe"])->where('form_id', $homeForm->id)->get();
        
        // Create a new form submission (with empty data)
        $submitguid = (string) Str::uuid();
        $productRules = ProductRule::get();
        $messages = Message::pluck('text', 'id')->toArray();
        FormSubmission::create([
            'guid' => $submitguid,
        ]);
        
        return view('forms.formView', [
            'form' => $homeForm,
            'submitguid' => $submitguid,
            'makes' => $makes,
            'models' => $models,
            'products' => $products,
            'logics' => $logics,
            'productRules' => $productRules,
            'messages' => $messages
        ]);
    }
    
    /**
     * Set a form as the home form (resets all others)
     */
    public function setAsHome(Request $request)
    {
        $formId = $request->id;
        
        // Reset all forms' home status
        DraftForm::query()->update(['set_as_home' => false]);
        
        // Set selected form as home
        DraftForm::where('id', $formId)->update(['set_as_home' => true]);
        
        return response()->json([
            'message' => 'Form duplicated successfully',
        ]);
    }
    
    /**
     * Get car models for a specific make (AJAX)
     */
    public function getModels(Request $request)
    {
        $models = CarModel::where('make_id', $request->make_id)->get();
        return response()->json(['models' => $models]);
    }
    
    /**
     * Send summary email after form submission
     *
     * Processes form submission data and sends emails to admin(s) and user.
     * Updates form submission status and handles email notifications.
     */
    public function sendSummaryEmail(Request $request)
    {
        $formSlug = $request->form_slug;
        $submitguid = $request->submitguid;
        
        // Find and update the form submission
        $submission = FormSubmission::where('guid', $submitguid)->first();
        
        if ($submission) {
            $submission->is_submitted = true; // mark as submitted if needed
            $submission->save();
        }
        
        // Extract user email from request
        $userEmail = $request->email ?? ($request->additional_data['email'] ?? null);
        $summary = $request->summary;
        $interests = $request->interests;
        $additionalData = $request->additional_data;
        $fallbackAdminEmail = 'test@test.com';
        
        // Find the form to get admin emails
        $form = DraftForm::where('slug', $formSlug)->first();
        
        if (!$form) {
            return response()->json(['message' => 'Form not found.'], 404);
        }
        
        $adminEmails = [];
        // Process admin emails from form
        if ($form->admin_emails) {
            $adminEmails = explode(',', $form->admin_emails);
            $adminEmails = array_filter(array_map('trim', $adminEmails)); // clean up
        }
        // Use fallback if no valid admin emails
        if (empty($adminEmails)) {
            $adminEmails = [$fallbackAdminEmail];
        }
        // Send summary email to each admin
        foreach ($adminEmails as $email) {
            Mail::to($email)->send(new SummaryMail($summary, $interests, $additionalData));
        }
        // Send thank you email to user if email provided
        if ($userEmail) {
            $userMailSent = false;
            try {
                Mail::to($userEmail)->send(new UserThankYouMail());
                $userMailSent = true;
            } catch (\Exception $e) {
                \Log::error("User thank you email failed: " . $e->getMessage());
            }
        } else {
            $userMailSent = false; // User email not sent as it was null
        }
        
        return response()->json([
            'message' => 'Email sent successfully',
            'user_mail_sent' => $userMailSent
        ]);
    }
    
    /**
     * Auto-save form submission data (periodic save during filling)
     */
    public function autoSave(Request $request)
    {
        $submitGuid = $request->submitguid;
        $options = $request->options;
        $formid = $request->formId;
        
        $submission = FormSubmission::where('guid', $submitGuid)->first();
        
        if ($submission) {
            $submission->options = json_encode($options); // update only options
            $submission->form_slug = $formid;
            $submission->save();
            
            return response()->json(['status' => 'success', 'message' => 'Auto-saved']);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Submission not found'], 404);
    }
    
    /**
     * Save admin emails for a form
     *
     * Updates the admin email addresses for receiving form submissions.
     */
    public function saveAdminEmails(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:draft_forms,id',
            'admin_emails' => 'nullable|string',
        ]);
        
        // Update directly on the draft_forms table
        DraftForm::where('id', $request->id)->update([
            'admin_emails' => $request->admin_emails
        ]);
        
        return response()->json(['message' => 'Admin emails saved successfully.']);
    }
    
    /**
     * Toggle form status between published and draft
     */
    public function toggleStatus($id)
    {
        $form = DraftForm::findOrFail($id);
        
        $form->status = $form->status === 'published' ? 'draft' : 'published';
        $form->save();
        
        return response()->json([
            'message' => 'Form status changed to ' . $form->status,
            'status' => $form->status
        ]);
    }

    /**
     * Show form conditions/logic management page
     *
     * Displays all logic rules associated with a specific form.
     */
    public function showConditions($id)
    {
        $form = DraftForm::findOrFail($id); // get the form
        $logics = Logics::where('form_id', $id)->get(); // get all logics for this form ID
        return view('forms-new.form_conditions', compact('form', 'logics'));
    }

    /**
     * Show add new condition page (logic builder)
     */
    public function addCondition($id)
    {
        $form = DraftForm::findOrFail($id);
        $recipes = Recipe::all()->keyBy('id'); // key by ID for easy access in JS
        $products = Product::all();
        return view('forms-new.add_new_condition', compact('form', 'recipes','products'));
    }

    /**
     * Store new logic condition (rule)
     */
    public function storelogic(Request $request)
    {
        $validated = $request->validate([
            'form_id' => 'required|integer',
            'recipe_id' => 'required|integer',
            'logic_json' => 'required|json',
            'condition_name' => 'required|string|max:255',
        ]);
        $formId = $validated['form_id'];
        $recipeId = $validated['recipe_id'];
        $name = $validated['condition_name'];
        $logicJson = json_decode($validated['logic_json'], true);
        $logics = json_encode($logicJson);
        // Save logic to DB
        Logics::create([
            'name' => $name,
            'recipe_id' => $recipeId,
            'parameters' => $logics, // JSON string
            'form_id' => $formId,
        ]);
        // Return a JSON response with the redirect URL
        return response()->json([
            'success' => true,
            'redirect_url' => route('form.conditions', ['id' => $formId]),
            'message' => 'Logic saved successfully.'
        ]);
    }

    /**
     * Show edit logic page (edit a logic rule)
     */
    public function editlogic($id)
    {
        $logic = Logics::findOrFail($id);
        $recipes = Recipe::all()->keyBy('id');
        $form = DraftForm::findOrFail($logic->form_id);
        $products = Product::all();
        return view('forms-new.edit_logic', compact('logic', 'recipes', 'form', 'products'));
    }

    /**
     * Update existing logic condition (rule)
     */
    public function updatelogic(Request $request, $id)
    {
        $validated = $request->validate([
            'condition_name' => 'required|string|max:255',
            'recipe_id' => 'required|integer',
            'logic_json' => 'required|json',
        ]);
        $logic = Logics::findOrFail($id);
        $logic->name = $validated['condition_name'];
        $logic->recipe_id = $validated['recipe_id'];
        $logic->parameters = json_encode(json_decode($validated['logic_json'], true)); // ensure valid JSON structure
        $logic->save();
        return response()->json([
            'success' => true,
            'redirect_url' => route('form.conditions', ['id' => $logic->form_id]),
            'message' => 'Condition updated successfully.'
        ]);
    }

    /**
     * Delete logic condition (rule)
     */
    public function deletelogic($id)
    {
        $logic = Logics::findOrFail($id);
        $formId = $logic->form_id;  // Get the form ID from the logic
        // Delete the logic entry
        $logic->delete();
        // Redirect to the form conditions page
        return redirect()->route('form.conditions', ['id' => $formId])->with('success', 'Condition deleted successfully.');
    }

    /**
     * Show form edit page (basic info: name and admin emails)
     */
    public function editopen(Request $request)
    {
        $formId = $request->query('id'); // ?id=123
        $form = DraftForm::findOrFail($formId);
        return view('forms-new.editform', compact('form'));
    }

    /**
     * Update form basic information (name and admin emails)
     */
    public function editform(Request $request, $id)
    {
        $form = DraftForm::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z0-9\- ]+$/',
                'max:30',
            ],
            'admin_emails' => 'required',
        ]);
        $form->update([
            'name' => $request->name,
            'admin_emails' => $request->admin_emails,
        ]);
        return redirect()->route('forms-new.edit', ['id' => $form->id])
            ->with('success', 'Form updated successfully!');
    }
}
