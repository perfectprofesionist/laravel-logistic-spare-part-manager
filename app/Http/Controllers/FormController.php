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
use App\Models\Message;

class FormController extends Controller
{
    public function index()
    {
        $forms = DraftForm::with('publishedForm')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $defaultSteps = [
                [
                    "id" => "step-1",
                    "title" => "step-1",
                    "order" => 0,
                    "label" => "step-1",
                    "mainHeading" => "",
                    "subheading" => "",
                    "sideHeading" => "",
                    "template" => "1",
                    "fields" => []
                ]
            ];

            // Create a new form with just the name
            $form = DraftForm::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'steps' => $defaultSteps, // Initialize with empty steps array
                'logic' => [] // Initialize with empty logic array
            ]);

            return redirect()->route('forms.edit', $form->id)->with('success', 'Form created successfully! You can now start building your form.');
        } catch (\Exception $e) {
            Log::error('Error creating form: ' . $e->getMessage());
            return back()->with('error', 'Error creating form: ' . $e->getMessage());
        }
    }

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

    public function form_builder($id)
    {
        $form = DraftForm::findOrFail($id);
        return view('forms.form_builder', compact('form'));
    }

    public function edit($id)
    {
        $form = DraftForm::findOrFail($id);
        $recipes = Recipe::select('id', 'title', 'display_text')->get();
        $logics = Logics::with('recipe')->get();
        $products = Product::all();
        $makes = Make::all();
        // return $form;
        return view('forms.edit', compact('form', 'recipes', 'logics','products', 'makes'));
    }

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

    // Handle White Image Uploads
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


    // Handle Black Image Uploads
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


    // Handle Slide Image Uploads
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

    public function update(Request $request, $id)
    {
        // Log::info('Update function called', ['id' => $id]);

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:draft_forms,slug,' . $id,
                'steps' => 'nullable|json',
                'logic' => 'nullable|json',
                // 'code' => 'nullable|string',
                'white_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'black_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'color_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'slide_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            Log::info('Slug value received for update', ['slug' => $validatedData['slug']]);
            // Log::info('Request validated successfully', ['validatedData' => $validatedData]);

            $form = DraftForm::findOrFail($id);
            Log::info('Form found', ['form' => $form]);

            $stepIndex = $request->input('step_index');
            Log::info('Received step index:', ['index' => $stepIndex]);

            if ($stepIndex === 0 || $stepIndex === '0') {
                Log::warning('Step index is 0 — clearing all steps in form.');
                $form->steps = []; // clear the JSON field
                $form->save();
            }

            if (!empty($validatedData['steps'])) {
                $steps = json_decode($validatedData['steps'], true);
                // Log::info('Form steps', ['steps' => $steps]);
                if (!is_array($steps)) {
                    Log::error('Steps data is not a valid array', ['steps' => $validatedData['steps']]);
                    $steps = []; // prevent crash
                }

                // return $steps;

                // // Handle color image uploads
                // if ($request->hasFile('color_images')) {
                //     Log::info('Color images found in request');
                //     $colorImagePaths = [];
                //     $colorImageLocations = [];

                //     // foreach ($request->file('color_images') as $index => $image) {
                //     //     $path = $image->store('color_images', 'public');
                //     //     $colorImagePaths[] = Storage::url($path);

                //     //     if ($request->has('color_image_locations') && isset($request->color_image_locations[$index])) {
                //     //         $colorImageLocations[] = json_decode($request->color_image_locations[$index], true);
                //     //     }
                //     // }

                //     foreach ($request->file('color_images') as $index => $image) {
                //         $destinationPath = public_path('color_images');
                //         if (!file_exists($destinationPath)) {
                //             mkdir($destinationPath, 0777, true);
                //         }
                //         $filename = time() . '_' . $image->getClientOriginalName();
                //         $image->move($destinationPath, $filename);
                //         $colorImagePaths[] = asset("color_images/{$filename}");
                //         if ($request->has('color_image_locations') && isset($request->color_image_locations[$index])) {
                //             $colorImageLocations[] = json_decode($request->color_image_locations[$index], true);
                //         }
                //     }

                //     Log::info('Color images uploaded', [
                //         'paths' => $colorImagePaths,
                //         'locations' => $colorImageLocations
                //     ]);

                //     foreach ($colorImageLocations as $index => $location) {
                //         if (
                //             isset($location['stepIndex']) &&
                //             isset($location['fieldIndex']) &&
                //             isset($location['optionIndex']) &&
                //             isset($colorImagePaths[$index])
                //         ) {

                //             $stepIndex = $location['stepIndex'];
                //             $fieldIndex = $location['fieldIndex'];
                //             $optionIndex = $location['optionIndex'];

                //             if (isset($steps[$stepIndex]['fields'][$fieldIndex]['colors'][$optionIndex])) {
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['colors'][$optionIndex]['image_url'] = $colorImagePaths[$index];
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['colors'][$optionIndex]['imageData'] = $colorImagePaths[$index];
                //             }
                //         }
                //     }
                // }

                // // Handle white image uploads
                // if ($request->hasFile('white_images')) {
                //     Log::info('White images found in request');
                //     $whiteImagePaths = [];
                //     $whiteImageLocations = [];

                //     // // Store the images and track their paths
                //     // foreach ($request->file('white_images') as $index => $image) {
                //     //     $path = $image->store('radio_images/white', 'public');
                //     //     $whiteImagePaths[] = Storage::url($path);

                //     //     // Get the location metadata for this image
                //     //     if ($request->has('white_image_locations') && isset($request->white_image_locations[$index])) {
                //     //         $whiteImageLocations[] = json_decode($request->white_image_locations[$index], true);
                //     //     }
                //     // }

                //     foreach ($request->file('white_images') as $index => $image) {
                //         $destinationPath = public_path('radio_images/white');
                //         if (!file_exists($destinationPath)) {
                //             mkdir($destinationPath, 0777, true);
                //         }
                //         $filename = time() . '_' . $image->getClientOriginalName();
                //         $image->move($destinationPath, $filename);
                //         $whiteImagePaths[] = asset("radio_images/white/{$filename}");
                //         if ($request->has('white_image_locations') && isset($request->white_image_locations[$index])) {
                //             $whiteImageLocations[] = json_decode($request->white_image_locations[$index], true);
                //         }
                //     }


                //     Log::info('White images uploaded', [
                //         'paths' => $whiteImagePaths,
                //         'locations' => $whiteImageLocations
                //     ]);

                //     // Update steps with white image URLs
                //     foreach ($whiteImageLocations as $index => $location) {
                //         if (
                //             isset($location['stepIndex']) &&
                //             isset($location['fieldIndex']) &&
                //             isset($location['optionIndex']) &&
                //             isset($whiteImagePaths[$index])
                //         ) {

                //             $stepIndex = $location['stepIndex'];
                //             $fieldIndex = $location['fieldIndex'];
                //             $optionIndex = $location['optionIndex'];

                //             // Safely update the image URL
                //             if (isset($steps[$stepIndex]['fields'][$fieldIndex]['options'][$optionIndex])) {
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['options'][$optionIndex]['white_image_url'] = $whiteImagePaths[$index];
                //                 // Also update whiteImage property for consistency
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['options'][$optionIndex]['whiteImage'] = $whiteImagePaths[$index];
                //             }
                //         }
                //     }
                // }

                // // Handle black image uploads
                // if ($request->hasFile('black_images')) {
                //     Log::info('Black images found in request');
                //     $blackImagePaths = [];
                //     $blackImageLocations = [];

                //     // // Store the images and track their paths
                //     // foreach ($request->file('black_images') as $index => $image) {
                //     //     $path = $image->store('radio_images/black', 'public');
                //     //     $blackImagePaths[] = Storage::url($path);

                //     //     // Get the location metadata for this image
                //     //     if ($request->has('black_image_locations') && isset($request->black_image_locations[$index])) {
                //     //         $blackImageLocations[] = json_decode($request->black_image_locations[$index], true);
                //     //     }
                //     // }

                //     foreach ($request->file('black_images') as $index => $image) {
                //         $destinationPath = public_path('radio_images/black');
                //         if (!file_exists($destinationPath)) {
                //             mkdir($destinationPath, 0777, true);
                //         }
                //         $filename = time() . '_' . $image->getClientOriginalName();
                //         $image->move($destinationPath, $filename);
                //         $blackImagePaths[] = asset("radio_images/black/{$filename}");
                //         if ($request->has('black_image_locations') && isset($request->black_image_locations[$index])) {
                //             $blackImageLocations[] = json_decode($request->black_image_locations[$index], true);
                //         }
                //     }

                //     Log::info('Black images uploaded', [
                //         'paths' => $blackImagePaths,
                //         'locations' => $blackImageLocations
                //     ]);

                //     // Update steps with black image URLs
                //     foreach ($blackImageLocations as $index => $location) {
                //         if (
                //             isset($location['stepIndex']) &&
                //             isset($location['fieldIndex']) &&
                //             isset($location['optionIndex']) &&
                //             isset($blackImagePaths[$index])
                //         ) {

                //             $stepIndex = $location['stepIndex'];
                //             $fieldIndex = $location['fieldIndex'];
                //             $optionIndex = $location['optionIndex'];

                //             // Safely update the image URL
                //             if (isset($steps[$stepIndex]['fields'][$fieldIndex]['options'][$optionIndex])) {
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['options'][$optionIndex]['black_image_url'] = $blackImagePaths[$index];
                //                 // Also update blackImage property for consistency
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['options'][$optionIndex]['blackImage'] = $blackImagePaths[$index];
                //             }
                //         }
                //     }
                // }

                // // Handle slide image uploads
                // if ($request->hasFile('slide_images')) {
                //     Log::info('Slide images found in request');
                //     $slideImagePaths = [];
                //     $slideImageLocations = [];

                //     // // Store the images and track their paths
                //     // foreach ($request->file('slide_images') as $index => $image) {
                //     //     $path = $image->store('slide_images', 'public');
                //     //     $slideImagePaths[] = Storage::url($path);

                //     //     // Get the location metadata for this image
                //     //     if ($request->has('slide_image_locations') && isset($request->slide_image_locations[$index])) {
                //     //         $slideImageLocations[] = json_decode($request->slide_image_locations[$index], true);
                //     //     }
                //     // }

                //     foreach ($request->file('slide_images') as $index => $image) {
                //         // Define the destination path in the public folder
                //         $destinationPath = public_path('slide_images');

                //         // Ensure the directory exists
                //         if (!file_exists($destinationPath)) {
                //             mkdir($destinationPath, 0777, true);
                //         }

                //         // Generate a unique filename
                //         $filename = time() . '_' . $image->getClientOriginalName();

                //         // Move the file to the public/slide_images directory
                //         $image->move($destinationPath, $filename);

                //         // Store the public URL path
                //         $slideImagePaths[] = asset("slide_images/{$filename}");

                //         // Handle locations if provided
                //         if ($request->has('slide_image_locations') && isset($request->slide_image_locations[$index])) {
                //             $slideImageLocations[] = json_decode($request->slide_image_locations[$index], true);
                //         }
                //     }

                //     Log::info('Slide images uploaded', [
                //         'paths' => $slideImagePaths,
                //         'locations' => $slideImageLocations
                //     ]);

                //     // Update steps with slide image URLs
                //     foreach ($slideImageLocations as $index => $location) {
                //         if (
                //             isset($location['stepIndex']) &&
                //             isset($location['fieldIndex']) &&
                //             isset($location['optionIndex']) &&
                //             isset($slideImagePaths[$index])
                //         ) {

                //             $stepIndex = $location['stepIndex'];
                //             $fieldIndex = $location['fieldIndex'];
                //             $optionIndex = $location['optionIndex'];

                //             // Safely update the image URL
                //             if (isset($steps[$stepIndex]['fields'][$fieldIndex]['slideOptions'][$optionIndex])) {
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['slideOptions'][$optionIndex]['image_url'] = $slideImagePaths[$index];
                //                 // Also update imageData property for consistency
                //                 $steps[$stepIndex]['fields'][$fieldIndex]['slideOptions'][$optionIndex]['imageData'] = $slideImagePaths[$index];
                //             }
                //         }
                //     }
                // }

                // // Process and normalize all color option data
                // foreach ($steps as &$step) {
                //     if (isset($step['fields']) && is_array($step['fields'])) {
                //         foreach ($step['fields'] as &$field) {
                //             if ($field['type'] === 'colors' && isset($field['colors']) && is_array($field['colors']) ) {
                //                 foreach ($field['colors'] as &$color) {
                //                     // Ensure all expected properties exist
                //                     if (!isset($color['name'])) $color['name'] = '';
                //                     if (!isset($color['label'])) $color['label'] = '';
                //                     if (!isset($color['image_url'])) $color['image_url'] = null;
                //                     if (!isset($color['imageData'])) $color['imageData'] = null;

                //                     // Ensure consistency between property names
                //                     if (isset($color['image_url']) && !isset($color['imageData'])) {
                //                         $color['imageData'] = $color['image_url'];
                //                     } elseif (isset($color['imageData']) && !isset($color['image_url'])) {
                //                         $color['image_url'] = $color['imageData'];
                //                     }
                //                 }
                //             }
                //         }
                //     }
                // }

                // Process and normalize all custom radio option data
                foreach ($steps as &$step) {
                    if (isset($step['fields']) && is_array($step['fields'])) {
                        // Ensure template value is present and handled as a string
                        if (!isset($step['template']) || $step['template'] === null) {
                            $step['template'] = '1'; // Default to template 1
                        } else {
                            $step['template'] = (string)$step['template']; // Ensure it's a string
                        }
                        Log::info('Step template value set', ['step_id' => $step['id'] ?? 'unknown', 'template' => $step['template']]);

                        // Ensure all step properties are present and have default values if empty
                        $step['label'] = $step['label'] ?? '';
                        $step['mainHeading'] = $step['mainHeading'] ?? '';
                        $step['subheading'] = $step['subheading'] ?? '';
                        $step['sideHeading'] = $step['sideHeading'] ?? '';

                        Log::info('Step main properties validated', [
                            'step_id' => $step['id'] ?? 'unknown',
                            'label' => $step['label'],
                            'mainHeading' => $step['mainHeading'],
                            'subheading' => $step['subheading'],
                            'sideHeading' => $step['sideHeading']
                        ]);

                        foreach ($step['fields'] as &$field) {
                            if ($field['type'] === 'custom_radio' && isset($field['options'])) {
                                foreach ($field['options'] as &$option) {
                                    // Ensure all expected properties exist
                                    if (!isset($option['label'])) $option['label'] = '';
                                    if (!isset($option['text'])) $option['text'] = '';
                                    if (!isset($option['value'])) $option['value'] = '';
                                    if (!isset($option['length'])) $option['length'] = '';
                                    if (!isset($option['fitment_time'])) $option['fitment_time'] = '';
                                    if (!isset($option['mid_sized_price'])) $option['mid_sized_price'] = 0;
                                    if (!isset($option['toyota_79_price'])) $option['toyota_79_price'] = 0;
                                    if (!isset($option['usa_truck_price'])) $option['usa_truck_price'] = 0;
                                    if (!isset($option['isActive'])) $option['isActive'] = false;
                                    if (!isset($option['white_image_url'])) $option['white_image_url'] = '';
                                    if (!isset($option['black_image_url'])) $option['black_image_url'] = '';


                                    // // Ensure consistency between property names
                                    // if (isset($option['white_image_url']) && !isset($option['whiteImage'])) {
                                    //     $option['whiteImage'] = $option['white_image_url'];
                                    // } elseif (isset($option['whiteImage']) && !isset($option['white_image_url'])) {
                                    //     $option['white_image_url'] = $option['whiteImage'];
                                    // }

                                    // if (isset($option['black_image_url']) && !isset($option['blackImage'])) {
                                    //     $option['blackImage'] = $option['black_image_url'];
                                    // } elseif (isset($option['blackImage']) && !isset($option['black_image_url'])) {
                                    //     $option['black_image_url'] = $option['blackImage'];
                                    // }
                                }
                            }
                        }
                    }
                }
            }

            $form = DraftForm::findOrFail($id);

            $newStep = json_decode($validatedData['steps'], true);
            Log::info('New step received:', $newStep);

            // Get existing steps or start with an empty array
            $existingSteps = $form->steps ?? [];
            Log::info('Existing steps before append:', $existingSteps);

            // Append the new step
            $existingSteps[] = $newStep;
            Log::info('Final steps to be saved:', $existingSteps);

            // Update the form
            $form->update(['steps' => $existingSteps]);
            Log::info('Form steps successfully updated.');




            if (!empty($steps) && empty($logic)) {
                // Update the form
                $form->update([
                    'name' => $validatedData['name'],
                    'slug' => $validatedData['slug'],
                    // 'steps' => $steps,
                    'logic' => $validatedData['logic'] ? json_decode($validatedData['logic'], true) : null
                ]);
            } elseif (!isset($steps) && !empty($validatedData['logic']) /* && !empty($validatedData['code']) */) {
                // return $validatedData['  logic'];
                $form->update([
                    // 'name' => $validatedData['name'],
                    'logic' => $validatedData['logic'] ? json_decode($validatedData['logic'], true) : null
                ]);
            }


            // Log::info('Form updated successfully', ['form' => $form]);

            return response()->json([
                'message' => 'Form updated successfully',
                'form' => $form
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating form', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error updating form',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $form = DraftForm::findOrFail($id);

        // Prefix the slug with a UUID and double slashes
        $form->slug = Str::uuid() . '--' . $form->slug;
        $form->save(); // Save updated slug before soft delete

        $form->delete(); // Soft delete

        return response()->json([
            'message' => 'Form deleted successfully'
        ]);
    }

    public function duplicate($id)
    {
        $originalForm = DraftForm::findOrFail($id);

        // Start with base slug
        $slugBase = $originalForm->slug . '-Copy';
        $slug = $slugBase;

        // Check if slug exists already
        $counter = 0;
        while (DraftForm::where('slug', $slug)->exists()) {
            // Append a random 2–4 digit number
            $slug = $slugBase . '-' . rand(10, 9999);

            // safety check to prevent infinite loops
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
            ]);
        }

        return response()->json([
            'message' => 'Form duplicated successfully',
            'form' => $duplicatedForm
        ]);
    }




    // public function show($slug)
    // {
    //     $draftForm = DraftForm::where('slug', $slug)->first();

    //     if (!$draftForm) {
    //         return redirect()->back()->with('error', 'Form not found.');
    //     }

    //     // Find the corresponding published form
    //     $publishedForm = PublishedForm::where('draft_form_id', $draftForm->id)->first();

    //     if (!$publishedForm) {
    //         return redirect()->back()->with('error', 'This form is not published.');
    //     }

    //        // Create a new form submission (with empty data)
    //     $submitguid = (string) Str::uuid();

    //     FormSubmission::create([
    //         'guid' => $submitguid,
    //     ]);

    //     $makes = Make::all();
    //     $models = CarModel::all();
    //     $products = Product::all();

    //     return view('forms.view', [
    //         'form' => $publishedForm,
    //         'guid' => $submitguid,
    //         'makes' => $makes,
    //         'models' => $models,
    //         'products' => $products
    //     ]); // Changed 'forms.show' to 'forms.view'
    // }

    public function showForm($slug)
    {
        $draftForm = DraftForm::where('slug', $slug)->first();

        if (!$draftForm) {
                // return redirect('/');
            throw new NotFoundHttpException();
        }

        if ($draftForm->status !== 'published' && !Auth::check()) {
            throw new NotFoundHttpException();
        }

        $makes = Make::with('models')->orderBy('name', "asc")->get();
        $models = CarModel::orderBy('model_name', "asc")->get();
        $products = Product::orderBy('name', "asc")->get();
        $logics = Logics::with(["recipe"])->where('form_id', $draftForm->id)->get();
        $productRules = ProductRule::get();
                // Create a new form submission (with empty data)
        $submitguid = (string) Str::uuid();
        $messages = Message::pluck('text', 'id')->toArray();
        FormSubmission::create([
            'guid' => $submitguid,
        ]);

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


    public function homeform()
    {
        // $draftForm = DraftForm::where('slug', $slug)->first();
        $homeForm = DraftForm::where('set_as_home', true)->first();

        if (!$homeForm) {
            throw new NotFoundHttpException();
        }

        if ($homeForm->status !== 'published' && !Auth::check()) {
            throw new NotFoundHttpException();
        }

        $makes = Make::with('models')->get();
        $models = CarModel::all();
        $products = Product::all();
        $logics = Logics::with(["recipe"])->where('form_id', $homeForm->id)->get();

                // Create a new form submission (with empty data)
        $submitguid = (string) Str::uuid();
        $productRules = ProductRule::get();
        FormSubmission::create([
            'guid' => $submitguid,
        ]);

         $messages = Message::pluck('text', 'id')->toArray(); 
        return view('forms.formView', [
            'form' => $homeForm,
            'submitguid' => $submitguid,
            'makes' => $makes,
            'models' => $models,
            'products' => $products,
            'logics' => $logics,
            'productRules' => $productRules,
            'messages' => $messages
        ]); // Changed 'forms.show' to 'forms.view'
    }

    public function setAsHome(Request $request)
    {
        $formId = $request->id;

        // Reset all forms
        DraftForm::query()->update(['set_as_home' => false]);

        // Set selected form
        DraftForm::where('id', $formId)->update(['set_as_home' => true]);

        return response()->json([
            'message' => 'Form duplicated successfully',
        ]);
    }

    public function getModels(Request $request)
    {
        $models = CarModel::where('make_id', $request->make_id)->get();
        return response()->json(['models' => $models]);
    }


    public function sendSummaryEmail(Request $request)
    {

        // return $request->all();
        $formSlug = $request->form_slug;
        // $formid = $request->formId;
        // $options = $request->options;
        $submitguid = $request->submitguid;

        $submission = FormSubmission::where('guid', $submitguid)->first();

        if ($submission) {
        //     $submission->options = json_encode($options); // Save options as JSON
            $submission->is_submitted = true; // mark as submitted if needed
        //     $submission->form_slug = $formid;
            $submission->save();
        }

        $userEmail = $request->email ?? ($request->additional_data['email'] ?? null);

        $summary = $request->summary;
        $interests = $request->interests;
        $additionalData = $request->additional_data;

        $fallbackAdminEmail = 'test@test.com';

        $form = DraftForm::where('slug', $formSlug)->first();

        if (!$form) {
            return response()->json(['message' => 'Form not found.'], 404);
        }


        $adminEmails = [];

        if ($form->admin_emails) {
            $adminEmails = explode(',', $form->admin_emails);
            $adminEmails = array_filter(array_map('trim', $adminEmails)); // clean up
        }

        // Use fallback if no valid admin emails
        if (empty($adminEmails)) {
            $adminEmails = [$fallbackAdminEmail];
        }

        // Send to each admin
        foreach ($adminEmails as $email) {
            Mail::to($email)->send(new SummaryMail($summary, $interests, $additionalData));
        }

        if ($userEmail) {
            $userMailSent = false;
            try {
                Mail::to($userEmail)->send(new UserThankYouMail());
                $userMailSent = true;

                // Email Headers
                /*$headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: test@test.com" . "\r\n";  // Change sender email

                // Send email to User
                $user_subject = "Thank You for Your Inquiry";
                $user_message = "
                    <p>Hello,</p>
                    <p>Thank you for reaching out! We have received your inquiry and will get back to you as soon as possible.</p>
                    <p>Best Regards,<br />Team</p>
                ";

                $user_mail_sent = mail($userEmail, $user_subject, $user_message, $headers);*/
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

}
