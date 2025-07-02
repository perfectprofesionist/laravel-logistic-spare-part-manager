{{-- 
    Form Builder Edit Page
    
    This Blade template provides a comprehensive form builder interface for creating
    and editing dynamic forms. It includes multiple panels and states for different
    stages of form creation and editing.
    
    Features:
    - Step-by-step form creation wizard
    - Template selection for each step
    - Dynamic field addition and management
    - Form logic and automation setup
    - Admin email configuration
    - Success state handling
    - Responsive design with Bootstrap styling
    
    States:
    1. Step Creation Mode (edit-step=true) - Add/remove form steps
    2. Success State (submitted=true) - Confirmation after save
    3. Form Builder Mode (default) - Main form editing interface
--}}

@extends('layouts.app_new')

@section('content')


{{-- Step Creation Mode - When form has no steps or edit-step parameter is true --}}
@if(empty($form->steps) || request()->query('edit-step') === 'true')
    {{-- Panel 1: Step Creation Interface --}}
    <div class="panel-1">
        <div class="craete-form-outer-panel ">
            <div class="col-12 pade-none create-heading-con">
                <h2>{{ $form->name ?? '' }} <a href="{{ route('forms-new.editformdata', ['id' => $form->id]) }}"><img src="{{ asset('images') }}/edit-aarow.svg" alt="icon"></a></h2>
                <div class="create-form-CTA auto-width"><a href="{{ route('forms-new.index') }}"><img src="{{ asset('images') }}/back-bttn-icon.svg" alt="Plus"> Back</a></div>
            </div>

            <div class="col-12 pade-none cont-conditions-added">
                            {{-- Navigation Steps Configuration --}}
            <div class="navigation-steps">
                <div class="nav-heading">
                    <p>Add Navigation Steps</p>
                </div>
                    <div class="nav-form-grid">
                        <form>
                            {{-- Dynamic step list container --}}
                            <div class="step-list-container">
                                @foreach ($form->steps as $step)
                                {{-- Individual step input with delete option --}}
                                <div class="add-step-con"><input type="text" class="step-list-titles" value="{{ $step["title"] }}" placeholder="Step title"><div class="delete-step-from-list">X</div></div>
                                @endforeach
                            </div>
                            {{-- Add new step button --}}
                            <div class="back-btn-wrap add-btn">
                                <a href="javascript:void(0);" class="add-step-btn"><img src="{{ asset('images') }}/plus-icon.png" alt="icon"> Add Step</a>
                            </div>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>

        {{-- Hidden textarea for storing step data --}}
        <textarea  name="form_steps_list_input" id="form-steps-list-input" cols="30" rows="10"></textarea>

        

        {{-- Save and Continue Button --}}
        <div class="create-form-CTA save-continue-outer">
            <div class="list-display-message mb-2"></div>
            
            <a href="javascript:void(0);" class="steps-list-save-btn">Save & Continue <img src="{{ asset('images') }}/save-btn.svg" alt="icon"></a>
        
        </div>

        
    </div>



{{-- Success State - Displayed after successful form save --}}
@elseif(request()->query('submitted') === 'true')

    {{-- Success confirmation panel --}}
    <div class="craete-form-outer-panel successfully-submit-main">
        <div class="successfully-submit-outer">
            <h1>Success!</h1>
            <h3>"{{ $form->name ?? '' }}" is saved successfully.</h3>

            <p> <a href="{{ route('forms-new.index') }}"> Go to listing.</a> </p>
        </div>
    </div>





{{-- Main Form Builder Mode - Default state for form editing --}}
@else

{{-- Panel 2: Main Form Builder Interface --}}
<div class="craete-form-outer-panel panel-2">
    {{-- Header with form name, edit link, and back button --}}
    <div class="col-12 pade-none create-heading-con">
      <h2>{{ $form->name ?? '' }} <a href="{{ route('forms-new.editformdata', ['id' => $form->id]) }}"><img src="{{ asset('images') }}/edit-aarow.svg" alt="icon"></a>
        
        
        </h2>
      <div class="create-form-CTA auto-width"><a href="{{ route('forms-new.index') }}"><img src="{{ asset('images') }}/back-bttn-icon.svg" alt="Plus"> Back</a></div>
    </div>
    {{-- Main content area --}}
    <div class="col-12 pade-none cont-conditions-added">
     

      {{-- Navigation Steps Display and Management --}}
      <div class="navigation-steps">
        <div class="nav-heading">
            <h4>Navigation Steps</h4>

            {{-- Show instruction if no fields are added to first step --}}
            @if( empty( $form->steps[0]["fields"]) )
                <p>Select Navigation Steps to add Details</p>
            @endif
            
        </div>
        {{-- Tab Navigation for Steps --}}
        <div class="tabs-wrap">
            <ul class="tabs form-tabs">
                {{-- Generate tabs for each step --}}
                @foreach ($form->steps as $step)
                    <li class="tab-link @if( !empty( $form->steps[0]["fields"]) ) {{ $loop->first ? 'current' : '' }} @endif" data-tab="{{ $step["id"] }}">{{ $step["label"] }}</li>
                @endforeach
                {{-- Edit steps button --}}
                <a href="{{ request()->url() }}?edit-step=true"><img src="{{ asset('images') }}/edit-aarow.svg" alt="icon"></a>
            </ul>
            
            
            {{-- Step Content Areas - Each step gets its own tab content --}}
            @foreach ($form->steps as $index => $step)
                @php
                $next = $form->steps[$index + 1] ?? null; // Get next step for navigation
                @endphp
                <div id="{{ $step["id"] }}" class="tab-content @if( !empty( $form->steps[0]["fields"]) )  {{ $loop->first ? 'current' : '' }} @endif">

                        <div class="slide-sec-inner">
                            <div class="nav-heading">
                                <p>Select Template</p>
                            </div>
                            <div class="config-slider">

                               
                                <div class="step-slider template-select">
                                    <p>
                                        <input type="radio" id="chse-one-{{ $step["id"] }}" name="template-{{ $step["id"] }}" class="template-select" value="1" {{ ($step["template"] == 1 || empty($step["template"]))  ? 'checked' : '' }}>
                                        <label for="chse-one-{{ $step["id"] }}"><img src="{{ asset('assets/template_image/template1.png') }}" alt=""></label>
                                    </p>
                                    <p>
                                        <input type="radio" id="chse-two-{{ $step["id"] }}" name="template-{{ $step["id"] }}" value="2" class="template-select" {{ $step["template"] == 2 ? 'checked' : '' }}>
                                        <label for="chse-two-{{ $step["id"] }}"><img src="{{ asset('assets/template_image/template2.png') }}" alt=""></label>
                                    </p>
                                    <p>
                                        <input type="radio" id="chse-three-{{ $step["id"] }}" name="template-{{ $step["id"] }}" value="3" class="template-select" {{ $step["template"] == 3 ? 'checked' : '' }}>
                                        <label for="chse-three-{{ $step["id"] }}"><img src="{{ asset('assets/template_image/template3.png') }}" alt=""></label>
                                    </p>
                                    <p>
                                        <input type="radio" id="choose-four-{{ $step["id"] }}" name="template-{{ $step["id"] }}" value="4" class="template-select" {{ $step["template"] == 4 ? 'checked' : '' }}>
                                        <label for="choose-four-{{ $step["id"] }}"><img src="{{ asset('assets/template_image/template4.png') }}" alt=""></label>
                                    </p>
                                    <p>
                                        <input type="radio" id="choose-five-{{ $step["id"] }}" name="template-{{ $step["id"] }}" value="0"  class="template-select" {{ $step["template"] == 0 ? 'checked' : '' }}>
                                        <label for="choose-five-{{ $step["id"] }}"><img src="{{ asset('assets/template_image/template0.jpg') }}" alt=""></label>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 otr-form-field">
                            <div class="nav-form-grid nav-form-display-block">
                                <form>
                                    <input type="hidden" id="{{ $step["title"] }}"
                                    class="step-input step-input-new step-label-input step-title
                                    
                                    " name="{{ $step["title"] }}" value="{{ $step["title"] }}" placeholder="Page Title">

                                    <input type="text" id="{{ $step["mainHeading"] }}"
                                    class="step-input step-input-new step-mainHeading
                                    @if($step["template"] == 0 ) 
                                      d-none
                                    @endif
                                    " name="{{ $step["mainHeading"] }}" value="{{ $step["mainHeading"] }}" placeholder="Page Heading">

                                    <input type="text" id="{{ $step["subheading"] }}"
                                    class="step-input step-input-new step-subheading
                                     @if($step["template"] == 0 ) 
                                      d-none
                                     @endif
                                    " name="{{ $step["subheading"] }}" value="{{ $step["subheading"] }}"  placeholder="Page Sub Heading"> 

                                    <input type="text" id="{{ $step["sideHeading"] }}"
                                    class="step-input step-input-new step-sideHeading 
                                    @if($step["template"] == 0 || $step["template"] == 4 || $step["template"] == 3) 
                                        d-none
                                    @endif
                                    " name="{{ $step["sideHeading"] }}" value="{{ $step["sideHeading"] }}" placeholder="Form Heading">
                                </form>
                            </div>
                            
                            
                        </div>


                        

                        
                        <div class=" new-entry">
                            
                                
                        </div>


                        <div class="field-container">

                        </div>





                        <div class="extr-field">
                            <div class="nav-heading">
                                <p>Fields Added</p>
                            </div>

                            @foreach ($step["fields"] as $field)
                                
                                <div class="extra-add mb-2"  data-id="{{ $field["id"] }}">
                                    <span class="extra-add-span">{!! $field["label"] !!}</span>
                                    <span class="extra-add-span2">{{ $field["id"] }}</span>
                                    <div class="extra-icon">
                                        <a href="javascript:void(0);" data-id="{{ $field["id"] }}" class="edit-field-btn" data-target="#accordion-{{ $field["id"] }}"><img src="{{ asset('images') }}/edit-aarow.svg" alt="icon"></a>
                                        <a href="javascript:void(0);" data-id="{{ $field["id"] }}"  class="remove-field-btn"   data-target="#accordion-{{ $field["id"] }}"><img src="{{ asset('images') }}/dele.svg" alt="icon"></a>
                                    </div>
                                </div>
                            @endforeach
                            
                            
                        </div>
                        <div class="back-btn-wrap add-btn">
                            <a href="javascript:void(0);" class="addFieldNew" data-target="#{{ $step["id"] }}"><img src="{{ asset('images') }}/plus-icon.png" alt="icon"> Add Field</a>
                        </div>


                        <div class="create-form-CTA save-continue-outer mt-5"><a href="javascript:void(0);" class="tab-link save-form-step" data-stepid="{{ $step["id"] }}" data-nextstepid="{{ isset($next["id"])? $next["id"] : "" }}" >{{ isset($next["id"])? "Save & Continue" : "Save" }}  <img src="{{ asset('images') }}/save-btn.svg" alt="icon"></a></div>
                        <div class="form-message">

                        </div>



                    </div>

                   
                @endforeach
            {{-- Step ends here --}}
        </div>
        
    </div>

    
      
    </div>

    
</div>

@endif

  <!--Create Form Screen 03 -->


    {{-- <pre>


    @php
        foreach ($recipes as $index => $recipe) {
            print_r($recipe);
            die();
        }
    @endphp
    </pre> --}}
    <div class="container py-4 d-none">

        <!-- Page Title & Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Update Form</h2>
            <a href="{{ route('forms.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Forms
            </a>
        </div>

        <!-- Form Name Input -->
        <div class="mb-4 p-3">
            <label class="fw-bold mb-1">Form Name:</label>
            <input type="text" id="formName" class="form-control" placeholder="Enter form name"
                value="{{ $form->name ?? '' }}">
        </div>

        <div class="mb-4 p-3">
            <label class="fw-bold mb-1">Form Slug:</label>
            <input type="text" id="formSlug" class="form-control" value="{{ $form->slug ?? '' }}">
        </div>


        <!-- Steps Container (Sortable) -->
        <div class="add_Step list-group">
            <!-- Steps will be added dynamically here -->
        </div>

        <!-- Add Step & Save Form Buttons -->
        <div class="d-flex justify-content-between gap-2 mt-3">
            <button id="addStepBtn" class="btn btn-primary px-4 py-2">
                <i class="fa fa-plus"></i> Add Step
            </button>
            <button id="saveFormBtn" class="btn btn-success px-4 py-2">
                <i class="fa fa-save"></i> Save Form
            </button>
        </div>
        <div class="progress-outer" style="display:none;">
            <label for="" id="save-message"></label>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="edit-progress-bar"
                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>

        <div class="accordion mt-4" id="formLogicAccordion" style="">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingLogic">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseLogic" aria-expanded="true" aria-controls="collapseLogic">
                        Form Logic
                    </button>
                </h2>
                <div id="collapseLogic" class="accordion-collapse collapse" aria-labelledby="headingLogic"
                    data-bs-parent="#formLogicAccordion">
                    <div class="accordion-body">
                        <!-- Logic Form -->
                        @if (!empty($form))
                            <form id="logic-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $form->id }}">
                                {{-- <pre>
                                    <?php
                                    // print_r($form);
                                    // die();
                                    ?>
                                </pre> --}}

                                <div id="logic-container">

                                    {{-- <pre>
                                    @php
                                        print_r($logics);
                                        die();
                                    @endphp
                                    </pre> --}}

                                </div>

                                <button type="button" id="add-automation" class="btn btn-primary mt-2">Add
                                    Logic</button>
                                <button type="submit" class="btn btn-success mt-2 " id="logic-form-save">Save
                                    Logic</button>
                            </form>
                        @endif
                    </div>
                </div>


            </div>
        </div>



        <div class="accordion mt-4" id="additionalInfoAccordion">
            <!-- Additional Info Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAdditionalInfo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseAdditionalInfo" aria-expanded="false"
                        aria-controls="collapseAdditionalInfo">
                        Additional Info
                    </button>
                </h2>
                <div id="collapseAdditionalInfo" class="accordion-collapse collapse" aria-labelledby="headingAdditionalInfo"
                    data-bs-parent="#additionalInfoAccordion">
                    <div class="accordion-body">
                        @if (!empty($form))
                            <form id="additional-info-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $form->id }}">

                                <div class="mb-3">
                                    <label for="admin_emails" class="form-label">Admin Emails</label>
                                    <textarea class="form-control" id="admin_emails" name="admin_emails" rows="5"
                                        placeholder="Enter comma-separated emails">{{ old('admin_emails', $form->admin_emails ?? '') }}</textarea>
                                </div>



                                <div class="sumit-btn">
                                    <button type="submit" class="btn btn-success px-4 py-2 rounded"
                                        id="additional-info-save">
                                        Save Additional Info
                                    </button>
                                </div>

                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- Automation Type Selection Modal -->
        <div class="modal fade" id="automationTypeModal" tabindex="-1" aria-labelledby="automationTypeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="automationTypeModalLabel">Select Logic Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <?php
                            foreach ($recipes as $index => $recipe) {
                                if (!empty($recipe['title'])) {
                            ?>
                            <div class="col-md-6">
                                <div class="card h-100 automation-type-card"
                                    data-type="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-id="<?= htmlspecialchars($recipe['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <div class="card-body text-center">
                                        <div class="card-text">

                                            {!! $recipe['display_text'] !!}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>
@endsection

@section('customScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"
        integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const allProducts = @json($products);
        // // console.log(allProducts);


         const fieldTypes = {
                make: {
                    label: 'Make',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label" value="Make">
                    </div>
                `
                },
                model: {
                    label: 'Model',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label" value="Model">
                    </div>
                `
                },
                /*year: {
                    label: 'Year',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label" value="Year">
                    </div>
                `
                },*/

                series: {
                    label: 'Series',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label" value="Series">
                    </div>
                `
                },
                headboard_radio: {
                    label: 'Headboards',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3 custom-radio-field-container">
                        <label class="form-label">Radio Options</label>
                        <div class="custom-radio-options-container" data-field-id="">
                            <!-- Options will be added here -->
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2 add-custom-radio-option back-btn-wrap add-btn">
                            <img src="{{ asset("images") }}/plus-icon.png" alt="icon"> Add Option
                        </button>
                    </div>
                `
                },
                canopy_radio: {
                    label: 'Canopys',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3 custom-radio-field-container">
                        <label class="form-label">Radio Options</label>
                        <div class="custom-radio-options-container" data-field-id="">
                            <!-- Options will be added here -->
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2 add-custom-radio-option back-btn-wrap add-btn">
                            <img src="{{ asset("images") }}/plus-icon.png" alt="icon"> Add Option
                        </button>
                    </div>
                `
                },
                tray_sides_radio: {
                    label: 'Tray Sides',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3 custom-radio-field-container">
                        <label class="form-label">Radio Options</label>
                        <div class="custom-radio-options-container" data-field-id="">
                            <!-- Options will be added here -->
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2 add-custom-radio-option back-btn-wrap add-btn">
                            <img src="{{ asset("images") }}/plus-icon.png" alt="icon"> Add Option
                        </button>
                    </div>
                `
                },
                text: {
                    label: 'Text Input',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Placeholder</label>
                        <input type="text" class="form-control field-input" name="placeholder" placeholder="Enter placeholder">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Default Value</label>
                        <input type="text" class="form-control field-input" name="default_value" placeholder="Enter default value">
                    </div>
                `
                },
                textarea: {
                    label: 'Text Area',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Placeholder</label>
                        <input type="text" class="form-control field-input" name="placeholder" placeholder="Enter placeholder">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rows</label>
                        <input type="text" class="form-control field-input" name="rows" value="3">
                    </div>
                `
                },
                select: {
                    label: 'Select Field',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Options (one per line)</label>
                        <textarea class="form-control field-input" name="options" rows="3" placeholder="Option 1&#10;Option 2&#10;Option 3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Default Value</label>
                        <input type="text" class="form-control field-input" name="default_value" placeholder="Enter default value">
                    </div>
                `
                },
                checkbox: {
                    label: 'Checkbox',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3">
                        <div class="create-form-checkbox reminder-con">
                            <label class="custom-checkbox">
                                    <input type="checkbox" name="checked"  checked="checked" class="form-check-input field-input" >
                                <span class="checkmark"></span> <span class="remember-text">Default Checked</span>
                            </label>
                        </div>
                       
                    </div>
                `
                },
                summary: {
                    label: 'Summary',
                    template: ``
                },
                custom_radio: {
                    label: 'Custom Radio Buttons',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3 custom-radio-field-container">
                        <label class="form-label">Radio Options</label>
                        <div class="custom-radio-options-container" data-field-id="">
                            <!-- Options will be added here -->
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2 add-custom-radio-option back-btn-wrap add-btn">
                            <img src="{{ asset("images") }}/plus-icon.png" alt="icon"> Add Option
                        </button>
                    </div>
                `
                },
                radio: {
                    label: 'Radio Buttons',
                    template: `
                    <div class="mb-3 radio-option-grid">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <div class="mb-3 radio-option-grid">
                        <label class="form-label">Radio Options</label>
                        <div class="radio-options-container">
                            <div class="radio-option mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label">
                                    <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text">
                                    <div class="form-check">
                                       <div class="create-form-checkbox reminder-con">
                                        <label class="custom-checkbox">
                                                <input type="checkbox" checked="checked" class="form-check-input field-input" name="option_active[]">
                                            <span class="checkmark"></span> <span class="remember-text">Active</span>
                                        </label>
                                       </div>
                                    </div>

                                   


                                    <button type="button" class="btn btn-sm remove-option"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2 add-custom-radio-option back-btn-wrap add-btn add-radio-option">
                            <img src="{{ asset("images") }}/plus-icon.png" alt="icon"> Add Option
                        </button>
                    </div>
                `
                },
                date: {
                    label: 'Date Input',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                    </div>
                    <!--<div class="mb-3">
                        <label class="form-label">Min Date</label>
                        <input type="date" class="form-control field-input" name="min">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Max Date</label>
                        <input type="date" class="form-control field-input" name="max">
                    </div> -->
                `
                },
                colors: {
                    label: 'Color Selection',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Field Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter field label">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color Options</label>
                        <div class="color-options-container">
                            <div class="color-option mb-2" id="color_option_0">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" class="form-control field-input" name="color_names[]" placeholder="Color name" value="Black">
                                    <input type="text" class="form-control field-input" name="color_labels[]" placeholder="Display label" value="Black Textured Powdered Coat">
                                    <div id="colors_img_dropzone_0" class="dropzone color-img-dropzone">
                                        <div class="dz-message">
                                            Drop image here or click to upload.
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control field-input" name="color_images[]" accept="image/*">
                                    <input type="hidden" class="color-image-data" name="color_image_data[]">
                                    <button type="button" class="btn btn-sm remove-color"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                </div>
                            </div>
                            <div class="color-option mb-2" id="color_option_1">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" class="form-control field-input" name="color_names[]" placeholder="Color name" value="White">
                                    <input type="text" class="form-control field-input" name="color_labels[]" placeholder="Display label" value="White Textured Powdered Coat">
                                    <div id="colors_img_dropzone_1" class="dropzone color-img-dropzone">
                                        <div class="dz-message">
                                            Drop image here or click to upload.
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control field-input" name="color_images[]" accept="image/*">
                                    <input type="hidden" class="color-image-data" name="color_image_data[]">
                                    <button type="button" class="btn btn-sm remove-color"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Style</label>
                        <select class="form-select field-input" name="display_style">
                            <option value="grid">Grid</option>
                            <option value="list">List</option>
                            <option value="dropdown">Dropdown</option>
                        </select>
                    </div>
                    
                `
                },
                email: {
                    label: 'Email Field',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Field Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter field label">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Placeholder</label>
                        <input type="text" class="form-control field-input" name="email" placeholder="Enter placeholder..">
                    </div>
                `
                },
                products: {
                    label: 'Products',
                    template: `
                    <div class="mb-3">
                        <label class="form-label">Field Label</label>
                        <input type="text" class="form-control field-input" name="label" placeholder="Enter field label">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Product Type</label>
                        <div class="product-types-container">
                            <select class="form-select field-input" name="product_type">
                                <option value="internals">Internal</option>
                                <option value="external">External</option>
                            </select>
                        </div>
                    </div>
                `
                }
            };
         function updateStepJSON() {
                // console.log(818);
                steps = [];
                $(".tab-content").each(function(index) {
                     // console.log(821);
                    let stepId = $(this).attr("id");
                    let stepTitle = $(this).find(".step-title").val();
                    let templateValue = $(this).find('.template-select:checked').val();

                    // console.log("templateValue", templateValue);

                    // Ensure template value is stored as a string
                    if (templateValue !== null && templateValue !== undefined) {
                        templateValue = String(templateValue);
                    } else {
                        templateValue = '1'; // Default to template 1 if not specified
                    }

                    // Find the input fields directly using more specific selectors
                    const labelField = $(this).find(".step-title");
                    const mainHeadingField = $(this).find(".step-mainHeading");
                    const subheadingField = $(this).find(".step-subheading");
                    const sideHeadingField = $(this).find(".step-sideHeading");

                    // Get values with proper fallbacks
                    const labelValue = labelField.val() || '';
                    const mainHeadingValue = mainHeadingField.val() || '';
                    const subheadingValue = subheadingField.val() || '';
                    const sideHeadingValue = sideHeadingField.val() || '';

                    // // Debug logging
                    // // console.log(`Step ${index+1} (${stepId}) field values:`, {
                    //     label: labelValue,
                    //     mainHeading: mainHeadingValue,
                    //     subheading: subheadingValue,
                    //     sideHeading: sideHeadingValue
                    // });

                    let stepData = {
                        id: stepId,
                        title: stepTitle,
                        order: index,
                        label: labelValue,
                        mainHeading: mainHeadingValue,
                        subheading: subheadingValue,
                        sideHeading: sideHeadingValue,
                        template: templateValue,
                        fields: []
                    };

                    // Double-check that we've captured the main form fields - this ensures they're properly saved
                    if (!stepData.label && labelField.length) {
                        stepData.label = labelField.val() || '';
                    }

                    if (!stepData.mainHeading && mainHeadingField.length) {
                        stepData.mainHeading = mainHeadingField.val() || '';
                    }

                    if (!stepData.subheading && subheadingField.length) {
                        stepData.subheading = subheadingField.val() || '';
                    }

                    if (!stepData.sideHeading && sideHeadingField.length) {
                        stepData.sideHeading = sideHeadingField.val() || '';
                    }

                    // // Explicitly log the final values that will be saved
                    // // console.log(`Step ${index+1} FINAL values:`, {
                    //     label: stepData.label,
                    //     mainHeading: stepData.mainHeading,
                    //     subheading: stepData.subheading,
                    //     sideHeading: stepData.sideHeading,
                    //     template: stepData.template
                    // });

                    // Log the template value being captured for this step
                    // // console.log(`Step ${index+1} template value: ${templateValue}`);

                    // Get fields in this step
                    $(this).find(".field-container .edit-field").each(function() {
                        // console.log(896);
                        let fieldId = $(this).attr("id").replace("accordion-", "");
                        let fieldType = $(this).find('.field-type-select').val();
                        let fieldData = {
                            id: fieldId,
                            type: fieldType,
                            required: $(this).find('input[name="required"]').is(':checked'),
                            label: $(this).find('input[name="label"]').val() ||
                                '' // Explicitly capture the label value
                        };

                        // Get common field properties
                        $(this).find('.field-options .field-input').each(function() {
                            let name = $(this).attr('name');
                            let value = $(this).val();

                            // Special handling for color options
                            if (fieldType === 'colors' && (name === 'color_names[]' ||
                                    name === 'color_labels[]' ||
                                    name === 'color_values[]' || name === 'color_images[]'
                                )) {
                                if (!fieldData.colors) {
                                    fieldData.colors = [];
                                }

                                let colorIndex = $(this).closest('.color-option').index();

                                // Initialize color object if it doesn't exist
                                if (!fieldData.colors[colorIndex]) {
                                    fieldData.colors[colorIndex] = {
                                        name: '',
                                        label: '',
                                        value: '',
                                        imageData: ''
                                    };
                                }

                                // Update the appropriate property
                                if (name === 'color_names[]') {
                                    fieldData.colors[colorIndex].name = value;
                                } else if (name === 'color_labels[]') {
                                    fieldData.colors[colorIndex].label = value;
                                } else if (name === 'color_values[]') {
                                    fieldData.colors[colorIndex].value = value;
                                }

                                // Get the image data from the hidden input
                                const imageData = $(this).closest('.color-option').find(
                                    '.color-image-data').val();
                                fieldData.colors[colorIndex].imageData = imageData || '';
                            }
                            // Handle custom radio options
                            else if ((fieldType === 'custom_radio' || fieldType ===
                                    'headboard_radio' || fieldType === 'canopy_radio' ||
                                    fieldType === 'tray_sides_radio') && (
                                    name === 'option_labels[]' ||
                                    name === 'option_texts[]' ||
                                    name === 'option_values[]' ||
                                    name === 'option_prices[]' ||
                                    name === 'option_lengths[]' ||
                                    name === 'option_times[]' ||
                                    name === 'option_mid_sized[]' ||
                                    name === 'option_toyota_79[]' ||
                                    name === 'option_usa_truck[]' ||
                                    name === 'option_active[]'
                                )) {
                                if (!fieldData.options) {
                                    fieldData.options = [];
                                }

                                // Get this option's position within its own container, not globally
                                let thisFieldId = $(this).closest('.edit-field').attr("id")
                                    .replace("accordion-", "");
                                let optionIndex = $(this).closest('.custom-radio-option')
                                    .index();

                                // Use data attribute to double-check that this option belongs to the current field
                                let optionFieldId = $(this).closest('.custom-radio-option')
                                    .data('field-id');
                                if (optionFieldId && optionFieldId !== thisFieldId) {
                                    // Skip if this option doesn't belong to this field
                                    return;
                                }

                                // Initialize option object if it doesn't exist
                                if (!fieldData.options[optionIndex]) {
                                    fieldData.options[optionIndex] = {
                                        label: '',
                                        text: '',
                                        value: '',
                                        price: '',
                                        length: '',
                                        fitment_time: '',
                                        isActive: false,
                                        whiteImage: '',
                                        blackImage: '',
                                        whiteImage_withHeadboard: '',
                                        blackImage_withHeadboard: '',
                                        white_image_url: '',
                                        black_image_url: '',
                                        white_image_url_withHeadboard: '',
                                        black_image_url_withHeadboard: ''
                                    };
                                }

                                // Update the appropriate property
                                if (name === 'option_labels[]') {
                                    fieldData.options[optionIndex].label = value;
                                } else if (name === 'option_texts[]') {
                                    fieldData.options[optionIndex].text = value;
                                } else if (name === 'option_values[]') {
                                    fieldData.options[optionIndex].value = value;
                                } else if (name === 'option_prices[]') {
                                    fieldData.options[optionIndex].price = value;
                                } else if (name === 'option_lengths[]') {
                                    fieldData.options[optionIndex].length = value;
                                } else if (name === 'option_times[]') {
                                    fieldData.options[optionIndex].fitment_time = value;
                                } else if (name === 'option_mid_sized[]') {
                                    fieldData.options[optionIndex].mid_sized_price = value;
                                } else if (name === 'option_toyota_79[]') {
                                    fieldData.options[optionIndex].toyota_79_price = value;
                                } else if (name === 'option_usa_truck[]') {
                                    fieldData.options[optionIndex].usa_truck_price = value;
                                } else if (name === 'option_active[]') {
                                    fieldData.options[optionIndex].isActive = $(this).is(
                                        ':checked');
                                }

                                // Get image data from hidden inputs
                                const whiteImageData = $(this).closest(
                                        '.custom-radio-option').find('.white-image-data')
                                    .val();
                                const blackImageData = $(this).closest(
                                        '.custom-radio-option').find('.black-image-data')
                                    .val();

                                const whiteImageData_withHeadboard = $(this).closest(
                                        '.custom-radio-option').find('.white-image-data-with-headboard')
                                    .val();
                                const blackImageData_withHeadboard = $(this).closest(
                                        '.custom-radio-option').find('.black-image-data-with-headboard')
                                    .val();

                                if (whiteImageData) {
                                    fieldData.options[optionIndex].whiteImage =
                                        whiteImageData;
                                }

                                if (blackImageData) {
                                    fieldData.options[optionIndex].blackImage =
                                        blackImageData;
                                }

                                if (whiteImageData_withHeadboard) {
                                    fieldData.options[optionIndex].whiteImage_withHeadboard =
                                        whiteImageData_withHeadboard;
                                }

                                if (blackImageData_withHeadboard) {
                                    fieldData.options[optionIndex].blackImage_withHeadboard =
                                        blackImageData_withHeadboard;
                                }

                                // Get existing image URLs if they exist in the DOM
                                const $whitePreview = $(this).closest(
                                    '.custom-radio-option').find(
                                    '.white-image-preview img');
                                const $blackPreview = $(this).closest(
                                    '.custom-radio-option').find(
                                    '.black-image-preview img');

                                const $whitePreview_withHeadboard = $(this).closest(
                                    '.custom-radio-option').find(
                                    '.white-image-preview-with-headboard img');
                                const $blackPreview_withHeadboard = $(this).closest(
                                    '.custom-radio-option').find(
                                    '.black-image-preview-with-headboard img');

                                if ($whitePreview.length && $whitePreview.attr('src') && !
                                    $whitePreview.attr('src').startsWith('data:')) {
                                    fieldData.options[optionIndex].white_image_url =
                                        $whitePreview.attr('src');

                                }

                                if ($blackPreview.length && $blackPreview.attr('src') && !
                                    $blackPreview.attr('src').startsWith('data:')) {
                                    fieldData.options[optionIndex].black_image_url =
                                        $blackPreview.attr('src');

                                }

                                if ($whitePreview_withHeadboard.length && $whitePreview_withHeadboard.attr('src') && !
                                    $whitePreview_withHeadboard.attr('src').startsWith('data:')) {
                                    fieldData.options[optionIndex].white_image_url_withHeadboard =
                                        $whitePreview_withHeadboard.attr('src');

                                }

                                if ($blackPreview_withHeadboard.length && $blackPreview_withHeadboard.attr('src') && !
                                    $blackPreview_withHeadboard.attr('src').startsWith('data:')) {
                                    fieldData.options[optionIndex].black_image_url_withHeadboard =
                                        $blackPreview_withHeadboard.attr('src');

                                }
                            }
                            // Handle slide options
                            else if (fieldType === 'slide_options' && (
                                    name === 'slide_labels[]' ||
                                    name === 'slide_quantities[]'
                                )) {
                                if (!fieldData.slideOptions) {
                                    fieldData.slideOptions = [];
                                }

                                let optionIndex = $(this).closest('.slide-option').index();

                                // Initialize option object if it doesn't exist
                                if (!fieldData.slideOptions[optionIndex]) {
                                    fieldData.slideOptions[optionIndex] = {
                                        label: '',
                                        quantity: 1,
                                        imageData: '',
                                        image_url: ''
                                    };
                                }

                                // Update the appropriate property
                                if (name === 'slide_labels[]') {
                                    fieldData.slideOptions[optionIndex].label = value;
                                } else if (name === 'slide_quantities[]') {
                                    fieldData.slideOptions[optionIndex].quantity = parseInt(
                                        value) || 1;
                                }

                                // Get image data from hidden input
                                const imageData = $(this).closest('.slide-option').find(
                                    '.slide-image-data').val();
                                if (imageData) {
                                    fieldData.slideOptions[optionIndex].imageData =
                                        imageData;
                                }

                                // Get existing image URL if it exists in the DOM
                                const $preview = $(this).closest('.slide-option').find(
                                    '.slide-image-preview img');
                                if ($preview.length && $preview.attr('src') && !$preview
                                    .attr('src').startsWith('data:')) {
                                    fieldData.slideOptions[optionIndex].image_url = $preview
                                        .attr('src');
                                }
                            }
                            // Handle products
                            else if (fieldType === 'products' && name ===
                                'product_type') {
                                if (!fieldData.productType) {
                                    fieldData.productType = ''; // Ensure it's an array
                                }

                                let optionIndex = $(this).closest(
                                    '.product-types-container').index();

                                fieldData.productType = value;
                            }
                            // Handle radio options
                            else if (fieldType === 'radio' && (name === 'option_labels[]' ||
                                    name === 'option_texts[]' || name === 'option_active[]'
                                )) {
                                if (!fieldData.options) {
                                    fieldData.options = [];
                                }

                                let optionIndex = $(this).closest('.radio-option').index();

                                // Initialize option object if it doesn't exist
                                if (!fieldData.options[optionIndex]) {
                                    fieldData.options[optionIndex] = {
                                        label: '',
                                        text: '',
                                        isActive: false
                                    };
                                }

                                // Update the appropriate property
                                if (name === 'option_labels[]') {
                                    fieldData.options[optionIndex].label = value;
                                } else if (name === 'option_texts[]') {
                                    fieldData.options[optionIndex].text = value;
                                } else if (name === 'option_active[]') {
                                    fieldData.options[optionIndex].isActive = $(this).is(
                                        ':checked');
                                }
                            }
                            // Handle regular fields
                            else if (name && !name.includes('[]')) {
                                if (name === 'checked' || name === 'multiple' || name ===
                                    'required') {
                                    fieldData[name] = $(this).is(':checked');
                                } else if (value !== '') {
                                    fieldData[name] = value;
                                }
                            }
                        });

                        // Ensure all standard field properties are captured
                        if (!fieldData.label) {
                            // Try to find the label in the field content if not found in field options
                            const labelField = $(this).find('input[name="label"]');
                            if (labelField.length) {
                                fieldData.label = labelField.val() || '';
                            }
                        }

                        // For text fields, ensure common properties are captured
                        if (fieldType === 'text') {
                            const placeholderField = $(this).find('input[name="placeholder"]');
                            if (placeholderField.length) {
                                fieldData.placeholder = placeholderField.val() || '';
                            }

                            const defaultValueField = $(this).find('input[name="default_value"]');
                            if (defaultValueField.length) {
                                fieldData.default_value = defaultValueField.val() || '';
                            }
                        }

                        stepData.fields.push(fieldData);
                    });

                    if($('.new-entry .addfield-inner').length > 0) {
                        $(this).find(".new-entry .addfield-inner").each(function() {
                            // console.log(1229);
                            let fieldId = $(this).attr("id").replace("accordion-", "");
                            let fieldType = $(this).find('.field-type-select').val();
                            let fieldData = {
                                id: fieldId,
                                type: fieldType,
                                required: $(this).find('input[name="required"]').is(':checked'),
                                label: $(this).find('input[name="label"]').val() ||
                                    '' // Explicitly capture the label value
                            };

                            // Get common field properties
                            $(this).find('.field-options .field-input').each(function() {
                                let name = $(this).attr('name');
                                let value = $(this).val();

                                // Special handling for color options
                                if (fieldType === 'colors' && (name === 'color_names[]' ||
                                        name === 'color_labels[]' ||
                                        name === 'color_values[]' || name === 'color_images[]'
                                    )) {
                                    if (!fieldData.colors) {
                                        fieldData.colors = [];
                                    }

                                    let colorIndex = $(this).closest('.color-option').index();

                                    // Initialize color object if it doesn't exist
                                    if (!fieldData.colors[colorIndex]) {
                                        fieldData.colors[colorIndex] = {
                                            name: '',
                                            label: '',
                                            value: '',
                                            imageData: ''
                                        };
                                    }

                                    // Update the appropriate property
                                    if (name === 'color_names[]') {
                                        fieldData.colors[colorIndex].name = value;
                                    } else if (name === 'color_labels[]') {
                                        fieldData.colors[colorIndex].label = value;
                                    } else if (name === 'color_values[]') {
                                        fieldData.colors[colorIndex].value = value;
                                    }

                                    // Get the image data from the hidden input
                                    const imageData = $(this).closest('.color-option').find(
                                        '.color-image-data').val();
                                    fieldData.colors[colorIndex].imageData = imageData || '';
                                }
                                // Handle custom radio options
                                else if ((fieldType === 'custom_radio' || fieldType ===
                                        'headboard_radio' || fieldType === 'canopy_radio' ||
                                        fieldType === 'tray_sides_radio') && (
                                        name === 'option_labels[]' ||
                                        name === 'option_texts[]' ||
                                        name === 'option_values[]' ||
                                        name === 'option_prices[]' ||
                                        name === 'option_lengths[]' ||
                                        name === 'option_times[]' ||
                                        name === 'option_mid_sized[]' ||
                                        name === 'option_toyota_79[]' ||
                                        name === 'option_usa_truck[]' ||
                                        name === 'option_active[]'
                                    )) {
                                    if (!fieldData.options) {
                                        fieldData.options = [];
                                    }

                                    // Get this option's position within its own container, not globally
                                    let thisFieldId = $(this).closest('.addfield-inner').attr("id")
                                        .replace("accordion-", "");
                                    let optionIndex = $(this).closest('.custom-radio-option')
                                        .index();

                                    // Use data attribute to double-check that this option belongs to the current field
                                    let optionFieldId = $(this).closest('.custom-radio-option')
                                        .data('field-id');
                                    if (optionFieldId && optionFieldId !== thisFieldId) {
                                        // Skip if this option doesn't belong to this field
                                        return;
                                    }

                                    // Initialize option object if it doesn't exist
                                    if (!fieldData.options[optionIndex]) {
                                        fieldData.options[optionIndex] = {
                                            label: '',
                                            text: '',
                                            value: '',
                                            price: '',
                                            length: '',
                                            fitment_time: '',
                                            isActive: false,
                                            whiteImage: '',
                                            blackImage: '',
                                            whiteImage_withHeadboard: '',
                                            blackImage_withHeadboard: '',
                                            white_image_url: '',
                                            black_image_url: '',
                                            white_image_url_withHeadboard: '',
                                            black_image_url_withHeadboard: ''
                                        };
                                    }

                                    // Update the appropriate property
                                    if (name === 'option_labels[]') {
                                        fieldData.options[optionIndex].label = value;
                                    } else if (name === 'option_texts[]') {
                                        fieldData.options[optionIndex].text = value;
                                    } else if (name === 'option_values[]') {
                                        fieldData.options[optionIndex].value = value;
                                    } else if (name === 'option_prices[]') {
                                        fieldData.options[optionIndex].price = value;
                                    } else if (name === 'option_lengths[]') {
                                        fieldData.options[optionIndex].length = value;
                                    } else if (name === 'option_times[]') {
                                        fieldData.options[optionIndex].fitment_time = value;
                                    } else if (name === 'option_mid_sized[]') {
                                        fieldData.options[optionIndex].mid_sized_price = value;
                                    } else if (name === 'option_toyota_79[]') {
                                        fieldData.options[optionIndex].toyota_79_price = value;
                                    } else if (name === 'option_usa_truck[]') {
                                        fieldData.options[optionIndex].usa_truck_price = value;
                                    } else if (name === 'option_active[]') {
                                        fieldData.options[optionIndex].isActive = $(this).is(
                                            ':checked');
                                    }

                                    // Get image data from hidden inputs
                                    const whiteImageData = $(this).closest(
                                            '.custom-radio-option').find('.white-image-data')
                                        .val();
                                    const blackImageData = $(this).closest(
                                            '.custom-radio-option').find('.black-image-data')
                                        .val();

                                    const whiteImageData_withHeadboard = $(this).closest(
                                            '.custom-radio-option').find('.white-image-data-with-headboard')
                                        .val();
                                    const blackImageData_withHeadboard = $(this).closest(
                                            '.custom-radio-option').find('.black-image-data-with-headboard')
                                        .val();

                                    if (whiteImageData) {
                                        fieldData.options[optionIndex].whiteImage =
                                            whiteImageData;
                                    }

                                    if (blackImageData) {
                                        fieldData.options[optionIndex].blackImage =
                                            blackImageData;
                                    }

                                    if (whiteImageData_withHeadboard) {
                                        fieldData.options[optionIndex].whiteImage_withHeadboard =
                                            whiteImageData_withHeadboard;
                                    }

                                    if (blackImageData_withHeadboard) {
                                        fieldData.options[optionIndex].blackImage_withHeadboard =
                                            blackImageData_withHeadboard;
                                    }

                                    // Get existing image URLs if they exist in the DOM
                                    const $whitePreview = $(this).closest(
                                        '.custom-radio-option').find(
                                        '.white-image-preview img');
                                    const $blackPreview = $(this).closest(
                                        '.custom-radio-option').find(
                                        '.black-image-preview img');

                                    const $whitePreview_withHeadboard = $(this).closest(
                                        '.custom-radio-option').find(
                                        '.white-image-preview-with-headboard img');
                                    const $blackPreview_withHeadboard = $(this).closest(
                                        '.custom-radio-option').find(
                                        '.black-image-preview-with-headboard img');

                                    if ($whitePreview.length && $whitePreview.attr('src') && !
                                        $whitePreview.attr('src').startsWith('data:')) {
                                        fieldData.options[optionIndex].white_image_url =
                                            $whitePreview.attr('src');

                                    }

                                    if ($blackPreview.length && $blackPreview.attr('src') && !
                                        $blackPreview.attr('src').startsWith('data:')) {
                                        fieldData.options[optionIndex].black_image_url =
                                            $blackPreview.attr('src');

                                    }

                                    if ($whitePreview_withHeadboard.length && $whitePreview_withHeadboard.attr('src') && !
                                        $whitePreview_withHeadboard.attr('src').startsWith('data:')) {
                                        fieldData.options[optionIndex].white_image_url_withHeadboard =
                                            $whitePreview_withHeadboard.attr('src');

                                    }

                                    if ($blackPreview_withHeadboard.length && $blackPreview_withHeadboard.attr('src') && !
                                        $blackPreview_withHeadboard.attr('src').startsWith('data:')) {
                                        fieldData.options[optionIndex].black_image_url_withHeadboard =
                                            $blackPreview_withHeadboard.attr('src');

                                    }
                                }
                                // Handle slide options
                                else if (fieldType === 'slide_options' && (
                                        name === 'slide_labels[]' ||
                                        name === 'slide_quantities[]'
                                    )) {
                                    if (!fieldData.slideOptions) {
                                        fieldData.slideOptions = [];
                                    }

                                    let optionIndex = $(this).closest('.slide-option').index();

                                    // Initialize option object if it doesn't exist
                                    if (!fieldData.slideOptions[optionIndex]) {
                                        fieldData.slideOptions[optionIndex] = {
                                            label: '',
                                            quantity: 1,
                                            imageData: '',
                                            image_url: ''
                                        };
                                    }

                                    // Update the appropriate property
                                    if (name === 'slide_labels[]') {
                                        fieldData.slideOptions[optionIndex].label = value;
                                    } else if (name === 'slide_quantities[]') {
                                        fieldData.slideOptions[optionIndex].quantity = parseInt(
                                            value) || 1;
                                    }

                                    // Get image data from hidden input
                                    const imageData = $(this).closest('.slide-option').find(
                                        '.slide-image-data').val();
                                    if (imageData) {
                                        fieldData.slideOptions[optionIndex].imageData =
                                            imageData;
                                    }

                                    // Get existing image URL if it exists in the DOM
                                    const $preview = $(this).closest('.slide-option').find(
                                        '.slide-image-preview img');
                                    if ($preview.length && $preview.attr('src') && !$preview
                                        .attr('src').startsWith('data:')) {
                                        fieldData.slideOptions[optionIndex].image_url = $preview
                                            .attr('src');
                                    }
                                }
                                // Handle products
                                else if (fieldType === 'products' && name ===
                                    'product_type') {
                                    if (!fieldData.productType) {
                                        fieldData.productType = ''; // Ensure it's an array
                                    }

                                    let optionIndex = $(this).closest(
                                        '.product-types-container').index();

                                    fieldData.productType = value;
                                }
                                // Handle radio options
                                else if (fieldType === 'radio' && (name === 'option_labels[]' ||
                                        name === 'option_texts[]' || name === 'option_active[]'
                                    )) {
                                    if (!fieldData.options) {
                                        fieldData.options = [];
                                    }

                                    let optionIndex = $(this).closest('.radio-option').index();

                                    // Initialize option object if it doesn't exist
                                    if (!fieldData.options[optionIndex]) {
                                        fieldData.options[optionIndex] = {
                                            label: '',
                                            text: '',
                                            isActive: false
                                        };
                                    }

                                    // Update the appropriate property
                                    if (name === 'option_labels[]') {
                                        fieldData.options[optionIndex].label = value;
                                    } else if (name === 'option_texts[]') {
                                        fieldData.options[optionIndex].text = value;
                                    } else if (name === 'option_active[]') {
                                        fieldData.options[optionIndex].isActive = $(this).is(
                                            ':checked');
                                    }
                                }
                                // Handle regular fields
                                else if (name && !name.includes('[]')) {
                                    if (name === 'checked' || name === 'multiple' || name ===
                                        'required') {
                                        fieldData[name] = $(this).is(':checked');
                                    } else if (value !== '') {
                                        fieldData[name] = value;
                                    }
                                }
                            });

                            // Ensure all standard field properties are captured
                            if (!fieldData.label) {
                                // Try to find the label in the field content if not found in field options
                                const labelField = $(this).find('input[name="label"]');
                                if (labelField.length) {
                                    fieldData.label = labelField.val() || '';
                                }
                            }

                            // For text fields, ensure common properties are captured
                            if (fieldType === 'text') {
                                const placeholderField = $(this).find('input[name="placeholder"]');
                                if (placeholderField.length) {
                                    fieldData.placeholder = placeholderField.val() || '';
                                }

                                const defaultValueField = $(this).find('input[name="default_value"]');
                                if (defaultValueField.length) {
                                    fieldData.default_value = defaultValueField.val() || '';
                                }
                            }

                            stepData.fields.push(fieldData);
                        });
                    }
                    steps.push(stepData);
                });

                console.log("Updated Steps:", steps);
            }


        function collectAllSteps() {
            var stepTitlesArray = [];
            $('.step-list-titles').each(function(){
                if($(this).val().trim() === "") {

                } else {
                    stepTitlesArray.push($(this).val());
                }
                
            });
            
            $('#form-steps-list-input').val(stepTitlesArray.join(','));
        }

        $(document).ready(function() {

            window.addEventListener('popstate', function () {
                window.location.href = "{{ route('forms-new.index') }}";
            });

            history.pushState(null, null, location.href);



            collectAllSteps();
            $('.add-step-btn').click(function() {
                $('.step-list-container').append(
                    '<div class="add-step-con">' +
                    '<input type="text" class="step-list-titles" value="" placeholder="Step title">' +
                    '<div class="delete-step-from-list">X</div>' +
                    '</div>'
                );

                // Focus on the last added input
                $('.step-list-container .step-list-titles').last().focus();

                collectAllSteps();
                return false;
            });

            $('body').on('click', '.delete-step-from-list', function(){
                $(this).parent().remove();
                collectAllSteps();
                return false;
            });


            $('body').on('keyup','.step-list-titles', function(){
                collectAllSteps();
            });

            $('.steps-list-save-btn').click(function(){
                collectAllSteps();
                var form_steps_list_input = $('#form-steps-list-input').val();
                 const stepsInput = $('#form-steps-list-input').val().trim();
                const stepTitles = stepsInput.split(',').filter(step => step.trim() !== '');
 
                // Clear old messages
                $('.list-display-message').removeClass('text-danger text-success').text('');
 
                // === Frontend validation ===
                if (stepTitles.length === 0) {
                    $('.list-display-message').addClass('text-danger').text("Please click 'Add Step' and enter at least one step title to continue.");
                    return false;
                }
 
                // Check for any empty step inputs
                let emptyStepFound = false;
                $('.step-list-titles').each(function() {
                    if ($(this).val().trim() === '') {
                        emptyStepFound = true;
                        return false;  // Break the loop if an empty step is found
                    }
                });
 
                if (emptyStepFound) {
                    $('.list-display-message').addClass('text-danger').text("Please fill in all empty steps before proceeding.");
                    return false;
                }
 
                // Continue with your previous validations for step titles
                for (const title of stepTitles) {
                    const trimmedTitle = title.trim();
 
                    if (!/^[A-Za-z0-9\- ]+$/.test(trimmedTitle)) {
                        $('.list-display-message').addClass('text-danger').text('Each step title must contain only letters, numbers, spaces, and dashes.');
                        return false;
                    }
 
                    if (trimmedTitle.length > 30) {
                        $('.list-display-message').addClass('text-danger').text('Each step title must be 30 characters or less.');
                        return false;
                    }
                }
                $.ajax({
                    url: '{{ route("forms-new.storeOnlyFormSteps") }}', // or a hardcoded URL like '/store-data'
                    method: 'POST',
                    data: {
                        id:  {{ $form->id }},
                        form_steps_list_input: form_steps_list_input
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {

                        $('.list-display-message').addClass('text-success').text(response.message);
                        // console.log('Success:', response);
                        const url = new URL(window.location.href);
                        if (url.searchParams.has('edit-step')) {
                            url.searchParams.delete('edit-step');
                            window.history.replaceState({}, '', url.pathname + url.search);
                        }
                        setTimeout(function(){
                            window.location.reload();
                        }); 
                    },
                    error: function(xhr) {
                        $('.list-display-message').addClass('text-danger').text(xhr.responseText);
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            $('#additional-info-form').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('forms.saveAdminEmails') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while saving.',
                        });
                    }
                });
            });
        });




        $(document).ready(function() {
            let stepCount = 0;
            let fieldCount = 0;
            let steps = @json($form->steps ?? []);
            

            // Add change handlers for the main step form fields
            $(document).on('input change',
                'input[placeholder="Enter form name"], input[placeholder="Enter main heading"], input[placeholder="Enter subheading"], input[placeholder="Enter side heading"]',
                function() {
                    updateStepJSON();
                });

            // Add handler for the step-input class
            $(document).on('input change', '.step-input', function() {
                // // console.log("Step input changed:", $(this).attr('placeholder'), $(this).val());
                updateStepJSON();
            });

            // Track maximum field ID to prevent duplicates
            if (steps && steps.length > 0) {
                steps.forEach(function(step) {
                    if (step.fields && step.fields.length > 0) {
                        step.fields.forEach(function(field) {
                            if (field.id) {
                                // Extract the number from the field ID (e.g., "field-7" -> 7)
                                const matches = field.id.match(/field-(\d+)/);
                                if (matches && matches[1]) {
                                    const fieldNumber = parseInt(matches[1]);
                                    fieldCount = Math.max(fieldCount, fieldNumber);
                                }
                            }
                        });
                    }
                });
            }

            // Field types configuration
           

           
            // Initialize sortable
            $(".add_Step").sortable({
                handle: ".move-icon",
                update: function(event, ui) {
                    updateStepJSON();
                }
            });

            $("#addStepBtn").click(function() {
                stepCount++;
                let stepId = `step-${stepCount}`;
                let contentId = `content-${stepCount}`;
                let templateValue = '1'; // Default template for new steps

                let stepTemplate = `
                    <div class="card shadow-sm border-0 mb-3" id="${stepId}">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold step-title">New Step</span>
                            <div>
                                <button class="btn btn-white btn-sm me-2 remove-step" data-step="${stepId}" style="background-color: trasnparent; color: white;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                <i class="fa fa-arrows-alt move-icon me-3" style="cursor: grab;"></i>
                                <i class="fa fa-chevron-down toggle-icon" data-bs-toggle="collapse" data-bs-target="#${contentId}" style="cursor:pointer;"></i>
                            </div>
                        </div>
                        <div class="card-body collapse show" id="${contentId}">
                            <div class="row">
                                <!-- Left Column (Form Fields) -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="fw-bold">Label:</label>
                                        <input type="text" class="form-control step-input step-label-input" placeholder="Enter form name" value="" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Main Heading:</label>
                                        <input type="text" class="form-control step-input" placeholder="Enter main heading" value="" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Subheading:</label>
                                        <input type="text" class="form-control step-input" placeholder="Enter subheading" value="" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Side Heading:</label>
                                        <input type="text" class="form-control step-input" placeholder="Enter side heading" value="" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Template:</label>
                                        <select class="form-select template-select">
                                            <option value="1" data-image="{{ asset('assets/template_image/template1.png') }}">Template 1 (Static Image)</option>
                                            <option value="2" data-image="{{ asset('assets/template_image/template1.png') }}">Template 2 (Dynamic Image)</option>
                                            <option value="3" data-image="{{ asset('assets/template_image/template2.png') }}">Template 3</option>
                                            <option value="4" data-image="{{ asset('assets/template_image/template3.png') }}">Template 4</option>
                                            <option value="0" data-image="{{ asset('assets/template_image/noBg.jpg') }}">No Template</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Right Column (Template Image) -->
                                <div class="col-md-6 text-left">
                                    <div class="fw-bold">Template Preview:</div>
                                    <img class="template-preview img-fluid rounded shadow-sm"
                                        src="{{ asset('assets/template_image/template1.png') }}"
                                        alt="Template Preview" style="width: 100%; height: auto;">
                                </div>
                            </div>

                            <!-- Field container for this step -->
                            <div class="field-container mt-3">
                                <!-- Fields will be added here -->
                            </div>

                            <div class="d-flex align-items-center mt-3">
                                <button class="btn btn-primary btn-sm addField">
                                    <i class="fa fa-plus"></i> Add Field
                                </button> 
                            </div>
                        </div>
                    </div>
                `;

                $(".add_Step").append(stepTemplate);

                


                // Initialize Bootstrap collapse for the new step
                new bootstrap.Collapse(document.getElementById(contentId), {
                    toggle: false
                });

                // Add event listener for toggle icon rotation
                $(`#${stepId} .toggle-icon`).on('click', function() {
                    $(this).toggleClass('fa-chevron-down fa-chevron-up');
                });

                // Initialize template selection event handler
                $(`#${stepId} .template-select`).on('change', function() {
                    const selectedTemplate = $(this).val();
                    const templateImage = $(this).find("option:selected").data("image");
                    $(this).closest('.card').find(".template-preview").attr("src", templateImage);
                    // // console.log(`Template changed to: ${selectedTemplate}`);
                    updateStepJSON();
                });

                updateStepJSON();

                // Reinitialize sortable after adding a new step
                $(".add_Step").sortable("refresh");
            });

            // Add field to a specific step
            $(document).on("click", ".addFieldNew", function() {
                fieldCount++;
                let fieldId = `field-${fieldCount}`;
                let target = $(this).attr('data-target');
                let stepCard = $(target);

                let fieldTemplate = `

                

                <div class="addfield-inner" id="accordion-${fieldId}" >
                            <div class="nav-heading">
                                <p>Add Field</p>
                            </div>
                            <div class="add-inner">
                                <div class="close-acc"></div>
                                <form>
                                    <label class="form-label">Field Type</label>
                                   <select class="form-select field-type-select">
                                            <option value="text">Text Input</option>
                                            ${Object.entries(fieldTypes).filter(([type]) => type !== 'text').map(([type, config]) =>
                                                `<option value="${type}">${config.label}</option>`
                                            ).join('')}
                                        </select>
                                    <label class="form-label me-2">Field Id:</label>
                                    <input type="text" class="form-control" name="fieldId" value= '${fieldId}' readonly> 
                                    <div class="field-options">
                                                <!-- Field type specific options will be loaded here -->
                                            </div>
                                    <div class="back-btn-wrap">
                                        <a href="javascript:void(0);" class="saveToFields"><img src="{{ asset('images') }}/save-file.svg" alt="icon"> Save Field</a>
                                    </div>
                                    <button class="btn btn-danger btn-sm removeField mt-2 d-none"  id="remove-${fieldId}">
                                                <i class="fa fa-trash"></i> Remove Field
                                    </button>
                                </form>
                            </div>
                        </div>

                        


                `;

                // Append the field to the field container of the step
                stepCard.find(".new-entry").html(fieldTemplate);

                $('html, body').animate({
                        scrollTop: $(`#accordion-${fieldId}`).offset().top - 112
                    }, 300);
                // Load field type specific options
                const $fieldOptions = stepCard.find(`#accordion-${fieldId} .field-options`);
                $fieldOptions.html(fieldTypes.text.template);

                // Add event listener for label changes
                stepCard.find(`#accordion-${fieldId} input[name="label"]`).on('input', function() {
                    const label = $(this).val() || '';
                    $(this).closest('.accordion').find('.field-label').text(label);
                });

                // Add change handler for field type selection with a new field ID each time
                stepCard.find(`#accordion-${fieldId} .field-type-select`).on('change', function() {
                    console.log(1752);
                    const type = $(this).val();
                    const $opts = $(this).closest('.addfield-inner').find('.field-options');
                    $opts.html(fieldTypes[type].template);

                    // Initialize field type specific features
                    if (type === 'custom_radio' || type === 'headboard_radio' || type ===
                        'canopy_radio' || type === 'tray_sides_radio') {
                        const $container = $opts.find('.custom-radio-options-container');
                        $container.attr('id', `radio-container-${fieldId}`).attr('data-field-id',
                            fieldId).empty();

                        // Add first option immediately
                        if (type === 'headboard_radio') {
                            addHeadboardOption($container, fieldId, 0);
                        } else {
                            addCustomRadioOption($container, fieldId, 0);
                        }
                        // Add button handler
                        $opts.find('.add-custom-radio-option').off('click').on('click', function() {
                            const optionCount = $container.children().length;
                            if (type === 'headboard_radio') {
                                addHeadboardOption($container, fieldId, optionCount);
                            } else {
                                addCustomRadioOption($container, fieldId, optionCount);
                            }
                            updateStepJSON();
                        });
                    }

                    // Add label change listener for the new field type
                    $opts.find('input[name="label"]').on('input', function() {
                        const label = $(this).val() || '';
                        $(this).closest('.accordion').find('.field-label').text(label);
                    });

                    updateStepJSON();
                });

                updateStepJSON();
            });


            $(`body`).on('change','.edit-field .field-type-select', function() {
                    console.log(1752);
                    const type = $(this).val();
                    const $opts = $(this).closest('.addfield-inner').find('.field-options');
                    const fieldId = $(this).closest('form').find('[name="fieldId"]').val();
                    $opts.html(fieldTypes[type].template);

                    // Initialize field type specific features
                    if (type === 'custom_radio' || type === 'headboard_radio' || type ===
                        'canopy_radio' || type === 'tray_sides_radio') {
                        const $container = $opts.find('.custom-radio-options-container');
                        $container.attr('id', `radio-container-${fieldId}`).attr('data-field-id',
                            fieldId).empty();

                        // Add first option immediately
                        if (type === 'headboard_radio') {
                            addHeadboardOption($container, fieldId, 0);
                        } else {
                            addCustomRadioOption($container, fieldId, 0);
                        }
                        // Add button handler
                        $opts.find('.add-custom-radio-option').off('click').on('click', function() {
                            const optionCount = $container.children().length;
                            if (type === 'headboard_radio') {
                                addHeadboardOption($container, fieldId, optionCount);
                            } else {
                                addCustomRadioOption($container, fieldId, optionCount);
                            }
                            updateStepJSON();
                        });
                    }

                    // Add label change listener for the new field type
                    $opts.find('input[name="label"]').on('input', function() {
                        const label = $(this).val() || '';
                        $(this).closest('.accordion').find('.field-label').text(label);
                    });

                    updateStepJSON();
                });

            // Handle field type change
            $(document).on("change", ".field-type-select", function() {
                const $fieldOptions = $(this).find('.field-options');
                const fieldType = $(this).val();
                $fieldOptions.html(fieldTypes[fieldType].template);

                // Get the current fieldId without changing it
                const fieldId = $(this).closest('.addfield-inner').attr('id').replace('accordion-', '');

                // Add label change listener and immediately trigger it to update the field label in the accordion header
                const $labelInput = $fieldOptions.find('input[name="label"]');
                $labelInput.on('input', function() {
                    const label = $(this).val() || '';
                    $(this).closest('.addfield-inner').find('.field-label').text(label);
                });

                // If there's already a label in the header, copy it to the new field type's label input
                const currentLabel = $(this).closest('.addfield-inner').find('.field-label').text();
                if (currentLabel && currentLabel !== '') {
                    $labelInput.val(currentLabel);
                }

                // Special handling for price display field
                if (fieldType === 'price_display') {
                    const priceDisplayId = `price-display-${fieldId}`;

                    // Update preview when currency symbol or initial value changes
                    $fieldOptions.find('input[name="currency_symbol"], input[name="initial_value"]').on(
                        'input',
                        function() {
                            const $container = $(this).closest('.field-options');
                            const currencySymbol = $container.find('input[name="currency_symbol"]')
                                .val();
                            const initialValue = $container.find('input[name="initial_value"]').val();

                            $container.find('.currency-symbol').text(currencySymbol);
                            $container.find('.price-value').text(initialValue);
                        });

                    // Add unique ID to the preview div
                    $fieldOptions.find('.price-value').attr('id', priceDisplayId);
                }

                // Special handling for colors field type
               if (fieldType === 'colors') {


                    if($('.color-img-dropzone').length > 0) {
                        // Initialize dropzones for color options
                        const colorDropzones = document.querySelectorAll('.color-img-dropzone');
                        colorDropzones.forEach(dropzoneElement => {
                            if (!dropzoneElement.dropzone) {
                                new Dropzone(dropzoneElement, {
                                    url: "/back/upload/color-image",
                                    paramName: "file",
                                    maxFilesize: 5,
                                    maxFiles: 1,
                                    acceptedFiles: "image/*",
                                    dictDefaultMessage: "Drop image here or click to upload.",
                                    dictRemoveFile: "Remove",
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    init: function() {
                                        this.on("success", function(file, response) {
                                            const colorOption = dropzoneElement
                                                .closest('.color-option');
                                            const imagePath = response.filePath;

                                            colorOption.querySelector(
                                                    '.color-image-data').value =
                                                imagePath;

                                            updateStepJSON();
                                        });
                                    }
                                });
                            }
                        });
                    }
                }

                // Special handling for radio options
                if (fieldType === 'radio') {
                    // Handle adding new radio option
                    $fieldOptions.find('.add-radio-option').on('click', function() {
                        const newRadioOption = `
                        <div class="radio-option mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label">
                                <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text">
                                <div class="form-check">
                                     <div class="create-form-checkbox reminder-con">
                                        <label class="custom-checkbox">
                                                <input type="checkbox" checked="checked" class="form-check-input field-input" name="option_active[]">
                                            <span class="checkmark"></span> <span class="remember-text">Active</span>
                                        </label>
                                       </div>
                                </div>
                                <button type="button" class="btn btn-sm remove-option"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                            </div>
                        </div>`;
                        $(this).siblings('.radio-options-container').append(
                            newRadioOption);
                        updateStepJSON();
                    });

                    // Handle removing radio option
                    $fieldOptions.on('click', '.remove-option', function() {
                        $(this).closest('.radio-option').remove();
                        updateStepJSON();
                    });
                }

                // Special handling for custom radio options
                if (fieldType === 'custom_radio' || fieldType === 'headboard_radio' || fieldType ===
                    'canopy_radio' || fieldType === 'tray_sides_radio') {
                    const $container = $fieldOptions.find('.custom-radio-options-container');
                    const $addButton = $fieldOptions.find('.add-custom-radio-option');

                    // Clear the container and add a unique ID - preserve the original fieldId
                    $container.attr('id', `radio-container-${fieldId}`).attr('data-field-id', fieldId)
                        .empty();

                    // Add first option immediately - use the original fieldId
                    if (fieldType === 'headboard_radio') {
                        addHeadboardOption($container, fieldId, 0);
                    } else {
                        addCustomRadioOption($container, fieldId, 0);
                    }

                    // Add click handler for the add button specific to this field
                    $addButton.off('click').on('click', function() {
                        const optionCount = $container.children().length;
                        if (fieldType === 'headboard_radio') {
                            addHeadboardOption($container, fieldId, optionCount);
                        } else {
                            addCustomRadioOption($container, fieldId, optionCount);
                        }
                        updateStepJSON();
                    });
                }

                // Special handling for slide options field type
                if (fieldType === 'slide_options') {
                    // Handle adding new slide option
                    $fieldOptions.find('.add-slide-option').on('click', function() {
                        const newSlideOption = `
                        <div class="slide-option mb-2 p-2 border rounded">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <div class="w-100">
                                    <label class="form-label">Label</label>
                                    <input type="text" class="form-control field-input" name="slide_labels[]" placeholder="Option label">
                                </div>
                                <div class="w-100">
                                    <label class="form-label">Quantity</label>
                                    <input type="text" class="form-control field-input" name="slide_quantities[]" placeholder="Quantity" min="1" value="1">
                                </div>
                                <div class="d-flex flex-column w-100">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control field-input slide-image-input" name="slide_images[]" accept="image/*">
                                    <input type="hidden" class="slide-image-data" name="slide_image_data[]">
                                    <div class="slide-image-preview mt-2" style="max-width: 100px;"></div>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-slide-option mt-3"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                            </div>
                        </div>`;
                        $(this).closest('.mb-3').find('.slide-options-container').append(
                            newSlideOption);
                        updateStepJSON();
                    });

                    // Handle removing slide option
                    $fieldOptions.on('click', '.remove-slide-option', function() {
                        $(this).closest('.slide-option').remove();
                        updateStepJSON();
                    });

                    // Handle slide image upload and preview
                    $fieldOptions.on('change', '.slide-image-input', function(e) {
                        const file = e.target.files[0];
                        const $option = $(this).closest('.slide-option');
                        const $imageData = $option.find('.slide-image-data');
                        const $preview = $option.find('.slide-image-preview');

                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const base64String = e.target.result;

                                // Set placeholder to indicate a new image was uploaded
                                $imageData.val('slide_upload_placeholder');

                                // Show preview
                                $preview.html(
                                    `<img src="${base64String}" class="img-fluid rounded">`);
                                updateStepJSON();
                            };
                            reader.readAsDataURL(file);
                        } else {
                            // If file input is cleared, preserve the existing image URL if it exists
                            const currentImageUrl = $preview.find('img').attr('src');
                            if (currentImageUrl && !currentImageUrl.startsWith('data:')) {
                                // Keep existing image, don't change anything
                            } else {
                                // No existing image or temp base64 preview, clear everything
                                $imageData.val('');
                                $preview.empty();
                            }
                            updateStepJSON();
                        }
                    });
                }

                // After setting up all field-specific handlers, make sure to update the steps JSON
                updateStepJSON();
            });

            // Handle field input changes
            $(document).on("change input", ".field-input", function() {
                updateStepJSON();
            });

            // Add specific handler for label changes to update the field title
            $(document).on("input", "input[name='label']", function() {
                const label = $(this).val() || '';
                $(this).closest('.accordion').find('.field-label').text(label);
                updateStepJSON();
            });

            $(document).on("click", ".removeField", function() {
                $(this).closest(".accordion").remove();
                updateStepJSON();
            });

            $(document).on("change", ".template-select", function() {
                const selectedTemplate = $(this).val();
                const templateImage = $(this).find("option:selected").data("image");
                const $card = $(this).closest('.card');
                const stepId = $card.attr('id');

                $card.find(".template-preview").attr("src", templateImage);

                // // console.log(`Template changed for step ${stepId} to: ${selectedTemplate}`);

                // Force a delay before updating the step JSON to ensure the value is set
                setTimeout(function() {
                    updateStepJSON();
                }, 100);
            });

            // Handle radio option management
            $(document).on('click', '.add-radio-option', function() {
                let optionTemplate = `
                <div class="radio-option mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label">
                        <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text">
                        <div class="form-check">
                             <div class="create-form-checkbox reminder-con">
                                <label class="custom-checkbox">
                                        <input type="checkbox" checked="checked" class="form-check-input field-input" name="option_active[]">
                                    <span class="checkmark"></span> <span class="remember-text">Active</span>
                                </label>
                                </div>
                        </div>


                                     
                        <button type="button" class="btn btn-sm remove-option"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                    </div>
                </div>
            `;
                $(this).siblings('.radio-options-container').append(optionTemplate);
                updateStepJSON();
            });

            $(document).on('click', '.remove-option', function() {
                $(this).closest('.radio-option').remove();
                updateStepJSON();
            });

            $(document).on('click', '.remove-step', function() {
                let stepId = $(this).data('step');
                $("#" + stepId).remove();
                updateStepJSON(); // Call this function if you need to update JSON after removal
            });

            $(document).on('input change', '.step-label-input', function() {
                // // console.log("Step input changed:", $(this).attr('placeholder'), $(this).val());

                let inputVal = $(this).val().trim(); // Get input value
                let stepCard = $(this).closest(".card"); // Find the closest step card
                let stepTitle = stepCard.find(".step-title"); // Locate step title element

                if (inputVal) {
                    stepTitle.text(inputVal); // Set title to input value
                } else {
                    stepTitle.text("Step Title"); // Default title if empty
                }

                updateStepJSON(); // Update JSON after change
            });

            // Initialize form with existing data
            if (steps && steps.length > 0) {
                steps.forEach(function(step) {
                    stepCount++;
                    let stepId = step.id || `step-${stepCount}`;
                    let contentId = `content-${stepCount}`;
                    let templateValue = step.template || '1'; // Default to template 1 if not specified

                    // // console.log(`Initializing step ${stepCount} with template: ${templateValue}`);

                    let stepTemplate = `
                    <div class="card shadow-sm border-0 mb-3" id="${stepId}">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold step-title">${step.title || `Step ${stepCount}`}</span>
                            <div>
                                <button class="btn btn-white btn-sm  me-2 remove-step" data-step="${stepId}" style="background-color: trasnparent; color: white;">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <i class="fa fa-arrows-alt move-icon me-3" style="cursor: grab;"></i>
                                <i class="fa fa-chevron-down toggle-icon" data-bs-toggle="collapse" data-bs-target="#${contentId}" style="cursor:pointer;"></i>
                            </div>
                        </div>
                        <div class="card-body collapse show" id="${contentId}">
                            <div class="row">
                                <!-- Left Column (Form Fields) -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="fw-bold">Label:</label>
                                        <input type="text" class="form-control step-input step-label-input step-label" placeholder="Enter form name" value="${step.label || ''}" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Main Heading:</label>
                                        <input type="text" class="form-control step-input step-mainHeading" placeholder="Enter main heading " value="${step.mainHeading || ''}" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Subheading:</label>
                                        <input type="text" class="form-control step-input step-subheading" placeholder="Enter subheading" value="${step.subheading || ''}" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Side Heading:</label>
                                        <input type="text" class="form-control step-input step-sideHeading" placeholder="Enter side heading" value="${step.sideHeading || ''}" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Template:</label>
                                        <select class="form-select template-select">
                                            <option value="1" data-image="{{ asset('assets/template_image/template1.png') }}" ${templateValue === '1' ? 'selected' : ''}>Template 1 (Static Image)</option>
                                            <option value="2" data-image="{{ asset('assets/template_image/template1.png') }}" ${templateValue === '2' ? 'selected' : ''}>Template 2 (Dynamic Image)</option>
                                            <option value="3" data-image="{{ asset('assets/template_image/template2.png') }}" ${templateValue === '3' ? 'selected' : ''}>Template 3</option>
                                            <option value="4" data-image="{{ asset('assets/template_image/template3.png') }}" ${templateValue === '4' ? 'selected' : ''}>Template 4</option>
                                            <option value="0" data-image="{{ asset('assets/template_image/noBg.jpg') }}" ${templateValue === '0' ? 'selected' : ''}>No Template</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Right Column (Template Image) -->
                                <div class="col-md-6 text-left">
                                    <div class="fw-bold">Template Preview:</div>
                                    <img class="template-preview img-fluid rounded shadow-sm"
                                        src="{{ asset('assets/template_image') }}/${templateValue == 0 ? 'noBg.jpg' : 'template' + templateValue + '.png'}"
                                        alt="Template Preview" style="width: 100%; height: auto;">

                                </div>
                            </div>

                            <!-- Field container for this step -->
                            <div class="field-container mt-3">
                                <!-- Fields will be added here -->
                            </div>

                            <div class="d-flex align-items-center mt-3">
                                <button class="btn btn-primary btn-sm addField">
                                    <i class="fa fa-plus"></i> Add Field
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                    $(".add_Step").append(stepTemplate);

                    console.log("step: ",step);

                    // Add existing fields
                    if (step.fields && step.fields.length > 0) {
                        step.fields.forEach(function(field) {

                           
                            // Keep the original field ID instead of incrementing fieldCount
                            let fieldId = field.id;
                             console.log("fieldId: ", fieldId);
                            // Only increment fieldCount if we're creating a new ID
                            if (!fieldId) {
                                fieldCount++;
                                fieldId = `field-${fieldCount}`;
                            }
                            let stepCard = $(`#${stepId}`);

                            let fieldTemplate = `

                            <div class="addfield-inner edit-field" id="accordion-${fieldId}" style="display:none;">
                            <div class="nav-heading">
                                <p>${field.label}</p>
                            </div>
                            <div class="add-inner">
                                <div class="close-acc"></div>
                                <form>
                                    <label class="form-label">Field Type</label>
                                    <select class="form-select field-type-select">
                                        ${Object.entries(fieldTypes).map(([type, config]) =>
                                            `<option value="${type}" ${field.type === type ? 'selected' : ''}>${config.label}</option>`
                                        ).join('')}
                                    </select>
                                    <label class="form-label me-2">Field Id:</label>
                                    <input type="text" class="form-control" name="fieldId" value= '${fieldId}' readonly> 
                                    <div class="field-options">
                                                <!-- Field type specific options will be loaded here -->
                                            </div>
                                    <div class="back-btn-wrap">
                                        <a href="javascript:void(0);" class="save-edit-field"><img src="{{ asset('images') }}/save-file.svg" alt="icon"> Save Field</a>
                                    </div>
                                    <button class="btn btn-danger btn-sm removeField mt-2 d-none"  id="remove-${fieldId}">
                                                <i class="fa fa-trash"></i> Remove Field
                                    </button>
                                </form>
                            </div>
                        </div>


                        `;

                            stepCard.find(".field-container").append(fieldTemplate);

                            // Load field type specific options with existing values
                            const $fieldOptions = stepCard.find(
                                `#accordion-${fieldId} .field-options, #field-${fieldId} .field-options`);
                            $fieldOptions.html(fieldTypes[field.type].template);

                            // Set existing field values
                            Object.keys(field).forEach(function(key) {
                                if (key !== 'id' && key !== 'type') {
                                    // Handle radio options
                                    if (key === 'options' && field.type === 'radio' && Array
                                        .isArray(field.options)) {
                                        // Clear existing default options
                                        $fieldOptions.find('.radio-options-container')
                                            .empty();

                                        // Add each saved option
                                        field.options.forEach(function(option) {
                                            const newOption = `
                                            <div class="radio-option mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                    <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text" value="${option.text || ''}">
                                                    <div class="form-check">
                                                        <div class="create-form-checkbox reminder-con">
                                                             <label class="custom-checkbox">
                                                                <input type="checkbox" checked="checked" class="form-check-input field-input" name="option_active[]" ${option.isActive ? 'checked' : ''}>
                                                                <span class="checkmark"></span> <span class="remember-text">Active</span>
                                                            
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-sm remove-option"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                </div>
                                            </div>`;
                                            $fieldOptions.find(
                                                    '.radio-options-container')
                                                .append(newOption);
                                        });
                                    }
                                    // Handle custom radio options
                                    else if (key === 'options' && (field.type ===
                                            'custom_radio' || field.type ===
                                            'canopy_radio' || field.type ===
                                            'tray_sides_radio') && Array.isArray(field
                                            .options)) {
                                        // Clear and set unique ID for container
                                        const $container = $fieldOptions.find(
                                            '.custom-radio-options-container');
                                        $container.attr('id', `radio-container-${fieldId}`)
                                            .attr('data-field-id', fieldId).empty();

                                        // Add button handler
                                        const $addButton = $fieldOptions.find(
                                            '.add-custom-radio-option');
                                        $addButton.off('click').on('click', function() {
                                            const optionCount = $container
                                                .children().length;
                                            addCustomRadioOption($container,
                                                fieldId, optionCount);
                                            updateStepJSON();
                                        });

                                        // Add each saved option
                                        field.options.forEach(function(option, index) {
                                            const optionId =
                                                `option-${fieldId}-${index}`;
                                            const newOption = `
                                            <div class="custom-radio-option mb-2 p-2 border rounded" id="${optionId}" data-field-id="${fieldId}">
                                                  <div class="m-2">
                                                    <div class="">
                                                        <label class="form-label">Option Label</label>
                                                        <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Option Text</label>
                                                        <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text" value="${option.text || ''}">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Option Length</label>
                                                        <input type="text" class="form-control field-input" name="option_lengths[]" placeholder="Length" value="${option.length || ''}">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Option Fitment Time</label>
                                                        <input type="text" class="form-control field-input" name="option_times[]" placeholder="fitment time" value="${option.fitment_time || ''}">
                                                    </div>
                                                     <div class="d-flex p-2 flex-column car-size-field-main">
                                                        <label class="form-label fw-bold">Price</label>
                                                        <div class="d-flex gap-2 car-size-field-outer">
                                                            <div class="d-flex flex-column car-size-field-form">
                                                                <label class="form-label">Mid Sized</label>
                                                                <input type="number" class="form-control field-input" name="option_mid_sized[]" placeholder="price" value="${option.mid_sized_price || ''}">
                                                            </div>
                                                            <div class="d-flex flex-column car-size-field-form">
                                                                <label class="form-label">Toyota 79</label>
                                                                <input type="number" class="form-control field-input" name="option_toyota_79[]" placeholder="price" value="${option.toyota_79_price || ''}">
                                                            </div>
                                                            <div class="d-flex flex-column car-size-field-form">
                                                                <label class="form-label">USA Truck</label>
                                                                <input type="number" class="form-control field-input" name="option_usa_truck[]" placeholder="price" value="${option.usa_truck_price || ''}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-check w-100 m-2">
                                                        <div class="create-form-checkbox reminder-con">
                                                            <label class="custom-checkbox">
                                                                    
                                                                   <input type="checkbox" class="form-check-input field-input m-1" name="option_active[]" ${option.isActive ? 'checked' : ''}>
                                                                <span class="checkmark"></span> <span class="remember-text">Active</span>
                                                            </label>
                                                        </div>
                                                      
                                                    </div>




                                           <div class="upload-images-main"> 
                                                    <div class="d-flex flex-column upload-images-con">
                                                        <label class="form-label">White without Headboard Image</label>
                                                        <!-- Dropzone container for white image -->
                                                        <div id="white-image-dropzone-${optionId}" class="dropzone">
                                                            <div class="dz-message">
                                                                Drop image here or click to upload.
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="white-image-data" name="option_white_image[]">
                                                        <div class="white-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                                                    </div>

                                                    <div class="d-flex flex-column upload-images-con">
                                                        <label class="form-label">Black without Headboard Image</label>
                                                        <!-- Dropzone container for black image -->
                                                        <div id="black-image-dropzone-${optionId}" class="dropzone">
                                                            <div class="dz-message">
                                                                Drop image here or click to upload.
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="black-image-data" name="option_black_image[]">
                                                        <div class="black-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                                                    </div>

                                                    <div class="d-flex flex-column upload-images-con">
                                                        <label class="form-label">White with Headboard Image</label>
                                                        <div id="white-image-dropzone-with-headboard-${optionId}" class="dropzone">
                                                            <div class="dz-message">
                                                                Drop image here or click to upload.
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="white-image-data-with-headboard" name="option_white_image_withHeadboard[]" value="${option.whiteImage || ''}">
                                                        <div class="white-image-preview-with-headboard mt-2" style="max-width: 100px; display:none;">
                                                            ${option.whiteImage ? `<img src="${option.whiteImage}" class="img-fluid rounded">` : ''}
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-column upload-images-con">
                                                        <label class="form-label">Black with Headboard Image</label>
                                                        <div id="black-image-dropzone-with-headboard-${optionId}" class="dropzone">
                                                            <div class="dz-message">
                                                                Drop image here or click to upload.
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="black-image-data-with-headboard" name="option_black_image_withHeadboard[]" value="${option.blackImage || ''}">
                                                        <div class="black-image-preview-with-headboard mt-2" style="max-width: 100px; display:none;">
                                                            ${option.blackImage ? `<img src="${option.blackImage}" class="img-fluid rounded">` : ''}
                                                        </div>
                                                    </div>
                                            </div>

                                                    <button type="button" class="btn btn-danger btn-sm custom-radio-remove-btn" data-option-id="${optionId}"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                </div>
                                            </div>`;
                                            $container.append(newOption);

                                            // Add specific event handlers for this option's images
                                            $(`#${optionId} .white-image-input`)
                                                .off('change').on('change',
                                                    function(e) {
                                                        handleCustomRadioImageUpload
                                                            ($(this), 'white');
                                                    });

                                            $(`#${optionId} .black-image-input`)
                                                .off('change').on('change',
                                                    function(e) {
                                                        handleCustomRadioImageUpload
                                                            ($(this), 'black');
                                                    });

                                            $(`#${optionId} .custom-radio-remove-btn`)
                                                .off('click').on('click', function(
                                                    e) {
                                                    e
                                                        .stopPropagation(); // Prevent event bubbling
                                                    $(`#${optionId}`).remove();
                                                    updateStepJSON();
                                                });


                                            const whiteDropzoneId =
                                                `white-image-dropzone-${optionId}`;
                                            const blackDropzoneId =
                                                `black-image-dropzone-${optionId}`;

                                            const whiteDropzoneId_withHeadboard =
                                                `white-image-dropzone-with-headboard-${optionId}`;
                                            const blackDropzoneId_withHeadboard =
                                                `black-image-dropzone-with-headboard-${optionId}`;

                                            // Append dropzone containers for white and black image
                                            if($(`#${whiteDropzoneId}`).length > 0) {
                                                console.log(2531);
                                                const $whiteDropzone = new Dropzone(
                                                    `#${whiteDropzoneId}`, {
                                                        url: "/back/upload/white-image", // Replace with your route
                                                        maxFiles: 1,
                                                        addRemoveLinks: true,
                                                        headers: {
                                                            'X-CSRF-TOKEN': document
                                                                .querySelector(
                                                                    'meta[name="csrf-token"]'
                                                                    ).getAttribute(
                                                                    'content')
                                                        },
                                                        init: function() {
                                                            const dz = this;

                                                            dz.on("addedfile",
                                                                function(
                                                                    file) {
                                                                    if (dz
                                                                        .files
                                                                        .length >
                                                                        1) {
                                                                        dz.removeFile(
                                                                            file
                                                                            );
                                                                        Swal.fire({
                                                                            icon: 'warning',
                                                                            title: 'Only one image allowed',
                                                                            text: 'Please remove the existing image before uploading a new one.',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                    }
                                                                });

                                                            if (option
                                                                .whiteImage
                                                                ) {
                                                                const
                                                                mockFile = {
                                                                    name: "white.jpg",
                                                                    size: 12345
                                                                };
                                                                dz.emit("addedfile",
                                                                    mockFile
                                                                    );
                                                                dz.emit("thumbnail",
                                                                    mockFile,
                                                                /*   "{{ url('/') }}/" + */
                                                                    option
                                                                    .whiteImage
                                                                    );
                                                                dz.emit("complete",
                                                                    mockFile
                                                                    );
                                                                dz.files.push(
                                                                    mockFile
                                                                    );

                                                                $(`#${optionId} .white-image-data`)
                                                                    .val(option
                                                                        .whiteImage
                                                                        );
                                                                $(`#${optionId} .white-image-preview`)
                                                                    .html(
                                                                        `<img src="${option.whiteImage}" alt="White Image" style="max-width: 100px;">`
                                                                        );

                                                                mockFile
                                                                    .previewElement
                                                                    .querySelector(
                                                                        ".dz-remove"
                                                                        )
                                                                    .addEventListener(
                                                                        "click",
                                                                        function() {
                                                                            const
                                                                                oldImageUrl =
                                                                                $(
                                                                                    `#${optionId} .white-image-data`)
                                                                                .val();
                                                                            // if (oldImageUrl) {
                                                                            //     $.ajax({
                                                                            //         url: '/back/delete/white-image',
                                                                            //         type: 'POST',
                                                                            //         data: {
                                                                            //             image_url: oldImageUrl,
                                                                            //             _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                            //         }
                                                                            //     });
                                                                            // }

                                                                            dz.removeFile(
                                                                                mockFile
                                                                                );
                                                                            $(`#${optionId} .white-image-data`)
                                                                                .val(
                                                                                    ""
                                                                                    );
                                                                            updateStepJSON
                                                                                ();
                                                                        });
                                                            }

                                                            dz.on("success",
                                                                function(
                                                                    file,
                                                                    response
                                                                    ) {
                                                                    $(`#${optionId} .white-image-data`)
                                                                        .val(
                                                                            response
                                                                            .path
                                                                            );
                                                                    $(`#${optionId} .white-image-preview`)
                                                                        .html(
                                                                            `<img src="${response.path}" alt="White Image" style="max-width: 100px;">`
                                                                            );
                                                                    updateStepJSON
                                                                        ();
                                                                });

                                                            dz.on("removedfile",
                                                                function(
                                                                    file) {
                                                                    // Prevent auto-clearing here (handled above on .dz-remove)
                                                                });
                                                        }

                                                });
                                            }
                                            if($(`#${blackDropzoneId}`).length > 0) {
                                                console.log(2663);
                                                const $blackDropzone = new Dropzone(
                                                    `#${blackDropzoneId}`, {
                                                        url: "/back/upload/black-image", // Replace with your route
                                                        maxFiles: 1,
                                                        addRemoveLinks: true,
                                                        headers: {
                                                            'X-CSRF-TOKEN': document
                                                                .querySelector(
                                                                    'meta[name="csrf-token"]'
                                                                    ).getAttribute(
                                                                    'content')
                                                        },
                                                        init: function() {
                                                            const dz = this;

                                                            dz.on("addedfile",
                                                                function(
                                                                    file) {
                                                                    // if (dz.files.length > 1) {
                                                                    //     dz.removeFile(file);
                                                                    //     Swal.fire({
                                                                    //         icon: 'warning',
                                                                    //         title: 'Only one image allowed',
                                                                    //         text: 'Please remove the existing image before uploading a new one.',
                                                                    //         confirmButtonText: 'OK'
                                                                    //     });
                                                                    // }
                                                                });

                                                            if (option
                                                                .blackImage
                                                                ) {
                                                                const
                                                                mockFile = {
                                                                    name: "black.jpg",
                                                                    size: 12345
                                                                };
                                                                dz.emit("addedfile",
                                                                    mockFile
                                                                    );
                                                                dz.emit("thumbnail",
                                                                    mockFile,
                                                                /*   "{{ url('/') }}/" + */
                                                                    option
                                                                    .blackImage
                                                                    );
                                                                dz.emit("complete",
                                                                    mockFile
                                                                    );
                                                                dz.files.push(
                                                                    mockFile
                                                                    );

                                                                $(`#${optionId} .black-image-data`)
                                                                    .val(option
                                                                        .blackImage
                                                                        );
                                                                $(`#${optionId} .black-image-preview`)
                                                                    .html(
                                                                        `<img src="${option.blackImage}" alt="Black Image" style="max-width: 100px;">`
                                                                        );

                                                                mockFile
                                                                    .previewElement
                                                                    .querySelector(
                                                                        ".dz-remove"
                                                                        )
                                                                    .addEventListener(
                                                                        "click",
                                                                        function() {
                                                                            const
                                                                                oldImageUrl =
                                                                                $(
                                                                                    `#${optionId} .black-image-data`)
                                                                                .val();
                                                                            if (
                                                                                oldImageUrl) {
                                                                                $.ajax({
                                                                                    url: '/back/delete/black-image',
                                                                                    type: 'POST',
                                                                                    data: {
                                                                                        image_url: oldImageUrl,
                                                                                        _token: document
                                                                                            .querySelector(
                                                                                                'meta[name="csrf-token"]'
                                                                                                )
                                                                                            .getAttribute(
                                                                                                'content'
                                                                                                )
                                                                                    }
                                                                                });
                                                                            }

                                                                            dz.removeFile(
                                                                                mockFile
                                                                                );
                                                                            $(`#${optionId} .black-image-data`)
                                                                                .val(
                                                                                    ""
                                                                                    );
                                                                            updateStepJSON
                                                                                ();
                                                                        });
                                                            }

                                                            dz.on("success",
                                                                function(
                                                                    file,
                                                                    response
                                                                    ) {
                                                                    $(`#${optionId} .black-image-data`)
                                                                        .val(
                                                                            response
                                                                            .path
                                                                            );
                                                                    $(`#${optionId} .black-image-preview`)
                                                                        .html(
                                                                            `<img src="${response.path}" alt="Black Image" style="max-width: 100px;">`
                                                                            );
                                                                    updateStepJSON
                                                                        ();
                                                                });

                                                            dz.on("removedfile",
                                                                function(
                                                                    file) {
                                                                    // Skip auto-clear; handled manually
                                                                });
                                                        }
                                                });
                                            }

                                            console.log(whiteDropzoneId_withHeadboard);
                                            if($(`#${whiteDropzoneId_withHeadboard}`).length > 0) {
                                                console.log(2797);
                                                const $whiteDropzone_withHeadboard = new Dropzone(
                                                    `#${whiteDropzoneId_withHeadboard}`, {
                                                        url: "/back/upload/white-image", // Replace with your route
                                                        maxFiles: 1,
                                                        addRemoveLinks: true,
                                                        headers: {
                                                            'X-CSRF-TOKEN': document
                                                                .querySelector(
                                                                    'meta[name="csrf-token"]'
                                                                    ).getAttribute(
                                                                    'content')
                                                        },
                                                        init: function() {
                                                            const dz = this;

                                                            dz.on("addedfile",
                                                                function(
                                                                    file) {
                                                                    if (dz
                                                                        .files
                                                                        .length >
                                                                        1) {
                                                                        dz.removeFile(
                                                                            file
                                                                            );
                                                                        Swal.fire({
                                                                            icon: 'warning',
                                                                            title: 'Only one image allowed',
                                                                            text: 'Please remove the existing image before uploading a new one.',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                    }
                                                                });

                                                            if (option
                                                                .whiteImage_withHeadboard
                                                                ) {
                                                                const
                                                                mockFile = {
                                                                    name: "white.jpg",
                                                                    size: 12345
                                                                };
                                                                dz.emit("addedfile",
                                                                    mockFile
                                                                    );
                                                                dz.emit("thumbnail",
                                                                    mockFile,
                                                                /*   "{{ url('/') }}/" + */
                                                                    option
                                                                    .whiteImage_withHeadboard
                                                                    );
                                                                dz.emit("complete",
                                                                    mockFile
                                                                    );
                                                                dz.files.push(
                                                                    mockFile
                                                                    );

                                                                $(`#${optionId} .white-image-data-with-headboard`)
                                                                    .val(option
                                                                        .whiteImage_withHeadboard
                                                                        );
                                                                $(`#${optionId} .white-image-preview-with-headboard`)
                                                                    .html(
                                                                        `<img src="${option.whiteImage_withHeadboard}" alt="White Image" style="max-width: 100px;">`
                                                                        );

                                                                mockFile
                                                                    .previewElement
                                                                    .querySelector(
                                                                        ".dz-remove"
                                                                        )
                                                                    .addEventListener(
                                                                        "click",
                                                                        function() {
                                                                            const
                                                                                oldImageUrl =
                                                                                $(
                                                                                    `#${optionId} .white-image-data-with-headboard`)
                                                                                .val();
                                                                            // if (oldImageUrl) {
                                                                            //     $.ajax({
                                                                            //         url: '/back/delete/white-image',
                                                                            //         type: 'POST',
                                                                            //         data: {
                                                                            //             image_url: oldImageUrl,
                                                                            //             _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                            //         }
                                                                            //     });
                                                                            // }

                                                                            dz.removeFile(
                                                                                mockFile
                                                                                );
                                                                            $(`#${optionId} .white-image-data-with-headboard`)
                                                                                .val("");
                                                                            updateStepJSON
                                                                                ();
                                                                        });
                                                            }

                                                            dz.on("success",
                                                                function(
                                                                    file,
                                                                    response
                                                                    ) {
                                                                        // console.log(response);
                                                                    $(`#${optionId} .white-image-data-with-headboard`)
                                                                        .val(
                                                                            response
                                                                            .path
                                                                            );
                                                                    $(`#${optionId} .white-image-preview-with-headboard`)
                                                                        .html(
                                                                            `<img src="${response.path}" alt="White Image" style="max-width: 100px;">`
                                                                            );
                                                                    updateStepJSON
                                                                        ();
                                                                    // console.log(2170);
                                                                });

                                                            dz.on("removedfile",
                                                                function(
                                                                    file) {
                                                                    // Prevent auto-clearing here (handled above on .dz-remove)
                                                                });
                                                        }

                                                });
                                            }

                                            if($(`#${blackDropzoneId_withHeadboard}`).length > 0) {
                                                console.log(2930);
                                                const $blackDropzone_withHeadboard = new Dropzone(
                                                `#${blackDropzoneId_withHeadboard}`, {
                                                    url: "/back/upload/black-image", // Replace with your route
                                                    maxFiles: 1,
                                                    addRemoveLinks: true,
                                                    headers: {
                                                        'X-CSRF-TOKEN': document
                                                            .querySelector(
                                                                'meta[name="csrf-token"]'
                                                                ).getAttribute(
                                                                'content')
                                                    },
                                                    init: function() {
                                                        const dz = this;

                                                        dz.on("addedfile",
                                                            function(
                                                                file) {
                                                                // if (dz.files.length > 1) {
                                                                //     dz.removeFile(file);
                                                                //     Swal.fire({
                                                                //         icon: 'warning',
                                                                //         title: 'Only one image allowed',
                                                                //         text: 'Please remove the existing image before uploading a new one.',
                                                                //         confirmButtonText: 'OK'
                                                                //     });
                                                                // }
                                                            });

                                                        if (option
                                                            .blackImage_withHeadboard
                                                            ) {
                                                            const
                                                            mockFile = {
                                                                name: "black.jpg",
                                                                size: 12345
                                                            };
                                                            dz.emit("addedfile",
                                                                mockFile
                                                                );
                                                            dz.emit("thumbnail",
                                                                mockFile,
                                                              /*   "{{ url('/') }}/" + */
                                                                option
                                                                .blackImage_withHeadboard
                                                                );
                                                            dz.emit("complete",
                                                                mockFile
                                                                );
                                                            dz.files.push(
                                                                mockFile
                                                                );

                                                            $(`#${optionId} .black-image-data-with-headboard`)
                                                                .val(option
                                                                    .blackImage_withHeadboard
                                                                    );
                                                            $(`#${optionId} .black-image-preview-with-headboard`)
                                                                .html(
                                                                    `<img src="${option.blackImage_withHeadboard}" alt="Black Image" style="max-width: 100px;">`
                                                                    );

                                                            mockFile
                                                                .previewElement
                                                                .querySelector(
                                                                    ".dz-remove"
                                                                    )
                                                                .addEventListener(
                                                                    "click",
                                                                    function() {
                                                                        const
                                                                            oldImageUrl =
                                                                            $(
                                                                                `#${optionId} .black-image-data-with-headboard`)
                                                                            .val();
                                                                        if (
                                                                            oldImageUrl) {
                                                                            $.ajax({
                                                                                url: '/back/delete/black-image',
                                                                                type: 'POST',
                                                                                data: {
                                                                                    image_url: oldImageUrl,
                                                                                    _token: document
                                                                                        .querySelector(
                                                                                            'meta[name="csrf-token"]'
                                                                                            )
                                                                                        .getAttribute(
                                                                                            'content'
                                                                                            )
                                                                                }
                                                                            });
                                                                        }

                                                                        dz.removeFile(
                                                                            mockFile
                                                                            );
                                                                        $(`#${optionId} .black-image-data-with-headboard`)
                                                                            .val(
                                                                                ""
                                                                                );
                                                                        updateStepJSON
                                                                            ();
                                                                    });
                                                        }

                                                        dz.on("success",
                                                            function(
                                                                file,
                                                                response
                                                                ) {
                                                                $(`#${optionId} .black-image-data-with-headboard`)
                                                                    .val(
                                                                        response
                                                                        .path
                                                                        );
                                                                $(`#${optionId} .black-image-preview-with-headboard`)
                                                                    .html(
                                                                        `<img src="${response.path}" alt="Black Image" style="max-width: 100px;">`
                                                                        );
                                                                updateStepJSON
                                                                    ();
                                                            });

                                                        dz.on("removedfile",
                                                            function(
                                                                file) {
                                                                // Skip auto-clear; handled manually
                                                            });
                                                    }
                                                });
                                            }


                                        });
                                    }

                                    else if (key === 'options' && (field.type ===
                                            'headboard_radio') && Array.isArray(field
                                            .options)) {
                                        // Clear and set unique ID for container
                                        const $container = $fieldOptions.find(
                                            '.custom-radio-options-container');
                                        $container.attr('id', `radio-container-${fieldId}`)
                                            .attr('data-field-id', fieldId).empty();

                                        // Add button handler
                                        const $addButton = $fieldOptions.find(
                                            '.add-custom-radio-option');
                                        $addButton.off('click').on('click', function() {
                                            const optionCount = $container
                                                .children().length;
                                            addHeadboardOption($container,
                                                fieldId, optionCount);
                                            updateStepJSON();
                                        });

                                        // Add each saved option
                                        field.options.forEach(function(option, index) {
                                            const optionId =
                                                `option-${fieldId}-${index}`;
                                            const newOption = `
                                            <div class="custom-radio-option mb-2 p-2 border rounded" id="${optionId}" data-field-id="${fieldId}">
                                                  <div class="m-2">
                                                    <div class="">
                                                        <label class="form-label">Option Label</label>
                                                        <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Option Text</label>
                                                        <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text" value="${option.text || ''}">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Option Length</label>
                                                        <input type="text" class="form-control field-input" name="option_lengths[]" placeholder="Length" value="${option.length || ''}">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Option Fitment Time</label>
                                                        <input type="text" class="form-control field-input" name="option_times[]" placeholder="fitment time" value="${option.fitment_time || ''}">
                                                    </div>
                                                     <div class="d-flex p-2 flex-column car-size-field-main">
                                                        <label class="form-label fw-bold">Price</label>
                                                        <div class="d-flex gap-2 car-size-field-outer">
                                                            <div class="d-flex flex-column car-size-field-form">
                                                                <label class="form-label">Mid Sized</label>
                                                                <input type="number" class="form-control field-input" name="option_mid_sized[]" placeholder="price" value="${option.mid_sized_price || ''}">
                                                            </div>
                                                            <div class="d-flex flex-column car-size-field-form">
                                                                <label class="form-label">Toyota 79</label>
                                                                <input type="number" class="form-control field-input" name="option_toyota_79[]" placeholder="price" value="${option.toyota_79_price || ''}">
                                                            </div>
                                                            <div class="d-flex flex-column car-size-field-form">
                                                                <label class="form-label">USA Truck</label>
                                                                <input type="number" class="form-control field-input" name="option_usa_truck[]" placeholder="price" value="${option.usa_truck_price || ''}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-check w-100 m-2">


                                                        <div class="create-form-checkbox reminder-con">
                                                            <label class="custom-checkbox">
                                                                    
                                                                     <input type="checkbox" class="form-check-input field-input m-1" name="option_active[]" ${option.isActive ? 'checked' : ''}>
                                                                <span class="checkmark"></span> <span class="remember-text">Active</span>
                                                            </label>
                                                        </div>



                                                       
                                                    </div>
                                               <div class="upload-images-main"> 
                                                    <div class="d-flex flex-column upload-images-con">
                                                        <label class="form-label">White Image</label>
                                                        <div id="white-image-dropzone-${optionId}" class="dropzone">
                                                            <div class="dz-message">
                                                                Drop image here or click to upload.
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="white-image-data" name="option_white_image_data[]" value="${option.whiteImage || ''}">
                                                        <div class="white-image-preview mt-2" style="max-width: 100px; display:none;">
                                                            ${option.whiteImage ? `<img src="${option.whiteImage}" class="img-fluid rounded">` : ''}
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-column upload-images-con">
                                                        <label class="form-label">Black Image</label>
                                                        <div id="black-image-dropzone-${optionId}" class="dropzone">
                                                            <div class="dz-message">
                                                                Drop image here or click to upload.
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="black-image-data" name="option_black_image_data[]" value="${option.blackImage || ''}">
                                                        <div class="black-image-preview mt-2" style="max-width: 100px; display:none;">
                                                            ${option.blackImage ? `<img src="${option.blackImage}" class="img-fluid rounded">` : ''}
                                                        </div>
                                                    </div>
                                             </div>

                                                    <button type="button" class="btn btn-danger btn-sm custom-radio-remove-btn" data-option-id="${optionId}"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                </div>
                                            </div>`;
                                            $container.append(newOption);

                                            // Add specific event handlers for this option's images
                                            $(`#${optionId} .white-image-input`)
                                                .off('change').on('change',
                                                    function(e) {
                                                        handleCustomRadioImageUpload
                                                            ($(this), 'white');
                                                    });

                                            $(`#${optionId} .black-image-input`)
                                                .off('change').on('change',
                                                    function(e) {
                                                        handleCustomRadioImageUpload
                                                            ($(this), 'black');
                                                    });

                                            $(`#${optionId} .custom-radio-remove-btn`)
                                                .off('click').on('click', function(
                                                    e) {
                                                    e
                                                        .stopPropagation(); // Prevent event bubbling
                                                    $(`#${optionId}`).remove();
                                                    updateStepJSON();
                                                });


                                            const whiteDropzoneId =
                                                `white-image-dropzone-${optionId}`;
                                            const blackDropzoneId =
                                                `black-image-dropzone-${optionId}`;
                                            if($(`#${whiteDropzoneId}`).length> 0 ){
                                                // Append dropzone containers for white and black image

                                                const $whiteDropzone = new Dropzone(
                                                    `#${whiteDropzoneId}`, {
                                                        url: "/back/upload/white-image", // Replace with your route
                                                        maxFiles: 1,
                                                        addRemoveLinks: true,
                                                        headers: {
                                                            'X-CSRF-TOKEN': document
                                                                .querySelector(
                                                                    'meta[name="csrf-token"]'
                                                                    ).getAttribute(
                                                                    'content')
                                                        },
                                                        init: function() {
                                                            const dz = this;

                                                            dz.on("addedfile",
                                                                function(
                                                                    file) {
                                                                    if (dz
                                                                        .files
                                                                        .length >
                                                                        1) {
                                                                        dz.removeFile(
                                                                            file
                                                                            );
                                                                        Swal.fire({
                                                                            icon: 'warning',
                                                                            title: 'Only one image allowed',
                                                                            text: 'Please remove the existing image before uploading a new one.',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                    }
                                                                });

                                                            if (option
                                                                .whiteImage
                                                                ) {
                                                                const
                                                                mockFile = {
                                                                    name: "white.jpg",
                                                                    size: 12345
                                                                };
                                                                dz.emit("addedfile",
                                                                    mockFile
                                                                    );
                                                                dz.emit("thumbnail",
                                                                    mockFile,
                                                                /*    "{{ url('/') }}/" + */
                                                                    option
                                                                    .whiteImage
                                                                    );
                                                                dz.emit("complete",
                                                                    mockFile
                                                                    );
                                                                dz.files.push(
                                                                    mockFile
                                                                    );

                                                                $(`#${optionId} .white-image-data`)
                                                                    .val(option
                                                                        .whiteImage
                                                                        );
                                                                $(`#${optionId} .white-image-preview`)
                                                                    .html(
                                                                        `<img src="${option.whiteImage}" alt="White Image" style="max-width: 100px;">`
                                                                        );

                                                                mockFile
                                                                    .previewElement
                                                                    .querySelector(
                                                                        ".dz-remove"
                                                                        )
                                                                    .addEventListener(
                                                                        "click",
                                                                        function() {
                                                                            const
                                                                                oldImageUrl =
                                                                                $(
                                                                                    `#${optionId} .white-image-data`)
                                                                                .val();
                                                                            // if (oldImageUrl) {
                                                                            //     $.ajax({
                                                                            //         url: '/back/delete/white-image',
                                                                            //         type: 'POST',
                                                                            //         data: {
                                                                            //             image_url: oldImageUrl,
                                                                            //             _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                            //         }
                                                                            //     });
                                                                            // }

                                                                            dz.removeFile(
                                                                                mockFile
                                                                                );
                                                                            $(`#${optionId} .white-image-data`)
                                                                                .val(
                                                                                    ""
                                                                                    );
                                                                            updateStepJSON
                                                                                ();
                                                                        });
                                                            }

                                                            dz.on("success",
                                                                function(
                                                                    file,
                                                                    response
                                                                    ) {
                                                                    $(`#${optionId} .white-image-data`)
                                                                        .val(
                                                                            response
                                                                            .path
                                                                            );
                                                                    $(`#${optionId} .white-image-preview`)
                                                                        .html(
                                                                            `<img src="${response.path}" alt="White Image" style="max-width: 100px;">`
                                                                            );
                                                                    updateStepJSON
                                                                        ();
                                                                });

                                                            dz.on("removedfile",
                                                                function(
                                                                    file) {
                                                                    // Prevent auto-clearing here (handled above on .dz-remove)
                                                                });
                                                        }

                                                    });
                                            }
                                            if($(`#${blackDropzoneId}`).length> 0 ){
                                                const $blackDropzone = new Dropzone(
                                                    `#${blackDropzoneId}`, {
                                                        url: "/back/upload/black-image", // Replace with your route
                                                        maxFiles: 1,
                                                        addRemoveLinks: true,
                                                        headers: {
                                                            'X-CSRF-TOKEN': document
                                                                .querySelector(
                                                                    'meta[name="csrf-token"]'
                                                                    ).getAttribute(
                                                                    'content')
                                                        },
                                                        init: function() {
                                                            const dz = this;

                                                            dz.on("addedfile",
                                                                function(
                                                                    file) {
                                                                    // if (dz.files.length > 1) {
                                                                    //     dz.removeFile(file);
                                                                    //     Swal.fire({
                                                                    //         icon: 'warning',
                                                                    //         title: 'Only one image allowed',
                                                                    //         text: 'Please remove the existing image before uploading a new one.',
                                                                    //         confirmButtonText: 'OK'
                                                                    //     });
                                                                    // }
                                                                });

                                                            if (option
                                                                .blackImage
                                                                ) {
                                                                const
                                                                mockFile = {
                                                                    name: "black.jpg",
                                                                    size: 12345
                                                                };
                                                                dz.emit("addedfile",
                                                                    mockFile
                                                                    );
                                                                dz.emit("thumbnail",
                                                                    mockFile,
                                                                /*   "{{ url('/') }}/" + */
                                                                    option
                                                                    .blackImage
                                                                    );
                                                                dz.emit("complete",
                                                                    mockFile
                                                                    );
                                                                dz.files.push(
                                                                    mockFile
                                                                    );

                                                                $(`#${optionId} .black-image-data`)
                                                                    .val(option
                                                                        .blackImage
                                                                        );
                                                                $(`#${optionId} .black-image-preview`)
                                                                    .html(
                                                                        `<img src="${option.blackImage}" alt="Black Image" style="max-width: 100px;">`
                                                                        );

                                                                mockFile
                                                                    .previewElement
                                                                    .querySelector(
                                                                        ".dz-remove"
                                                                        )
                                                                    .addEventListener(
                                                                        "click",
                                                                        function() {
                                                                            const
                                                                                oldImageUrl =
                                                                                $(
                                                                                    `#${optionId} .black-image-data`)
                                                                                .val();
                                                                            if (
                                                                                oldImageUrl) {
                                                                                $.ajax({
                                                                                    url: '/back/delete/black-image',
                                                                                    type: 'POST',
                                                                                    data: {
                                                                                        image_url: oldImageUrl,
                                                                                        _token: document
                                                                                            .querySelector(
                                                                                                'meta[name="csrf-token"]'
                                                                                                )
                                                                                            .getAttribute(
                                                                                                'content'
                                                                                                )
                                                                                    }
                                                                                });
                                                                            }

                                                                            dz.removeFile(
                                                                                mockFile
                                                                                );
                                                                            $(`#${optionId} .black-image-data`)
                                                                                .val("");
                                                                            updateStepJSON
                                                                                ();
                                                                        });
                                                            }

                                                            dz.on("success",
                                                                function(
                                                                    file,
                                                                    response
                                                                    ) {
                                                                    $(`#${optionId} .black-image-data`)
                                                                        .val(
                                                                            response
                                                                            .path
                                                                            );
                                                                    $(`#${optionId} .black-image-preview`)
                                                                        .html(
                                                                            `<img src="${response.path}" alt="Black Image" style="max-width: 100px;">`
                                                                            );
                                                                    updateStepJSON
                                                                        ();
                                                                });

                                                            dz.on("removedfile",
                                                                function(
                                                                    file) {
                                                                    // Skip auto-clear; handled manually
                                                                });
                                                        }
                                                    });
                                            }




                                        });
                                    }




                                    // Handle slide options
                                    else if (key === 'slideOptions' && field.type ===
                                        'slide_options' && Array.isArray(field.slideOptions)
                                    ) {
                                        // Clear existing default options
                                        $fieldOptions.find('.slide-options-container')
                                            .empty();

                                        // Add each saved slide option
                                        field.slideOptions.forEach(function(option) {
                                            const newOption = `
                                            <div class="slide-option mb-2 p-2 border rounded">
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    <div class="w-100">
                                                        <label class="form-label">Label</label>
                                                        <input type="text" class="form-control field-input" name="slide_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                    </div>
                                                    <div class="w-100">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="text" class="form-control field-input" name="slide_quantities[]" placeholder="Quantity" min="1" value="${option.quantity || 1}">
                                                    </div>
                                                    <div class="d-flex flex-column w-100">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" class="form-control field-input slide-image-input" name="slide_images[]" accept="image/*">
                                                        <input type="hidden" class="slide-image-data" name="slide_image_data[]" value="${option.imageData || ''}">
                                                        <div class="slide-image-preview mt-2" style="max-width: 100px;">
                                                            ${option.image_url ? `<img src="${option.image_url}" class="img-fluid rounded">` : ''}
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-danger btn-sm remove-slide-option mt-3"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                </div>
                                            </div>`;
                                            $fieldOptions.find(
                                                    '.slide-options-container')
                                                .append(newOption);
                                        });
                                    }

                                    // Populate saved product type options
                                    else if (key === 'productType' && field.type ===
                                        'products') {
                                        $fieldOptions.find('.product-types-container')
                                            .empty(); // Clear existing options

                                        // field.productType
                                        // .filter(option => option && option
                                        //     .value) // Remove null values
                                        // .forEach(function(option) {
                                        const newOption = `
                                                <select class="form-select field-input" name="product_type">
                                                    <option value="internals" ${field.productType === 'internals' ? 'selected' : ''}>Internal</option>
                                                    <option value="external" ${field.productType === 'external' ? 'selected' : ''}>External</option>
                                                </select>`;
                                        $fieldOptions.find(
                                                '.product-types-container')
                                            .append(newOption);
                                        // });
                                    }



                                    // Handle colors
                                    else if (key === 'colors' && field.type === 'colors' &&
                                        Array.isArray(field.colors)) {
                                        // Clear existing default options
                                        $fieldOptions.find('.color-options-container')
                                            .empty();

                                        // Add each saved color option
                                        field.colors.forEach(function(color, index) {
                                            const optionId =
                                                `option-${fieldId}-${index}`;
                                            const newOption = `
                                            <div class="color-option mb-2" id="${optionId}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="text" class="form-control field-input" name="color_names[]" placeholder="Color name" value="${color.name || ''}">
                                                    <input type="text" class="form-control field-input" name="color_labels[]" placeholder="Display label" value="${color.label || ''}">
                                                    <div id="colors_img_dropzone_${optionId}" class="dropzone color-img-dropzone">
                                                        <div class="dz-message">
                                                            Drop image here or click to upload.
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control field-input" name="color_images[]" accept="image/*">
                                                    <input type="hidden" class="color-image-data" name="color_image_data[]" value="${color.imageData || ''}">
                                                    <button type="button" class="btn btn-danger btn-sm remove-color"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                </div>
                                            </div>`;
                                            $fieldOptions.find(
                                                    '.color-options-container')
                                                .append(newOption);

                                            if($(`#colors_img_dropzone_${optionId}`).length > 0) {
                                                // Initialize dropzone for color images
                                                const colorDropzone = new Dropzone(
                                                    `#colors_img_dropzone_${optionId}`, {
                                                        url: "/back/upload/color-image",
                                                        maxFiles: 1,
                                                        addRemoveLinks: true,
                                                        headers: {
                                                            'X-CSRF-TOKEN': document
                                                                .querySelector(
                                                                    'meta[name="csrf-token"]'
                                                                ).getAttribute(
                                                                    'content')
                                                        },
                                                        init: function() {
                                                            const dz = this;

                                                            dz.on("addedfile",
                                                                function(
                                                                    file) {
                                                                    if (dz
                                                                        .files
                                                                        .length >
                                                                        1) {
                                                                        dz.removeFile(
                                                                            file
                                                                        );
                                                                        Swal.fire({
                                                                            icon: 'warning',
                                                                            title: 'Only one image allowed',
                                                                            text: 'Please remove the existing image before uploading a new one.',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                    }
                                                                });

                                                            if (color
                                                                .image_url) {
                                                                const
                                                                    mockFile = {
                                                                        name: "color.jpg",
                                                                        size: 12345
                                                                    };
                                                                dz.emit("addedfile",
                                                                    mockFile
                                                                );
                                                                dz.emit("thumbnail",
                                                                    mockFile,
                                                                    color
                                                                    .image_url
                                                                );
                                                                dz.emit("complete",
                                                                    mockFile
                                                                );
                                                                dz.files.push(
                                                                    mockFile
                                                                );


                                                                // $(`#${optionId} .color-images`).val(color.image_url);
                                                                $(`#color_option_${index} .color-image-data`)
                                                                    .val(color
                                                                        .image_url
                                                                    );
                                                                $(`#color_option_${index} .color-img-preview`)
                                                                    .html(
                                                                        `<img src="${color.image_url}" alt="Black Image" style="max-width: 100px;">`
                                                                    );


                                                                mockFile
                                                                    .previewElement
                                                                    .querySelector(
                                                                        ".dz-remove"
                                                                    )
                                                                    .addEventListener(
                                                                        "click",
                                                                        function() {
                                                                            const
                                                                                oldImageUrl =
                                                                                color
                                                                                .image_url;
                                                                            if (
                                                                                oldImageUrl
                                                                                ) {
                                                                                $.ajax({
                                                                                    url: '/back/delete/color-image',
                                                                                    type: 'POST',
                                                                                    data: {
                                                                                        image_url: oldImageUrl,
                                                                                        _token: document
                                                                                            .querySelector(
                                                                                                'meta[name="csrf-token"]'
                                                                                            )
                                                                                            .getAttribute(
                                                                                                'content'
                                                                                            )
                                                                                    }
                                                                                });
                                                                            }
                                                                            dz.removeFile(
                                                                                mockFile
                                                                            );
                                                                            $(`#${optionId}`)
                                                                                .find(
                                                                                    '.color-image-data'
                                                                                )
                                                                                .val(
                                                                                    ""
                                                                                );
                                                                            updateStepJSON
                                                                                ();
                                                                        });
                                                            }

                                                            dz.on("success",
                                                                function(
                                                                    file,
                                                                    response
                                                                ) {
                                                                    $(`#${optionId}`)
                                                                        .find(
                                                                            '.color-images'
                                                                        )
                                                                        .val(
                                                                            response
                                                                            .path
                                                                        );
                                                                    $(`#${optionId}`)
                                                                        .find(
                                                                            '.color-image-data'
                                                                        )
                                                                        .val(
                                                                            response
                                                                            .path
                                                                        );
                                                                    updateStepJSON
                                                                        ();
                                                                });

                                                            dz.on("removedfile",
                                                                function(
                                                                    file) {
                                                                    // Handled by dz-remove click event
                                                                });
                                                        }
                                                    });
                                            }
                                        });
                                    }


                                    // Handle regular fields
                                    else {
                                        let $input = $fieldOptions.find(`[name="${key}"]`);
                                        if ($input.length) {
                                            if ($input.attr('type') === 'checkbox') {
                                                $input.prop('checked', field[key]);
                                            } else {
                                                $input.val(field[key]);
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    }

                    // Initialize Bootstrap collapse
                    new bootstrap.Collapse(document.getElementById(contentId), {
                        toggle: true
                    });

                    // Add event listener for toggle icon rotation
                    $(`#${stepId} .toggle-icon`).on('click', function() {
                        $(this).toggleClass('fa-chevron-down fa-chevron-up');
                    });
                });

                updateStepJSON();
            }


            $("#saveFormBtn").click(async function() {
                let formName = $("#formName").val();
                let formSlug = $("#formSlug").val();
                if (!formName) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please enter a form name!',
                    });
                    return;
                }
                $('.progress-outer').show();
                $('#save-message').text("Saving...");
                var step = [];
                // // console.log('Steps before stringify:', steps);
                for (let index = 0; index < steps.length; index++) {
                    step = steps[index];
                    let formData = new FormData();
                    formData.append('name', formName);
                    formData.append('slug', formSlug);
                    formData.append('step_index', index);
                    formData.append('steps', JSON.stringify(step));
                    formData.append('logic', JSON.stringify({}));
                    formData.append('_method', 'PUT');

                    // // console.log('FormData steps:', formData.get('steps'));
                    // console.log('Sending Step:', step);
                    // Return or stop further execution if needed
                    // return;

                    // // Debug: Log formData
                    // for (let pair of formData.entries()) {
                    //     // console.log(pair[0] + ': ' + pair[1]);
                    // }

                    // Handle color image uploads
                    let colorImageCount = 0;
                    $(".color-options-container input[name='color_images[]']").each(function(index) {
                        if (this.files && this.files[0]) {
                            let file = this.files[0];
                            formData.append('color_images[]', file);
                            colorImageCount++;

                            // Track which step and field this image belongs to
                            let stepIndex = $(this).closest('.card').index();
                            let fieldIndex = $(this).closest('.accordion').index();
                            let optionIndex = $(this).closest('.color-option').index();

                            formData.append('color_image_locations[]', JSON.stringify({
                                stepIndex: stepIndex,
                                fieldIndex: fieldIndex,
                                optionIndex: optionIndex
                            }));
                        }
                    });

                    // Update color image placeholders to real filenames
                    if (colorImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if (field.type === "colors" && field.colors) {
                                    field.colors.forEach(color => {
                                        if (color.imageData ===
                                            'upload_placeholder') {
                                            color.image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // 🔹 Append images and store their location in `image_url`
                    let whiteImageCount = 0;
                    let blackImageCount = 0;
                    let slideImageCount = 0;

                    // Handle white image uploads
                    $(".custom-radio-options-container input[name='option_white_image[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('white_images[]', file);
                                whiteImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('white_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });

                    // Handle black image uploads
                    $(".custom-radio-options-container input[name='option_black_image[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('black_images[]', file);
                                blackImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('black_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });


                     // Handle white image uploads
                    $(".custom-radio-options-container input[name='option_white_image_withHeadboard[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('white_images[]', file);
                                whiteImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('white_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });

                    // Handle black image uploads
                    $(".custom-radio-options-container input[name='option_black_image_withHeadboard[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('black_images[]', file);
                                blackImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('black_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });


                    // Handle slide image uploads
                    $(".slide-options-container input[name='slide_images[]']").each(function(index) {
                        if (this.files && this.files[0]) {
                            let file = this.files[0];
                            formData.append('slide_images[]', file);
                            slideImageCount++;

                            // Track which step and field this image belongs to
                            let stepIndex = $(this).closest('.card').index();
                            let fieldIndex = $(this).closest('.accordion').index();
                            let optionIndex = $(this).closest('.slide-option').index();

                            formData.append('slide_image_locations[]', JSON.stringify({
                                stepIndex: stepIndex,
                                fieldIndex: fieldIndex,
                                optionIndex: optionIndex
                            }));
                        }
                    });

                    // Update white image placeholders to real filenames
                    if (whiteImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if ((field.type === "custom_radio" || field.type ===
                                        "headboard_checkbox" || field.type ===
                                        "canopy_checkbox" || field.type ===
                                        "tray_sides_checkbox") && field.options) {
                                    field.options.forEach(option => {
                                        if (option.whiteImage ===
                                            'white_upload_placeholder') {
                                            option.white_image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                        if (option.whiteImage_withHeadboard ===
                                            'white_upload_placeholder') {
                                            option.white_image_url_withHeadboard =
                                                'new_upload'; // This will be updated on the server
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // Update black image placeholders to real filenames
                    if (blackImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if ((field.type === "custom_radio" || field.type ===
                                        "headboard_checkbox" || field.type ===
                                        "canopy_checkbox" || field.type ===
                                        "tray_sides_checkbox") && field.options) {
                                    field.options.forEach(option => {
                                        if (option.blackImage ===
                                            'black_upload_placeholder') {
                                            option.black_image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                        if (option.blackImage_withHeadboard ===
                                            'black_upload_placeholder') {
                                            option.black_image_url_withHeadboard =
                                                'new_upload';
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // Update slide image placeholders to real filenames
                    if (slideImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if (field.type === "slide_options" && field
                                    .slideOptions) {
                                    field.slideOptions.forEach(option => {
                                        if (option.imageData ===
                                            'slide_upload_placeholder') {
                                            option.image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // Final cleanup and normalization of data before submission
                    if (step.fields) {
                        step.fields.forEach(field => {
                            if ((field.type === "custom_radio" || field.type ===
                                    "canopy_checkbox" || field.type ===
                                    "tray_sides_checkbox") && field.options) {
                                field.options.forEach(option => {
                                    // Ensure numeric values are properly formatted
                                    if (option.price !== undefined && option
                                        .price !== '') {
                                        option.price = parseFloat(option.price) ||
                                            0;
                                    } else {
                                        option.price = 0;
                                    }

                                    // Make sure we're not sending too much redundant data
                                    // If we have an image URL, make sure both URL formats are set correctly
                                    // _withHeadboard
                                    if (option.white_image_url && option
                                        .white_image_url !== 'new_upload') {
                                        option.whiteImage = option.white_image_url;
                                    } else if (option.whiteImage && option
                                        .whiteImage !==
                                        'white_upload_placeholder' && option
                                        .whiteImage !== 'new_upload') {
                                        option.white_image_url = option.whiteImage;
                                    }

                                    if (option.black_image_url && option
                                        .black_image_url !== 'new_upload') {
                                        option.blackImage = option.black_image_url;
                                    } else if (option.blackImage && option
                                        .blackImage !==
                                        'black_upload_placeholder' && option
                                        .blackImage !== 'new_upload') {
                                        option.black_image_url = option.blackImage;
                                    }

                                    // Convert boolean values properly
                                    option.isActive = !!option.isActive;
                                });
                            }

                            if ((field.type === "headboard_checkbox") && field.options) {
                                field.options.forEach(option => {
                                    // Ensure numeric values are properly formatted
                                    if (option.price !== undefined && option
                                        .price !== '') {
                                        option.price = parseFloat(option.price) ||
                                            0;
                                    } else {
                                        option.price = 0;
                                    }

                                    // Make sure we're not sending too much redundant data
                                    // If we have an image URL, make sure both URL formats are set correctly
                                    // _withHeadboard
                                    if (option.white_image_url && option
                                        .white_image_url !== 'new_upload') {
                                        option.whiteImage = option.white_image_url;
                                    } else if (option.whiteImage && option
                                        .whiteImage !==
                                        'white_upload_placeholder' && option
                                        .whiteImage !== 'new_upload') {
                                        option.white_image_url = option.whiteImage;
                                    }

                                    if (option.black_image_url && option
                                        .black_image_url !== 'new_upload') {
                                        option.blackImage = option.black_image_url;
                                    } else if (option.blackImage && option
                                        .blackImage !==
                                        'black_upload_placeholder' && option
                                        .blackImage !== 'new_upload') {
                                        option.black_image_url = option.blackImage;
                                    }

                                    if (option.white_image_url_withHeadboard && option
                                        .white_image_url_withHeadboard !== 'new_upload') {
                                        option.whiteImage = option.white_image_url_withHeadboard;
                                    } else if (option.whiteImage_withHeadboard && option
                                        .whiteImage_withHeadboard !==
                                        'white_upload_placeholder' && option
                                        .whiteImage_withHeadboard !== 'new_upload') {
                                        option.white_image_url_withHeadboard = option.whiteImage_withHeadboard;
                                    }

                                    if (option.black_image_url_withHeadboard && option
                                        .black_image_url_withHeadboard !== 'new_upload') {
                                        option.blackImage_withHeadboard = option.black_image_url_withHeadboard;
                                    } else if (option.blackImage_withHeadboard && option
                                        .blackImage_withHeadboard !==
                                        'black_upload_placeholder' && option
                                        .blackImage_withHeadboard !== 'new_upload') {
                                        option.black_image_url_withHeadboard = option.blackImage_withHeadboard;
                                    }

                                    // Convert boolean values properly
                                    option.isActive = !!option.isActive;
                                });
                            }
                            // Handle slide options data normalization
                            if (field.type === "slide_options" && field.slideOptions) {
                                field.slideOptions.forEach(option => {
                                    // Ensure quantity is a number
                                    if (option.quantity !== undefined && option
                                        .quantity !== '') {
                                        option.quantity = parseInt(option
                                            .quantity) || 1;
                                    } else {
                                        option.quantity = 1;
                                    }

                                    // Handle image data consistency
                                    if (option.image_url && option.image_url !==
                                        'new_upload') {
                                        option.imageData = option.image_url;
                                    } else if (option.imageData && option
                                        .imageData !== 'slide_upload_placeholder' &&
                                        option.imageData !== 'new_upload') {
                                        option.image_url = option.imageData;
                                    }
                                });
                            }
                            // Handle colors data normalization
                            if (field.type === "colors" && field.colors) {
                                field.colors.forEach(color => {
                                    // Ensure all required properties exist
                                    if (!color.name) color.name = '';
                                    if (!color.label) color.label = '';
                                    if (!color.image_url) color.image_url = null;
                                    if (!color.imageData) color.imageData = null;

                                    // Ensure consistency between image properties
                                    if (color.image_url && !color.imageData) {
                                        color.imageData = color.image_url;
                                    } else if (color.imageData && !color
                                        .image_url) {
                                        color.image_url = color.imageData;
                                    }
                                });
                            }
                        });
                    }

                    // Re-stringify the steps for sending to the server
                    formData.set('steps', JSON.stringify(step));

                    // // Debug: Log the final steps JSON before sending
                    // // console.log('Final steps JSON before submission:', steps);
                    // // console.log('Stringified steps:', JSON.stringify(steps));

                    // // Specifically log template values for each step
                    // steps.forEach((step, index) => {
                    //     // console.log(
                    //         `Step ${index+1} (${step.id}): Template value = "${step.template}"`);
                    // });

                    await $.ajax({
                        url: "{{ route('forms.update', $form->id) }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            // Show loading indicator
                            /*Swal.fire({
                                title: 'Saving steps ',
                                html: 'Please wait while the form is being updated.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });*/
                        },
                        success: function(response) {
                            // // console.log('Success Response:', response);
                            /*Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Step ' + (index + 1) + ' updated successfully!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {});*/


                            $('#edit-progress-bar').css('width', (((index + 1) / steps
                                .length) * 100) + '%');
                            $('#edit-progress-bar').attr('aria-valuenow', (((index + 1) /
                                steps.length) * 100));

                            $('#edit-progress-bar').text(Math.round((((index + 1) / steps
                                .length) * 100)) + '%');

                            //$('#save-message').text('Saving...');


                            if (((index + 1) / steps.length) * 100 == 100) {

                                $('#save-message').text('Saved!');
                                setTimeout(() => {
                                    /*Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Updated successfully!',
                                    showConfirmButton: false,
                                    timer: 2000
                                    });*/
                                    $('#edit-progress-bar').css('width', '0%');
                                    $('#edit-progress-bar').attr('aria-valuenow',
                                        "0");
                                    $('.progress-outer').hide();
                                }, 2000);


                            }

                        },
                        error: function(xhr) {
                            console.error('Error Response:', xhr);
                            console.error('Response JSON:', xhr.responseJSON);
                            console.error('Response Text:', xhr.responseText);

                            let errorMessage = 'An error occurred while updating the form.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage += '\n' + Object.values(xhr.responseJSON
                                        .errors).flat()
                                    .join('\n');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                                customClass: {
                                    content: 'text-left'
                                }
                            });
                        }
                    });

                }
            });

            // Handle form submit
            $("#saveForm").click(function(e) {
                e.preventDefault();

                // Make sure to update the steps JSON before submitting
                updateStepJSON();

                // Log the current state of steps
                // // console.log("Submitting form with steps:", steps);

                // Ensure hidden steps input is updated with the current steps JSON
                $("#stepsInput").val(JSON.stringify(steps));

                // Submit the form
                $("#formBuilder").submit();
            });

            // Apply phone number mask (Example: (123) 456-7890)
            $(document).on('focus', '.phone-mask', function() {
                $(this).inputmask("(999) 999-9999");
            });

            // Apply email mask (Ensures valid email format)
            $(document).on('focus', '.email-mask', function() {
                $(this).inputmask({
                    alias: "email"
                });
            });

            // Handle adding new color option (moved outside field type change handler)
            // Keep a unique counter for Dropzone element IDs
            let colorDropzoneCounter = 1000;

            // Handle adding new color option (with Dropzone)
            // $(document).on('click', '.add-color-option', function() {
            //     const dzId = 'dropzone-color-new-' + colorDropzoneCounter++;
            //     const newColorOption = `
            //     <div class="color-option mb-2">
            //         <div class="d-flex align-items-center gap-2 flex-wrap">
            //             <input type="text" class="form-control field-input" name="color_names[]" placeholder="Color name">
            //             <input type="text" class="form-control field-input" name="color_labels[]" placeholder="Display label">

            //             <!-- Dropzone area -->
            //             <div class="dropzone dz-color-upload" id="${dzId}"></div>

            //             <input type="text" class="color-image-data" name="color_image_data[]">
            //             <div class="image-preview" style="max-width: 50px; display:none"></div>

            //             <button type="button" class="btn btn-danger btn-sm remove-color"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
            //         </div>
            //     </div>`;

            //     const $container = $(this).closest('.mb-3').find('.color-options-container');
            //     $container.append(newColorOption);

            //     // Initialize Dropzone for the new color option
            //     setTimeout(() => {
            //         initColorDropzoneById(dzId);
            //     }, 50);

            //     updateStepJSON();
            // });

            function initColorDropzoneById(dzId) {
                const dropzoneEl = document.getElementById(dzId);
                if (!dropzoneEl) return;

                // Prevent duplicate instances
                if (Dropzone.instances.some(dz => dz.element.id === dzId)) {
                    Dropzone.instances.find(dz => dz.element.id === dzId).destroy();
                }

                new Dropzone(`#${dzId}`, {
                    url: '/back/upload/color-image',
                    maxFiles: 1,
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    dictDefaultMessage: 'Drop image here or click to upload',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    success: function(file, response) {
                        const wrapper = dropzoneEl.closest('.color-option');
                        const hiddenInput = wrapper.querySelector('.color-image-data');
                        const previewDiv = wrapper.querySelector('.image-preview');

                        if (response.path) {
                            hiddenInput.value = response.path;
                            previewDiv.innerHTML =
                                `<img src="/${response.path}" class="img-fluid rounded">`;
                        }
                        updateStepJSON();
                    }
                });
            }


            // Handle removing color option (moved outside field type change handler)
            $(document).on('click', '.remove-color', function() {
                $(this).closest('.color-option').remove();
                updateStepJSON();
            });

            // Handle color image changes (moved outside field type change handler)
            $(document).on('change', 'input[name="color_images[]"]', function(e) {
                const file = e.target.files[0];
                const $colorOption = $(this).closest('.color-option');
                const $imagePreview = $colorOption.find('.image-preview');
                const $imageData = $colorOption.find('.color-image-data');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const base64String = e.target.result;
                        if (!$imageData.val() || $imageData.val() === 'upload_placeholder') {
                            $imageData.val('upload_placeholder');
                        }
                        $imagePreview.html(`<img src="${base64String}" class="img-fluid rounded">`);
                        updateStepJSON();
                    };
                    reader.readAsDataURL(file);
                } else {
                    if ($imageData.val() === 'upload_placeholder') {
                        $imageData.val('');
                    }
                    $imagePreview.empty();
                    updateStepJSON();
                }
            });

            // Add this new function to handle adding custom radio options
            // Add this new function to handle adding custom radio options
            function addCustomRadioOption($container, fieldId, optionIndex) {

                // console.log("$container: ", $container);
                 // console.log("fieldId: ", fieldId);
                  // console.log("optionIndex: ", optionIndex);
                const optionId = `option-${fieldId}-${optionIndex}`;
                const newOption = `
                <div class="custom-radio-option mb-2 p-2 border rounded" id="${optionId}" data-field-id="${fieldId}">
                    <div class="m-2">
                        <div class="">
                            <label class="form-label">Option Label</label>
                            <input type="text" class="form-control field-input w-full" name="option_labels[]" placeholder="Option label">
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Option Text</label>
                            <input type="text" class="form-control field-input w-full" name="option_texts[]" placeholder="Option text">
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Option Length</label>
                            <input type="text" class="form-control field-input w-full" name="option_lengths[]" placeholder="Length">
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Option Fitment Time</label>
                            <input type="text" class="form-control field-input w-full" name="option_times[]" placeholder="fitment_time">
                        </div>

                        <div class="d-flex p-2 flex-column car-size-field-main">
                            <label class="form-label fw-bold">Price</label>
                            <div class="d-flex gap-2 car-size-field-outer">
                                <div class="d-flex flex-column car-size-field-form">
                                    <label class="form-label">Mid Sized</label>
                                    <input type="number" class="form-control field-input" name="option_mid_sized[]" placeholder="price">
                                </div>
                                <div class="d-flex flex-column car-size-field-form">
                                    <label class="form-label">Toyota 79</label>
                                    <input type="number" class="form-control field-input" name="option_toyota_79[]" placeholder="price">
                                </div>
                                <div class="d-flex flex-column car-size-field-form">
                                    <label class="form-label">USA Truck</label>
                                    <input type="number" class="form-control field-input" name="option_usa_truck[]" placeholder="price">
                                </div>
                            </div>
                        </div>
                        <div class="form-check w-100 m-2 ">

                            <div class="create-form-checkbox reminder-con">
                                <label class="custom-checkbox">
                                        
                                        <input type="checkbox" class="form-check-input field-input m-1" name="option_active[]">
                                    <span class="checkmark"></span> <span class="remember-text">Active</span>
                                </label>
                            </div>


                          
                        </div>

                    <div class="upload-images-main"> 
                        <div class="d-flex flex-column upload-images-con">
                            <label class="form-label">White without Headboard Image</label>
                            <!-- Dropzone container for white image -->
                            <div id="white-image-dropzone-${optionId}" class="dropzone">
                                <div class="dz-message">
                                    Drop image here or click to upload.
                                </div>
                            </div>
                            <input type="hidden" class="white-image-data" name="white_image_url[]">
                            <div class="white-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                        </div>

                        <div class="d-flex flex-column upload-images-con">
                            <label class="form-label">Black without Headboard Image</label>
                            <!-- Dropzone container for black image -->
                            <div id="black-image-dropzone-${optionId}" class="dropzone">
                                <div class="dz-message">
                                    Drop image here or click to upload.
                                </div>
                            </div>
                            <input type="hidden" class="black-image-data" name="black_image_url[]">
                            <div class="black-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                        </div>

                        <div class="d-flex flex-column upload-images-con">
                            <label class="form-label">White with Headboard Image</label>
                            <!-- Dropzone container for white image -->
                            <div id="white-image-dropzone-with-headboard-${optionId}" class="dropzone">
                                <div class="dz-message">
                                    Drop image here or click to upload.
                                </div>
                            </div>
                            <input type="hidden" class="white-image-data-with-headboard" name="white_image_url_withHeadboard[]">
                            <div class="white-image-preview-with-headboard mt-2" style="max-width: 100px; display:none;"></div>
                        </div>

                        <div class="d-flex flex-column upload-images-con">
                            <label class="form-label">Black with Headboard Image</label>
                            <!-- Dropzone container for black image -->
                            <div id="black-image-dropzone-with-headboard-${optionId}" class="dropzone">
                                <div class="dz-message">
                                    Drop image here or click to upload.
                                </div>
                            </div>
                            <input type="hidden" class="black-image-datawith-headboard" name="black_image_url_withHeadboard[]">
                            <div class="black-image-previewwith-headboard mt-2" style="max-width: 100px; display:none;"></div>
                        </div>
                    </div>
                        <button type="button" class="btn btn-danger btn-sm custom-radio-remove-btn" data-option-id="${optionId}"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                    </div>
                </div>`;



                $container.append(newOption);



                // Add specific event handlers for this option's images
                $(`#${optionId} .white-image-input`).off('change').on('change', function(e) {
                    handleCustomRadioImageUpload($(this), 'white');
                });

                $(`#${optionId} .black-image-input`).off('change').on('change', function(e) {
                    handleCustomRadioImageUpload($(this), 'black');
                });

                // Add remove handler
                $(`#${optionId} .custom-radio-remove-btn`).off('click').on('click', function(e) {
                    e.stopPropagation(); // Prevent event bubbling
                    $(`#${optionId}`).remove();
                    updateStepJSON();
                });

                setTimeout(function() {
                    // Initialize Dropzone for white image if not already initialized
                    if($(`#white-image-dropzone-${optionId}`).length > 0) {
                        const whiteDropzone = document.getElementById(`white-image-dropzone-${optionId}`);
                        if (!whiteDropzone.dropzone) {
                            new Dropzone(`#white-image-dropzone-${optionId}`, {
                                url: "/back/upload/white-image",
                                paramName: "file",
                                maxFilesize: 5,
                                maxFiles: 1,
                                acceptedFiles: "image/*",
                                dictDefaultMessage: "Drop image here or click to upload.",
                                dictRemoveFile: "Remove",
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                init: function() {
                                    this.on("success", function(file, response) {
                                        const whiteImagePath = response.path;
                                        $(`#${optionId} .white-image-data`).val(
                                            whiteImagePath);
                                        $(`#${optionId} .white-image-preview`).html(
                                            `<img src="${whiteImagePath}" alt="White Image" style="max-width: 100px;">`
                                            );

                                        updateStepJSON();
                                        // // console.log("updated by dropzone");

                                    });
                                }
                            });
                        }
                    }
                    if($(`#black-image-dropzone-${optionId}`).length > 0) {
                        // Initialize Dropzone for black image if not already initialized
                        const blackDropzone = document.getElementById(`black-image-dropzone-${optionId}`);
                        if (!blackDropzone.dropzone) {
                            new Dropzone(`#black-image-dropzone-${optionId}`, {
                                url: "/back/upload/black-image",
                                paramName: "file",
                                maxFilesize: 5,
                                maxFiles: 1,
                                acceptedFiles: "image/*",
                                dictDefaultMessage: "Drop image here or click to upload.",
                                dictRemoveFile: "Remove",
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                init: function() {
                                    this.on("success", function(file, response) {
                                        const blackImagePath = response.path;
                                        $(`#${optionId} .black-image-data`).val(
                                            blackImagePath);
                                        $(`#${optionId} .black-image-preview`).html(
                                            `<img src="${blackImagePath}" alt="Black Image" style="max-width: 100px;">`
                                            );

                                        updateStepJSON();
                                        // console.log("updated by dropzone");
                                    });
                                }
                            });
                        }

                    }
                    if($(`#white-image-dropzone-with-headboard-${optionId}`).length > 0) {
                        const whiteDropzone_withHeadboard = document.getElementById(`white-image-dropzone-with-headboard-${optionId}`);
                        if (!whiteDropzone_withHeadboard.dropzone) {
                            new Dropzone(`#white-image-dropzone-with-headboard-${optionId}`, {
                                url: "/back/upload/white-image",
                                paramName: "file",
                                maxFilesize: 5,
                                maxFiles: 1,
                                acceptedFiles: "image/*",
                                dictDefaultMessage: "Drop image here or click to upload.",
                                dictRemoveFile: "Remove",
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                init: function() {
                                    this.on("success", function(file, response) {
                                        const whiteImagePath = response.path;
                                        $(`#${optionId} .white-image-data`).val(
                                            whiteImagePath);
                                        $(`#${optionId} .white-image-preview`).html(
                                            `<img src="${whiteImagePath}" alt="White Image" style="max-width: 100px;">`
                                            );

                                        updateStepJSON();
                                        // // console.log("updated by dropzone");

                                    });
                                }
                            });
                        }
                    }
                    if($(`#black-image-dropzone-with-headboard-${optionId}`).length > 0) {
                        const blackDropzone_withHeadboard = document.getElementById(`black-image-dropzone-with-headboard-${optionId}`);
                        if (!blackDropzone_withHeadboard.dropzone) {
                            new Dropzone(`#black-image-dropzone-with-headboard-${optionId}`, {
                                url: "/back/upload/black-image",
                                paramName: "file",
                                maxFilesize: 5,
                                maxFiles: 1,
                                acceptedFiles: "image/*",
                                dictDefaultMessage: "Drop image here or click to upload.",
                                dictRemoveFile: "Remove",
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                init: function() {
                                    this.on("success", function(file, response) {
                                        const blackImagePath = response.path;
                                        $(`#${optionId} .black-image-data`).val(
                                            blackImagePath);
                                        $(`#${optionId} .black-image-preview`).html(
                                            `<img src="${blackImagePath}" alt="Black Image" style="max-width: 100px;">`
                                            );

                                        updateStepJSON();
                                        // console.log("updated by dropzone");
                                    });
                                }
                            });
                        }
                    }
                }, 100); // Timeout to ensure DOM has updated

                // console.log(`Initializing Dropzone for ${optionId}`);

            }

            function addHeadboardOption($container, fieldId, optionIndex) {
                const optionId = `option-${fieldId}-${optionIndex}`;
                const newOption = `
                <div class="custom-radio-option mb-2 p-2 border rounded" id="${optionId}" data-field-id="${fieldId}">
                    <div class="m-2">
                        <div class="">
                            <label class="form-label">Option Label</label>
                            <input type="text" class="form-control field-input w-full" name="option_labels[]" placeholder="Option label">
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Option Text</label>
                            <input type="text" class="form-control field-input w-full" name="option_texts[]" placeholder="Option text">
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Option Length</label>
                            <input type="text" class="form-control field-input w-full" name="option_lengths[]" placeholder="Length">
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Option Fitment Time</label>
                            <input type="text" class="form-control field-input w-full" name="option_times[]" placeholder="fitment_time">
                        </div>

                        <div class="d-flex p-2 flex-column car-size-field-main" >
                            <label class="form-label fw-bold">Price</label>
                            <div class="d-flex gap-2 car-size-field-outer">
                                <div class="d-flex flex-column car-size-field-form">
                                    <label class="form-label">Mid Sized</label>
                                    <input type="number" class="form-control field-input" name="option_mid_sized[]" placeholder="price">
                                </div>
                                <div class="d-flex flex-column car-size-field-form">
                                    <label class="form-label">Toyota 79</label>
                                    <input type="number" class="form-control field-input" name="option_toyota_79[]" placeholder="price">
                                </div>
                                <div class="d-flex flex-column car-size-field-form">
                                    <label class="form-label">USA Truck</label>
                                    <input type="number" class="form-control field-input" name="option_usa_truck[]" placeholder="price">
                                </div>
                            </div>
                        </div>
                        <div class="form-check w-100 m-2 ">

                            <div class="create-form-checkbox reminder-con">
                                <label class="custom-checkbox">
                                        
                                        <input type="checkbox" class="form-check-input field-input m-1" name="option_active[]">
                                    <span class="checkmark"></span> <span class="remember-text">Active</span>
                                </label>
                            </div>


                           
                        </div>

                        <div class="upload-images-main"> 
                       <div class="d-flex flex-column upload-images-con">
                            <label class="form-label ">White Image</label>
                            <!-- Dropzone container for white image -->
                            <div id="white-image-dropzone-${optionId}" class="dropzone">
                                <div class="dz-message">
                                    Drop image here or click to upload.
                                </div>
                            </div>
                            <input type="hidden" class="white-image-data" name="white_image_url[]">
                            <div class="white-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                        </div>

                        <div class="d-flex flex-column upload-images-con">
                            <label class="form-label">Black Image</label>
                            <!-- Dropzone container for black image -->
                            <div id="black-image-dropzone-${optionId}" class="dropzone">
                                <div class="dz-message">
                                    Drop image here or click to upload.
                                </div>
                            </div>
                            <input type="hidden" class="black-image-data" name="black_image_url[]">
                            <div class="black-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                        </div>
                        </div>

                        <button type="button" class="btn btn-danger btn-sm custom-radio-remove-btn" data-option-id="${optionId}"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                    </div>
                </div>`;



                $container.append(newOption);



                // Add specific event handlers for this option's images
                $(`#${optionId} .white-image-input`).off('change').on('change', function(e) {
                    handleCustomRadioImageUpload($(this), 'white');
                });

                $(`#${optionId} .black-image-input`).off('change').on('change', function(e) {
                    handleCustomRadioImageUpload($(this), 'black');
                });

                // Add remove handler
                $(`#${optionId} .custom-radio-remove-btn`).off('click').on('click', function(e) {
                    e.stopPropagation(); // Prevent event bubbling
                    $(`#${optionId}`).remove();
                    updateStepJSON();
                });

                setTimeout(function() {
                    // Initialize Dropzone for white image if not already initialized
                    if($(`#white-image-dropzone-${optionId}`).length > 0) {
                        const whiteDropzone = document.getElementById(`white-image-dropzone-${optionId}`);
                        if (!whiteDropzone.dropzone) {
                            new Dropzone(`#white-image-dropzone-${optionId}`, {
                                url: "/back/upload/white-image",
                                paramName: "file",
                                maxFilesize: 5,
                                maxFiles: 1,
                                acceptedFiles: "image/*",
                                dictDefaultMessage: "Drop image here or click to upload.",
                                dictRemoveFile: "Remove",
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                init: function() {
                                    this.on("success", function(file, response) {
                                        const whiteImagePath = response.path;
                                        $(`#${optionId} .white-image-data`).val(
                                            whiteImagePath);
                                        $(`#${optionId} .white-image-preview`).html(
                                            `<img src="${whiteImagePath}" alt="White Image" style="max-width: 100px;">`
                                            );

                                        updateStepJSON();
                                        // console.log("updated by dropzone");

                                    });
                                }
                            });
                        }
                    }

                     if($(`#black-image-dropzone-${optionId}`).length > 0) {
                        // Initialize Dropzone for black image if not already initialized
                        const blackDropzone = document.getElementById(`black-image-dropzone-${optionId}`);
                        if (!blackDropzone.dropzone) {
                            new Dropzone(`#black-image-dropzone-${optionId}`, {
                                url: "/back/upload/black-image",
                                paramName: "file",
                                maxFilesize: 5,
                                maxFiles: 1,
                                acceptedFiles: "image/*",
                                dictDefaultMessage: "Drop image here or click to upload.",
                                dictRemoveFile: "Remove",
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                init: function() {
                                    this.on("success", function(file, response) {
                                        const blackImagePath = response.path;
                                        $(`#${optionId} .black-image-data`).val(
                                            blackImagePath);
                                        $(`#${optionId} .black-image-preview`).html(
                                            `<img src="${blackImagePath}" alt="Black Image" style="max-width: 100px;">`
                                            );

                                        updateStepJSON();
                                        // console.log("updated by dropzone");
                                    });
                                }
                            });
                        }
                     }
                }, 100); // Timeout to ensure DOM has updated

                // console.log(`Initializing Dropzone for ${optionId}`);

            }


            // Add this helper function for handling image uploads
            function handleCustomRadioImageUpload($input, imageType) {
                const file = $input[0].files[0];
                const $option = $input.closest('.custom-radio-option');
                const $imageData = $option.find(`.${imageType}-image-data`);
                const $preview = $option.find(`.${imageType}-image-preview`);

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const base64String = e.target.result;
                        $imageData.val(`${imageType}_upload_placeholder`);
                        $preview.html(`<img src="${base64String}" class="img-fluid rounded">`);
                        updateStepJSON();
                    };
                    reader.readAsDataURL(file);
                } else {
                    const currentImageUrl = $preview.find('img').attr('src');
                    if (currentImageUrl && !currentImageUrl.startsWith('data:')) {
                        // Keep existing image, don't change anything
                    } else {
                        $imageData.val('');
                        $preview.empty();
                    }
                    updateStepJSON();
                }
            }
        });


        function addNewAutomation(id, options) {
            $.ajax({
                url: `/back/recipes/getRecipe/${id}`,
                type: 'GET',
                success: function(recipe) {
                    // // console.log(recipe);
                    if (!recipe || !recipe.code) {
                        console.error("Recipe not found or invalid response");
                        return;
                    }

                    let automationIndex = $(".automation-item").length;
                    let recipeCode = recipe.code.replace(/\[\[id\]\]/g, automationIndex);

                    let logicHtml =
                        `<div class="logic-${automationIndex}" data-recipe=${recipe.id} data-parameters="${recipe.no_of_parameters}">${recipeCode}</div>`;
                    $('#logic-container').append(logicHtml);

                    if (recipe.title === 'make_model_dependancy') {
                        $(`.logic-${automationIndex}`).find('select.parameter-1').append(
                            options.makeOptions);
                        $(`.logic-${automationIndex}`).find('select.parameter-2').append(
                            options.modelOptions);
                    } else if (recipe.title === 'model_year_dependancy') {
                        $(`.logic-${automationIndex}`).find('select.parameter-1').append(
                            options.modelOptions);
                        $(`.logic-${automationIndex}`).find('select.parameter-2').append(
                            options.yearOptions);
                    } else if (recipe.title === 'selective_field_change') {
                        $(`.logic-${automationIndex}`).find('select.parameter-1').append(
                            options.allOptions);
                        $(`.logic-${automationIndex}`).find('select.parameter-4').append(
                            options.allOptions);
                    } else if (recipe.title === 'show_hide_step') {
                        $(`.logic-${automationIndex}`).find('select.parameter-1').append(
                            options.allOptions);
                        $(`.logic-${automationIndex}`).find('select.parameter-4').append(
                            options.stepOptions);
                    } else if (recipe.title === 'length_dependancy') {
                        $(`.logic-${automationIndex}`).find('select.parameter-1').append(
                            options.canopy_radioOptions);
                        $(`.logic-${automationIndex}`).find('select.parameter-2').append(
                            options.productsOptions);
                    } else if (recipe.title === 'show_notice_external') {
                        $(`.logic-${automationIndex}`).find('select.parameter-3').append(
                            options.productNames);
                    } else if (recipe.title === 'show_hide_external') {
                        $(`.logic-${automationIndex}`).find('select.parameter-4').append(
                            options.productNames);
                    } else if (recipe.title === 'show_hide_internal') {
                        $(`.logic-${automationIndex}`).find('select.parameter-4').append(
                            options.productNames);
                    }

                },
                error: function(xhr) {
                    console.error("Error fetching recipes:", xhr);
                }
            });
        }


        $(document).ready(function() {
            var forms = {!! json_encode($form) !!};
            var recipes = {!! json_encode($recipes) !!};
            var logics = {!! json_encode($logics) !!};
            var formSteps = forms.steps;
            let currentSchema = [];

            // Load logics via AJAX when page loads
            loadLogics();

            function loadLogics() {
                $.ajax({
                    type: "GET",
                    url: `/back/form/logics/${forms.id}`,
                    dataType: "json",
                    success: function(response) {
                        // Clear existing logic container if needed
                        $("#logic-container").empty();

                        if (response && response.length > 0) {
                            // Populate logic container with retrieved logics
                            response.forEach(function(logic, index) {
                                if (logic.recipe && logic.recipe.code) {
                                    let recipeCode = logic.recipe.code.replace(/\[\[id\]\]/g,
                                        index);
                                    let logicHtml =
                                        `<div class="logic-${index}" data-recipe="${logic.recipe.id}" data-parameters="${logic.recipe.no_of_parameters}" data-logic-id="${logic.id}">${recipeCode}</div>`;
                                    $('#logic-container').append(logicHtml);

                                    // Populate the select fields with the right options
                                    if (logic.recipe.title === 'make_model_dependancy') {
                                        $(`.logic-${index}`).find('select.parameter-1').append(
                                            options.makeOptions);
                                        $(`.logic-${index}`).find('select.parameter-2').append(
                                            options.modelOptions);
                                    } else if (logic.recipe.title === 'model_year_dependancy') {
                                        $(`.logic-${index}`).find('select.parameter-1').append(
                                            options.modelOptions);
                                        $(`.logic-${index}`).find('select.parameter-2').append(
                                            options.yearOptions);
                                    } else if (logic.recipe.title ===
                                        'selective_field_change') {
                                        $(`.logic-${index}`).find('select.parameter-1').append(
                                            options.allOptions);
                                        $(`.logic-${index}`).find('select.parameter-4').append(
                                            options.allOptions);
                                    } else if (logic.recipe.title === 'show_hide_step') {
                                        $(`.logic-${index}`).find('select.parameter-1').append(
                                            options.allOptions);
                                        $(`.logic-${index}`).find('select.parameter-4').append(
                                            options.stepOptions);
                                    } else if (logic.recipe.title === 'length_dependancy') {
                                        $(`.logic-${index}`).find('select.parameter-1').append(
                                            options.canopy_radioOptions);
                                        $(`.logic-${index}`).find('select.parameter-2').append(
                                            options.productsOptions);
                                    } else if (logic.recipe.title === 'show_notice_external') {
                                        $(`.logic-${index}`).find('select.parameter-3').append(
                                            options.productNames);
                                    } else if (logic.recipe.title === 'show_hide_external') {
                                        $(`.logic-${index}`).find('select.parameter-4').append(
                                            options.productNames);
                                    } else if (logic.recipe.title === 'show_hide_internal') {
                                        $(`.logic-${index}`).find('select.parameter-4').append(
                                            options.productNames);
                                    }

                                    // Set saved parameter values if they exist
                                    if (logic.parameters) {
                                        Object.keys(logic.parameters).forEach(function(
                                            paramKey) {
                                            $(`.logic-${index}`).find(
                                                `.parameter-${paramKey}`).val(logic
                                                .parameters[paramKey]);
                                        });
                                    }
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error loading logics:", xhr);
                    }
                });
            }

            formSteps.forEach(step => {
                if (step.fields && Array.isArray(step.fields)) {
                    step.fields.forEach(field => {
                        currentSchema.push({
                            id: field.id,
                            type: field.type,
                            required: field.required,
                            label: field.label,
                            name: field.id // Assigning id as name for reference
                        });
                    });
                }
            });

            const types = [...new Set(currentSchema.map(schema => schema.type))];
            // // console.log(types);
            const options = []; // Store options dynamically

            let stepOptions = formSteps
                .filter(step => step.id && step.title) // Ensure both id and title exist
                .map(step => `<option value="${step.id}">${step.title} (${step.id})</option>`)
                .join('');


            let fieldOptions = currentSchema.filter(field => field.name)
                .map(field => `<option value="${field.name}">${field.label} (${field.id})</option>`).join('');

            let productOptionNames = allProducts.filter(product => product.name)
                .map(product => `<option value="${product.name}">${product.name}</option>`).join('');


            types.forEach(type => {
                options[`${type}Options`] = currentSchema
                    .filter(field => field.type === type)
                    .map(field => `<option value="${field.name}">${field.label} (${field.id})</option>`)
                    .join('');
            });
            // // console.log(options);

            options.allOptions = fieldOptions;
            options.stepOptions = stepOptions;
            options.productNames = productOptionNames;
            // options.custom_radio_options = custom_radio_options;
            // // console.log(options.custom_radio_options);
            // // console.log(options.modelOptions);
            // // console.log(options.yearOptions);
            // // console.log(options.productNames);


            // Remove automation
            $(document).on("click", ".remove-automation", function() {
                $(this).closest(".automation-item").remove();
            });

            // Show the automation type modal when Add Automation button is clicked
            $("#add-automation").click(function() {
                $('#automationTypeModal').modal('show');
            });

            // Make entire card clickable
            $(".automation-type-card").click(function(e) {
                const automationType = $(this).data('type');
                const automationId = $(this).data('id');
                $('#automationTypeModal').modal('hide');
                addNewAutomation(automationId, options);
            });

            // Handle button click within card
            $(".automation-type").click(function(e) {
                e.stopPropagation(); // Prevent double triggering from card click
                const automationType = $(this).data('type');
                const automationId = $(this).data('id');
                $('#automationTypeModal').modal('hide');
                addNewAutomation(automationId, options);
            });


            // // console.log(".logic-" + automationIndex + " .automation-item .parameter-1");


            var fullLogicJson = [];

            $("body").on("change", ".paraSelect", function() {
                var $this = $(this);
                var automationIndex = $(".automation-item").length;

                var allLogicJson = []; // Array to store all logicJson objects


                // Loop over each automation item
                for (var index = 0; index < automationIndex; index++) {

                    var logicContainer = $(".logic-" + index);

                    if (!logicContainer.length) {
                        console.error("Logic container not found!");
                        return;
                    }

                    var recipe_id = logicContainer.data("recipe");
                    var form_id = forms.id;
                    var parameters = logicContainer.data("parameters");
                    var logic_id = '';

                    var logicJson = { // Initialize the logicJson for each automation item
                        id: logic_id,
                        recipe_id: recipe_id,
                        form_id: form_id,
                        parameters: {} // Use an object for parameters to store key-value pairs
                    };

                    // Loop over the parameters and collect their values
                    for (var j = 1; j <= parameters; j++) {
                        // Use 'logicContainer' to ensure parameter is found within that container
                        var parameterValue = logicContainer.find('.parameter-' + j).val();

                        if (parameterValue !== undefined) {
                            // Add the parameter index as key and its value as the value
                            logicJson.parameters[j] = parameterValue;
                            // // console.log("Added parameter " + j + " value:", parameterValue);
                        }
                    }

                    // Add the current logicJson to the allLogicJson array
                    allLogicJson.push(logicJson);
                }

                // After all the iterations, send the combined allLogicJson to the server
                // // console.log("Combined LogicJson to send:", JSON.stringify(allLogicJson, null, 2));
                fullLogicJson = allLogicJson;
            });


            $('body').on('click', '#logic-form-save', function(e) {
                e.preventDefault();

                // Collect logic data from all logic containers
                var allLogicJson = [];
                var logicContainers = $(
                    "[class^='logic-']"); // Find all elements with class starting with 'logic-'

                logicContainers.each(function(index) {
                    var $logicContainer = $(this);
                    var recipe_id = $logicContainer.data("recipe");
                    var form_id = forms.id;
                    var parameters = $logicContainer.data("parameters");
                    var logic_id = $logicContainer.data("logic-id") || '';

                    // Skip if recipe_id is missing
                    if (!recipe_id) {
                        return true; // continue to next iteration
                    }

                    var logicJson = {
                        id: logic_id,
                        recipe_id: recipe_id,
                        form_id: form_id,
                        parameters: {}
                    };

                    // Track if we found any valid parameters
                    var hasParameters = false;

                    // Collect all parameter values
                    for (var j = 1; j <= parameters; j++) {
                        var parameterValue = $logicContainer.find('.parameter-' + j).val();
                        if (parameterValue !== undefined && parameterValue !== '') {
                            logicJson.parameters[j] = parameterValue;
                            hasParameters = true;
                        }
                    }

                    // Only add this logic if it has parameters
                    if (hasParameters) {
                        allLogicJson.push(logicJson);
                    }
                });

                // // Don't send request if no valid logics
                // if (allLogicJson.length === 0) {
                //     Swal.fire({
                //         icon: 'warning',
                //         title: 'No Logic Rules',
                //         text: 'No valid logic rules found to save.',
                //     });
                //     return;
                // }

                // Save all logics to server
                $.ajax({
                    type: "POST",
                    url: "{{ route('logics.storeOrUpdate') }}?form_id={{ $form->id }}",
                    data: JSON.stringify(allLogicJson),
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // // console.log("Logics saved successfully:", response);
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Logic rules saved successfully!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        // Reload logics to refresh the UI
                        loadLogics();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error saving logics:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to save logic rules. Please try again.',
                        });
                    }
                });
            });



            function triggerPublish(formId) {
                $.ajax({
                    url: `/back/forms/${formId}/publish`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {});
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to publish form'
                        });
                    }
                });
            }

            $("#saveAndPublish").on("click", function(e) {
                e.preventDefault();

                const formId = $(this).data('id');
                // // console.log('Form ID:', formId);

                $("#saveFormBtn").trigger("click");
                $("#logic-form-save").trigger("click");

                setTimeout(() => {
                    triggerPublish(formId); // Directly call publish function
                }, 1000);
            });

            $('body').on('click', '.edit-field-btn', function(){
                var target = $(this).attr('data-target');
                $('.edit-field').hide();
                // console.log(target);
                $(target).show();
              console.log(target);
                    $('html, body').animate({
                        scrollTop: $(target).offset().top - 112
                    }, 300);
                /*$('html, body').animate({
                    scrollTop: $('.field-container').offset().top
                }, 300);*/
            });

            $('body').on('click', '.remove-field-btn', function(){
                var $this = this;
                $($(this).attr('data-target')).remove();
                $($this).parent().parent().remove();
                 updateStepJSON();
            });
            $('body').on('click', '.edit-field .close-acc', function(){
                $(this).parent().parent().hide();
            })
            $('body').on('click', '.new-entry .close-acc', function(){

                $('.new-entry').html('');
            });

            $('body').on('click', '.saveToFields', function(){
                var $this = $(this);
                var html = $('.new-entry').clone().html();
                var stepID = $this.closest('.tab-content').attr('id');
                // console.log(stepID);
                //html.replace(/(<\w+)([^>]*>)/, '$1 style="display:none"$2');
                
                var fieldId = $('.new-entry input[name="fieldId"]').val();
                var label = $('.new-entry input[name="label"]').val();
                //html = html.replace("Add Field", label);
                //$this.closest('.tab-content').find('.field-container').append(html);
                

                var sortHtml = `<div class="extra-add mb-2" data-id="${fieldId}">
                                    <span class="extra-add-span">${label}</span>
                                    <span class="extra-add-span2" >${fieldId}</span>
                                    <div class="extra-icon">
                                        <a href="javascript:void(0);" data-id="${fieldId}" class="edit-field-btn" data-target="#accordion-${fieldId}"><img src="{{asset('images') }}/edit-aarow.svg" alt="icon"></a>
                                        <a href="javascript:void(0);" data-id="${fieldId}" class="remove-field-btn" data-target="#accordion-${fieldId}"><img src="{{asset('images') }}/dele.svg" alt="icon"></a>
                                    </div>
                                </div>`;
                $this.closest('.tab-content').find('.extr-field').append(sortHtml);

                updateStepJSON();
                $('.new-entry').html('');
                


                                stepCount = 0;
                                if (steps && steps.length > 0) {
                                    steps.forEach(function(step) {
                                        if(step.id === stepID) {
                                            
                                    
                                            stepCount++;
                                            let stepId = step.id || `step-${stepCount}`;
                                            let contentId = `content-${stepCount}`;
                                            let templateValue = step.template || '1'; // Default to template 1 if not specified

                                            // // console.log(`Initializing step ${stepCount} with template: ${templateValue}`);

                                            
                                                $(`#${stepId}`).find(".field-container").html('');
                                            // Add existing fields
                                            if (step.fields && step.fields.length > 0) {
                                                step.fields.forEach(function(field) {
                                                    // Keep the original field ID instead of incrementing fieldCount
                                                    let fieldId = field.id;
                                                    // Only increment fieldCount if we're creating a new ID
                                                    if (!fieldId) {
                                                        fieldCount++;
                                                        fieldId = `field-${fieldCount}`;
                                                    }
                                                    let stepCard = $(`#${stepId}`);
                                                        
                                                    let fieldTemplate = `

                                                    <div class="addfield-inner edit-field" id="accordion-${fieldId}" style="display:none;">
                                                    <div class="nav-heading">
                                                        <p>${field.label}</p>
                                                    </div>
                                                    <div class="add-inner">
                                                        <div class="close-acc"></div>
                                                        <form>
                                                            <label class="form-label">Field Type</label>
                                                            <select class="form-select field-type-select">
                                                                ${Object.entries(fieldTypes).map(([type, config]) =>
                                                                    `<option value="${type}" ${field.type === type ? 'selected' : ''}>${config.label}</option>`
                                                                ).join('')}
                                                            </select>
                                                            <label class="form-label me-2">Field Id:</label>
                                                            <input type="text" class="form-control" name="fieldId" value= '${fieldId}' readonly> 
                                                            <div class="field-options">
                                                                        <!-- Field type specific options will be loaded here -->
                                                                    </div>
                                                            <div class="back-btn-wrap">
                                                                <a href="javascript:void(0);" class="save-edit-field"><img src="{{ asset('images') }}/save-file.svg" alt="icon"> Save Field</a>
                                                            </div>
                                                            <button class="btn btn-danger btn-sm removeField mt-2 d-none"  id="remove-${fieldId}">
                                                                        <i class="fa fa-trash"></i> Remove Field
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>


                                                `;

                                                    stepCard.find(".field-container").append(fieldTemplate);

                                                    // Load field type specific options with existing values
                                                    const $fieldOptions = stepCard.find(
                                                        `#accordion-${fieldId} .field-options, #field-${fieldId} .field-options`);
                                                    $fieldOptions.html(fieldTypes[field.type].template);

                                                    // Set existing field values
                                                    Object.keys(field).forEach(function(key) {
                                                        if (key !== 'id' && key !== 'type') {
                                                            // Handle radio options
                                                            if (key === 'options' && field.type === 'radio' && Array
                                                                .isArray(field.options)) {
                                                                // Clear existing default options
                                                                $fieldOptions.find('.radio-options-container')
                                                                    .empty();

                                                                // Add each saved option
                                                                field.options.forEach(function(option) {
                                                                    const newOption = `
                                                                    <div class="radio-option mb-2">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                                            <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text" value="${option.text || ''}">
                                                                            <div class="form-check">

                                                                                    <div class="create-form-checkbox reminder-con">
                                                                                        <label class="custom-checkbox">
                                                                                                
                                                                                               <input type="checkbox" class="form-check-input field-input" name="option_active[]" ${option.isActive ? 'checked' : ''}>
                                                                                            <span class="checkmark"></span> <span class="remember-text">Active</span>
                                                                                        </label>
                                                                                    </div>
                                                                                
                                                                            </div>
                                                                            <button type="button" class="btn btn-sm remove-option"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                                        </div>
                                                                    </div>`;
                                                                    $fieldOptions.find(
                                                                            '.radio-options-container')
                                                                        .append(newOption);
                                                                });
                                                            }
                                                            // Handle custom radio options
                                                            else if (key === 'options' && (field.type ===
                                                                    'custom_radio' || field.type ===
                                                                    'canopy_radio' || field.type ===
                                                                    'tray_sides_radio') && Array.isArray(field
                                                                    .options)) {
                                                                // Clear and set unique ID for container
                                                                const $container = $fieldOptions.find(
                                                                    '.custom-radio-options-container');
                                                                $container.attr('id', `radio-container-${fieldId}`)
                                                                    .attr('data-field-id', fieldId).empty();

                                                                // Add button handler
                                                                const $addButton = $fieldOptions.find(
                                                                    '.add-custom-radio-option');
                                                                $addButton.off('click').on('click', function() {
                                                                    const optionCount = $container
                                                                        .children().length;
                                                                    addCustomRadioOption($container,
                                                                        fieldId, optionCount);
                                                                    updateStepJSON();
                                                                });

                                                                // Add each saved option
                                                                field.options.forEach(function(option, index) {
                                                                    const optionId =
                                                                        `option-${fieldId}-${index}`;
                                                                    const newOption = `
                                                                    <div class="custom-radio-option mb-2 p-2 border rounded" id="${optionId}" data-field-id="${fieldId}">
                                                                        <div class="m-2">
                                                                            <div class="">
                                                                                <label class="form-label">Option Label</label>
                                                                                <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                                            </div>
                                                                            <div class="mt-2">
                                                                                <label class="form-label">Option Text</label>
                                                                                <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text" value="${option.text || ''}">
                                                                            </div>
                                                                            <div class="mt-2">
                                                                                <label class="form-label">Option Length</label>
                                                                                <input type="text" class="form-control field-input" name="option_lengths[]" placeholder="Length" value="${option.length || ''}">
                                                                            </div>
                                                                            <div class="mt-2">
                                                                                <label class="form-label">Option Fitment Time</label>
                                                                                <input type="text" class="form-control field-input" name="option_times[]" placeholder="fitment time" value="${option.fitment_time || ''}">
                                                                            </div>
                                                                            <div class="d-flex p-2 flex-column car-size-field-main">
                                                                                <label class="form-label fw-bold">Price</label>
                                                                                <div class="d-flex gap-2 car-size-field-outer">
                                                                                    <div class="d-flex flex-column car-size-field-form">
                                                                                        <label class="form-label">Mid Sized</label>
                                                                                        <input type="number" class="form-control field-input" name="option_mid_sized[]" placeholder="price" value="${option.mid_sized_price || ''}">
                                                                                    </div>
                                                                                    <div class="d-flex flex-column car-size-field-form">
                                                                                        <label class="form-label">Toyota 79</label>
                                                                                        <input type="number" class="form-control field-input" name="option_toyota_79[]" placeholder="price" value="${option.toyota_79_price || ''}">
                                                                                    </div>
                                                                                    <div class="d-flex flex-column car-size-field-form">
                                                                                        <label class="form-label">USA Truck</label>
                                                                                        <input type="number" class="form-control field-input" name="option_usa_truck[]" placeholder="price" value="${option.usa_truck_price || ''}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-check w-100 m-2">

                                                                                    <div class="create-form-checkbox reminder-con">
                                                                                        <label class="custom-checkbox">
                                                                                                
                                                                                               <input type="checkbox" class="form-check-input field-input m-1" name="option_active[]" ${option.isActive ? 'checked' : ''}>
                                                                                            <span class="checkmark"></span> <span class="remember-text">Active</span>
                                                                                        </label>
                                                                                    </div>



                                                                            
                                                                            </div>




                                                                        <div class="upload-images-main"> 
                                                                            <div class="d-flex flex-column upload-images-con">
                                                                                <label class="form-label">White without Headboard Image</label>
                                                                                <!-- Dropzone container for white image -->
                                                                                <div id="white-image-dropzone-${optionId}" class="dropzone">
                                                                                    <div class="dz-message">
                                                                                        Drop image here or click to upload.
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="white-image-data" name="option_white_image[]">
                                                                                <div class="white-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                                                                            </div>

                                                                            <div class="d-flex flex-column upload-images-con">
                                                                                <label class="form-label">Black without Headboard Image</label>
                                                                                <!-- Dropzone container for black image -->
                                                                                <div id="black-image-dropzone-${optionId}" class="dropzone">
                                                                                    <div class="dz-message">
                                                                                        Drop image here or click to upload.
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="black-image-data" name="option_black_image[]">
                                                                                <div class="black-image-preview mt-2" style="max-width: 100px; display:none;"></div>
                                                                            </div>

                                                                            <div class="d-flex flex-column upload-images-con">
                                                                                <label class="form-label">White with Headboard Image</label>
                                                                                <div id="white-image-dropzone-with-headboard-${optionId}" class="dropzone">
                                                                                    <div class="dz-message">
                                                                                        Drop image here or click to upload.
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="white-image-data-with-headboard" name="option_white_image_withHeadboard[]" value="${option.whiteImage || ''}">
                                                                                <div class="white-image-preview-with-headboard mt-2" style="max-width: 100px; display:none;">
                                                                                    ${option.whiteImage ? `<img src="${option.whiteImage}" class="img-fluid rounded">` : ''}
                                                                                </div>
                                                                            </div>

                                                                            <div class="d-flex flex-column upload-images-con">
                                                                                <label class="form-label">Black with Headboard Image</label>
                                                                                <div id="black-image-dropzone-with-headboard-${optionId}" class="dropzone">
                                                                                    <div class="dz-message">
                                                                                        Drop image here or click to upload.
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="black-image-data-with-headboard" name="option_black_image_withHeadboard[]" value="${option.blackImage || ''}">
                                                                                <div class="black-image-preview-with-headboard mt-2" style="max-width: 100px; display:none;">
                                                                                    ${option.blackImage ? `<img src="${option.blackImage}" class="img-fluid rounded">` : ''}
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                            <button type="button" class="btn btn-danger btn-sm custom-radio-remove-btn" data-option-id="${optionId}"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                                        </div>
                                                                    </div>`;
                                                                    $container.append(newOption);

                                                                    // Add specific event handlers for this option's images
                                                                    $(`#${optionId} .white-image-input`)
                                                                        .off('change').on('change',
                                                                            function(e) {
                                                                                handleCustomRadioImageUpload
                                                                                    ($(this), 'white');
                                                                            });

                                                                    $(`#${optionId} .black-image-input`)
                                                                        .off('change').on('change',
                                                                            function(e) {
                                                                                handleCustomRadioImageUpload
                                                                                    ($(this), 'black');
                                                                            });

                                                                    $(`#${optionId} .custom-radio-remove-btn`)
                                                                        .off('click').on('click', function(
                                                                            e) {
                                                                            e
                                                                                .stopPropagation(); // Prevent event bubbling
                                                                            $(`#${optionId}`).remove();
                                                                            updateStepJSON();
                                                                        });


                                                                    const whiteDropzoneId =
                                                                        `white-image-dropzone-${optionId}`;
                                                                    const blackDropzoneId =
                                                                        `black-image-dropzone-${optionId}`;

                                                                    const whiteDropzoneId_withHeadboard =
                                                                        `white-image-dropzone-with-headboard-${optionId}`;
                                                                    const blackDropzoneId_withHeadboard =
                                                                        `black-image-dropzone-with-headboard-${optionId}`;

                                                                    // Append dropzone containers for white and black image
                                                                    if($(`#${whiteDropzoneId}`).length > 0) {
                                                                        const $whiteDropzone = new Dropzone(
                                                                            `#${whiteDropzoneId}`, {
                                                                                url: "/back/upload/white-image", // Replace with your route
                                                                                maxFiles: 1,
                                                                                addRemoveLinks: true,
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': document
                                                                                        .querySelector(
                                                                                            'meta[name="csrf-token"]'
                                                                                            ).getAttribute(
                                                                                            'content')
                                                                                },
                                                                                init: function() {
                                                                                    const dz = this;

                                                                                    dz.on("addedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            if (dz
                                                                                                .files
                                                                                                .length >
                                                                                                1) {
                                                                                                dz.removeFile(
                                                                                                    file
                                                                                                    );
                                                                                                Swal.fire({
                                                                                                    icon: 'warning',
                                                                                                    title: 'Only one image allowed',
                                                                                                    text: 'Please remove the existing image before uploading a new one.',
                                                                                                    confirmButtonText: 'OK'
                                                                                                });
                                                                                            }
                                                                                        });

                                                                                    if (option
                                                                                        .whiteImage
                                                                                        ) {
                                                                                        const
                                                                                        mockFile = {
                                                                                            name: "white.jpg",
                                                                                            size: 12345
                                                                                        };
                                                                                        dz.emit("addedfile",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.emit("thumbnail",
                                                                                            mockFile,
                                                                                        /*   "{{ url('/') }}/" + */
                                                                                            option
                                                                                            .whiteImage
                                                                                            );
                                                                                        dz.emit("complete",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.files.push(
                                                                                            mockFile
                                                                                            );

                                                                                        $(`#${optionId} .white-image-data`)
                                                                                            .val(option
                                                                                                .whiteImage
                                                                                                );
                                                                                        $(`#${optionId} .white-image-preview`)
                                                                                            .html(
                                                                                                `<img src="${option.whiteImage}" alt="White Image" style="max-width: 100px;">`
                                                                                                );

                                                                                        mockFile
                                                                                            .previewElement
                                                                                            .querySelector(
                                                                                                ".dz-remove"
                                                                                                )
                                                                                            .addEventListener(
                                                                                                "click",
                                                                                                function() {
                                                                                                    const
                                                                                                        oldImageUrl =
                                                                                                        $(
                                                                                                            `#${optionId} .white-image-data`)
                                                                                                        .val();
                                                                                                    // if (oldImageUrl) {
                                                                                                    //     $.ajax({
                                                                                                    //         url: '/back/delete/white-image',
                                                                                                    //         type: 'POST',
                                                                                                    //         data: {
                                                                                                    //             image_url: oldImageUrl,
                                                                                                    //             _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                                                    //         }
                                                                                                    //     });
                                                                                                    // }

                                                                                                    dz.removeFile(
                                                                                                        mockFile
                                                                                                        );
                                                                                                    $(`#${optionId} .white-image-data`)
                                                                                                        .val(
                                                                                                            ""
                                                                                                            );
                                                                                                    updateStepJSON
                                                                                                        ();
                                                                                                });
                                                                                    }

                                                                                    dz.on("success",
                                                                                        function(
                                                                                            file,
                                                                                            response
                                                                                            ) {
                                                                                            $(`#${optionId} .white-image-data`)
                                                                                                .val(
                                                                                                    response
                                                                                                    .path
                                                                                                    );
                                                                                            $(`#${optionId} .white-image-preview`)
                                                                                                .html(
                                                                                                    `<img src="${response.path}" alt="White Image" style="max-width: 100px;">`
                                                                                                    );
                                                                                            updateStepJSON
                                                                                                ();
                                                                                        });

                                                                                    dz.on("removedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // Prevent auto-clearing here (handled above on .dz-remove)
                                                                                        });
                                                                                }

                                                                        });
                                                                    }
                                                                    if($(`#${blackDropzoneId}`).length > 0) {
                                                                        const $blackDropzone = new Dropzone(
                                                                            `#${blackDropzoneId}`, {
                                                                                url: "/back/upload/black-image", // Replace with your route
                                                                                maxFiles: 1,
                                                                                addRemoveLinks: true,
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': document
                                                                                        .querySelector(
                                                                                            'meta[name="csrf-token"]'
                                                                                            ).getAttribute(
                                                                                            'content')
                                                                                },
                                                                                init: function() {
                                                                                    const dz = this;

                                                                                    dz.on("addedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // if (dz.files.length > 1) {
                                                                                            //     dz.removeFile(file);
                                                                                            //     Swal.fire({
                                                                                            //         icon: 'warning',
                                                                                            //         title: 'Only one image allowed',
                                                                                            //         text: 'Please remove the existing image before uploading a new one.',
                                                                                            //         confirmButtonText: 'OK'
                                                                                            //     });
                                                                                            // }
                                                                                        });

                                                                                    if (option
                                                                                        .blackImage
                                                                                        ) {
                                                                                        const
                                                                                        mockFile = {
                                                                                            name: "black.jpg",
                                                                                            size: 12345
                                                                                        };
                                                                                        dz.emit("addedfile",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.emit("thumbnail",
                                                                                            mockFile,
                                                                                        /*   "{{ url('/') }}/" + */
                                                                                            option
                                                                                            .blackImage
                                                                                            );
                                                                                        dz.emit("complete",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.files.push(
                                                                                            mockFile
                                                                                            );

                                                                                        $(`#${optionId} .black-image-data`)
                                                                                            .val(option
                                                                                                .blackImage
                                                                                                );
                                                                                        $(`#${optionId} .black-image-preview`)
                                                                                            .html(
                                                                                                `<img src="${option.blackImage}" alt="Black Image" style="max-width: 100px;">`
                                                                                                );

                                                                                        mockFile
                                                                                            .previewElement
                                                                                            .querySelector(
                                                                                                ".dz-remove"
                                                                                                )
                                                                                            .addEventListener(
                                                                                                "click",
                                                                                                function() {
                                                                                                    const
                                                                                                        oldImageUrl =
                                                                                                        $(
                                                                                                            `#${optionId} .black-image-data`)
                                                                                                        .val();
                                                                                                    if (
                                                                                                        oldImageUrl) {
                                                                                                        $.ajax({
                                                                                                            url: '/back/delete/black-image',
                                                                                                            type: 'POST',
                                                                                                            data: {
                                                                                                                image_url: oldImageUrl,
                                                                                                                _token: document
                                                                                                                    .querySelector(
                                                                                                                        'meta[name="csrf-token"]'
                                                                                                                        )
                                                                                                                    .getAttribute(
                                                                                                                        'content'
                                                                                                                        )
                                                                                                            }
                                                                                                        });
                                                                                                    }

                                                                                                    dz.removeFile(
                                                                                                        mockFile
                                                                                                        );
                                                                                                    $(`#${optionId} .black-image-data`)
                                                                                                        .val(
                                                                                                            ""
                                                                                                            );
                                                                                                    updateStepJSON
                                                                                                        ();
                                                                                                });
                                                                                    }

                                                                                    dz.on("success",
                                                                                        function(
                                                                                            file,
                                                                                            response
                                                                                            ) {
                                                                                            $(`#${optionId} .black-image-data`)
                                                                                                .val(
                                                                                                    response
                                                                                                    .path
                                                                                                    );
                                                                                            $(`#${optionId} .black-image-preview`)
                                                                                                .html(
                                                                                                    `<img src="${response.path}" alt="Black Image" style="max-width: 100px;">`
                                                                                                    );
                                                                                            updateStepJSON
                                                                                                ();
                                                                                        });

                                                                                    dz.on("removedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // Skip auto-clear; handled manually
                                                                                        });
                                                                                }
                                                                        });
                                                                    }

                                                                    if($(`#${whiteDropzoneId_withHeadboard}`).length > 0) {
                                                                        const $whiteDropzone_withHeadboard = new Dropzone(
                                                                            `#${whiteDropzoneId_withHeadboard}`, {
                                                                                url: "/back/upload/white-image", // Replace with your route
                                                                                maxFiles: 1,
                                                                                addRemoveLinks: true,
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': document
                                                                                        .querySelector(
                                                                                            'meta[name="csrf-token"]'
                                                                                            ).getAttribute(
                                                                                            'content')
                                                                                },
                                                                                init: function() {
                                                                                    const dz = this;

                                                                                    dz.on("addedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            if (dz
                                                                                                .files
                                                                                                .length >
                                                                                                1) {
                                                                                                dz.removeFile(
                                                                                                    file
                                                                                                    );
                                                                                                Swal.fire({
                                                                                                    icon: 'warning',
                                                                                                    title: 'Only one image allowed',
                                                                                                    text: 'Please remove the existing image before uploading a new one.',
                                                                                                    confirmButtonText: 'OK'
                                                                                                });
                                                                                            }
                                                                                        });

                                                                                    if (option
                                                                                        .whiteImage_withHeadboard
                                                                                        ) {
                                                                                        const
                                                                                        mockFile = {
                                                                                            name: "white.jpg",
                                                                                            size: 12345
                                                                                        };
                                                                                        dz.emit("addedfile",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.emit("thumbnail",
                                                                                            mockFile,
                                                                                        /*   "{{ url('/') }}/" + */
                                                                                            option
                                                                                            .whiteImage_withHeadboard
                                                                                            );
                                                                                        dz.emit("complete",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.files.push(
                                                                                            mockFile
                                                                                            );

                                                                                        $(`#${optionId} .white-image-data-with-headboard`)
                                                                                            .val(option
                                                                                                .whiteImage_withHeadboard
                                                                                                );
                                                                                        $(`#${optionId} .white-image-preview-with-headboard`)
                                                                                            .html(
                                                                                                `<img src="${option.whiteImage_withHeadboard}" alt="White Image" style="max-width: 100px;">`
                                                                                                );

                                                                                        mockFile
                                                                                            .previewElement
                                                                                            .querySelector(
                                                                                                ".dz-remove"
                                                                                                )
                                                                                            .addEventListener(
                                                                                                "click",
                                                                                                function() {
                                                                                                    const
                                                                                                        oldImageUrl =
                                                                                                        $(
                                                                                                            `#${optionId} .white-image-data-with-headboard`)
                                                                                                        .val();
                                                                                                    // if (oldImageUrl) {
                                                                                                    //     $.ajax({
                                                                                                    //         url: '/back/delete/white-image',
                                                                                                    //         type: 'POST',
                                                                                                    //         data: {
                                                                                                    //             image_url: oldImageUrl,
                                                                                                    //             _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                                                    //         }
                                                                                                    //     });
                                                                                                    // }

                                                                                                    dz.removeFile(
                                                                                                        mockFile
                                                                                                        );
                                                                                                    $(`#${optionId} .white-image-data-with-headboard`)
                                                                                                        .val("");
                                                                                                    updateStepJSON
                                                                                                        ();
                                                                                                });
                                                                                    }

                                                                                    dz.on("success",
                                                                                        function(
                                                                                            file,
                                                                                            response
                                                                                            ) {
                                                                                                // console.log(response);
                                                                                            $(`#${optionId} .white-image-data-with-headboard`)
                                                                                                .val(
                                                                                                    response
                                                                                                    .path
                                                                                                    );
                                                                                            $(`#${optionId} .white-image-preview-with-headboard`)
                                                                                                .html(
                                                                                                    `<img src="${response.path}" alt="White Image" style="max-width: 100px;">`
                                                                                                    );
                                                                                            updateStepJSON
                                                                                                ();
                                                                                            // console.log(2170);
                                                                                        });

                                                                                    dz.on("removedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // Prevent auto-clearing here (handled above on .dz-remove)
                                                                                        });
                                                                                }

                                                                        });
                                                                    }

                                                                    if($(`#${blackDropzoneId_withHeadboard}`).length > 0) {
                                                                        const $blackDropzone_withHeadboard = new Dropzone(
                                                                        `#${blackDropzoneId_withHeadboard}`, {
                                                                            url: "/back/upload/black-image", // Replace with your route
                                                                            maxFiles: 1,
                                                                            addRemoveLinks: true,
                                                                            headers: {
                                                                                'X-CSRF-TOKEN': document
                                                                                    .querySelector(
                                                                                        'meta[name="csrf-token"]'
                                                                                        ).getAttribute(
                                                                                        'content')
                                                                            },
                                                                            init: function() {
                                                                                const dz = this;

                                                                                dz.on("addedfile",
                                                                                    function(
                                                                                        file) {
                                                                                        // if (dz.files.length > 1) {
                                                                                        //     dz.removeFile(file);
                                                                                        //     Swal.fire({
                                                                                        //         icon: 'warning',
                                                                                        //         title: 'Only one image allowed',
                                                                                        //         text: 'Please remove the existing image before uploading a new one.',
                                                                                        //         confirmButtonText: 'OK'
                                                                                        //     });
                                                                                        // }
                                                                                    });

                                                                                if (option
                                                                                    .blackImage_withHeadboard
                                                                                    ) {
                                                                                    const
                                                                                    mockFile = {
                                                                                        name: "black.jpg",
                                                                                        size: 12345
                                                                                    };
                                                                                    dz.emit("addedfile",
                                                                                        mockFile
                                                                                        );
                                                                                    dz.emit("thumbnail",
                                                                                        mockFile,
                                                                                    /*   "{{ url('/') }}/" + */
                                                                                        option
                                                                                        .blackImage_withHeadboard
                                                                                        );
                                                                                    dz.emit("complete",
                                                                                        mockFile
                                                                                        );
                                                                                    dz.files.push(
                                                                                        mockFile
                                                                                        );

                                                                                    $(`#${optionId} .black-image-data-with-headboard`)
                                                                                        .val(option
                                                                                            .blackImage_withHeadboard
                                                                                            );
                                                                                    $(`#${optionId} .black-image-preview-with-headboard`)
                                                                                        .html(
                                                                                            `<img src="${option.blackImage_withHeadboard}" alt="Black Image" style="max-width: 100px;">`
                                                                                            );

                                                                                    mockFile
                                                                                        .previewElement
                                                                                        .querySelector(
                                                                                            ".dz-remove"
                                                                                            )
                                                                                        .addEventListener(
                                                                                            "click",
                                                                                            function() {
                                                                                                const
                                                                                                    oldImageUrl =
                                                                                                    $(
                                                                                                        `#${optionId} .black-image-data-with-headboard`)
                                                                                                    .val();
                                                                                                if (
                                                                                                    oldImageUrl) {
                                                                                                    $.ajax({
                                                                                                        url: '/back/delete/black-image',
                                                                                                        type: 'POST',
                                                                                                        data: {
                                                                                                            image_url: oldImageUrl,
                                                                                                            _token: document
                                                                                                                .querySelector(
                                                                                                                    'meta[name="csrf-token"]'
                                                                                                                    )
                                                                                                                .getAttribute(
                                                                                                                    'content'
                                                                                                                    )
                                                                                                        }
                                                                                                    });
                                                                                                }

                                                                                                dz.removeFile(
                                                                                                    mockFile
                                                                                                    );
                                                                                                $(`#${optionId} .black-image-data-with-headboard`)
                                                                                                    .val(
                                                                                                        ""
                                                                                                        );
                                                                                                updateStepJSON
                                                                                                    ();
                                                                                            });
                                                                                }

                                                                                dz.on("success",
                                                                                    function(
                                                                                        file,
                                                                                        response
                                                                                        ) {
                                                                                        $(`#${optionId} .black-image-data-with-headboard`)
                                                                                            .val(
                                                                                                response
                                                                                                .path
                                                                                                );
                                                                                        $(`#${optionId} .black-image-preview-with-headboard`)
                                                                                            .html(
                                                                                                `<img src="${response.path}" alt="Black Image" style="max-width: 100px;">`
                                                                                                );
                                                                                        updateStepJSON
                                                                                            ();
                                                                                    });

                                                                                dz.on("removedfile",
                                                                                    function(
                                                                                        file) {
                                                                                        // Skip auto-clear; handled manually
                                                                                    });
                                                                            }
                                                                        });
                                                                    }


                                                                });
                                                            }

                                                            else if (key === 'options' && (field.type ===
                                                                    'headboard_radio') && Array.isArray(field
                                                                    .options)) {
                                                                // Clear and set unique ID for container
                                                                const $container = $fieldOptions.find(
                                                                    '.custom-radio-options-container');
                                                                $container.attr('id', `radio-container-${fieldId}`)
                                                                    .attr('data-field-id', fieldId).empty();

                                                                // Add button handler
                                                                const $addButton = $fieldOptions.find(
                                                                    '.add-custom-radio-option');
                                                                $addButton.off('click').on('click', function() {
                                                                    const optionCount = $container
                                                                        .children().length;
                                                                    addHeadboardOption($container,
                                                                        fieldId, optionCount);
                                                                    updateStepJSON();
                                                                });

                                                                // Add each saved option
                                                                field.options.forEach(function(option, index) {
                                                                    const optionId =
                                                                        `option-${fieldId}-${index}`;
                                                                    const newOption = `
                                                                    <div class="custom-radio-option mb-2 p-2 border rounded" id="${optionId}" data-field-id="${fieldId}">
                                                                        <div class="m-2">
                                                                            <div class="">
                                                                                <label class="form-label">Option Label</label>
                                                                                <input type="text" class="form-control field-input" name="option_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                                            </div>
                                                                            <div class="mt-2">
                                                                                <label class="form-label">Option Text</label>
                                                                                <input type="text" class="form-control field-input" name="option_texts[]" placeholder="Option text" value="${option.text || ''}">
                                                                            </div>
                                                                            <div class="mt-2">
                                                                                <label class="form-label">Option Length</label>
                                                                                <input type="text" class="form-control field-input" name="option_lengths[]" placeholder="Length" value="${option.length || ''}">
                                                                            </div>
                                                                            <div class="mt-2">
                                                                                <label class="form-label">Option Fitment Time</label>
                                                                                <input type="text" class="form-control field-input" name="option_times[]" placeholder="fitment time" value="${option.fitment_time || ''}">
                                                                            </div>
                                                                            <div class="d-flex p-2 flex-column car-size-field-main" >
                                                                                <label class="form-label fw-bold">Price</label>
                                                                                <div class="d-flex gap-2 car-size-field-outer">
                                                                                    <div class="d-flex flex-column car-size-field-form">
                                                                                        <label class="form-label">Mid Sized</label>
                                                                                        <input type="number" class="form-control field-input" name="option_mid_sized[]" placeholder="price" value="${option.mid_sized_price || ''}">
                                                                                    </div>
                                                                                    <div class="d-flex flex-column car-size-field-form">
                                                                                        <label class="form-label">Toyota 79</label>
                                                                                        <input type="number" class="form-control field-input" name="option_toyota_79[]" placeholder="price" value="${option.toyota_79_price || ''}">
                                                                                    </div>
                                                                                    <div class="d-flex flex-column car-size-field-form">
                                                                                        <label class="form-label">USA Truck</label>
                                                                                        <input type="number" class="form-control field-input" name="option_usa_truck[]" placeholder="price" value="${option.usa_truck_price || ''}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-check w-100 m-2">
                                                                                <div class="create-form-checkbox reminder-con">
                                                                                    <label class="custom-checkbox">
                                                                                            
                                                                                            <input type="checkbox" class="form-check-input field-input m-1" name="option_active[]" ${option.isActive ? 'checked' : ''}>
                                                                                        <span class="checkmark"></span> <span class="remember-text">Active</span>
                                                                                    </label>
                                                                                </div>
                                                                               
                                                                            </div>


                                                                            <div class="upload-images-main"> 
                                                                            <div class="d-flex flex-column upload-images-con">
                                                                                <label class="form-label">White Image</label>
                                                                                <div id="white-image-dropzone-${optionId}" class="dropzone">
                                                                                    <div class="dz-message">
                                                                                        Drop image here or click to upload.
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="white-image-data" name="option_white_image_data[]" value="${option.whiteImage || ''}">
                                                                                <div class="white-image-preview mt-2" style="max-width: 100px; display:none;">
                                                                                    ${option.whiteImage ? `<img src="${option.whiteImage}" class="img-fluid rounded">` : ''}
                                                                                </div>
                                                                            </div>

                                                                             <div class="d-flex flex-column upload-images-con">
                                                                                <label class="form-label">Black Image</label>
                                                                                <div id="black-image-dropzone-${optionId}" class="dropzone">
                                                                                    <div class="dz-message">
                                                                                        Drop image here or click to upload.
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="black-image-data" name="option_black_image_data[]" value="${option.blackImage || ''}">
                                                                                <div class="black-image-preview mt-2" style="max-width: 100px; display:none;">
                                                                                    ${option.blackImage ? `<img src="${option.blackImage}" class="img-fluid rounded">` : ''}
                                                                                </div>
                                                                            </div>
                                                                            </div> 

                                                                            <button type="button" class="btn btn-danger btn-sm custom-radio-remove-btn" data-option-id="${optionId}"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                                        </div>
                                                                    </div>`;
                                                                    $container.append(newOption);

                                                                    // Add specific event handlers for this option's images
                                                                    $(`#${optionId} .white-image-input`)
                                                                        .off('change').on('change',
                                                                            function(e) {
                                                                                handleCustomRadioImageUpload
                                                                                    ($(this), 'white');
                                                                            });

                                                                    $(`#${optionId} .black-image-input`)
                                                                        .off('change').on('change',
                                                                            function(e) {
                                                                                handleCustomRadioImageUpload
                                                                                    ($(this), 'black');
                                                                            });

                                                                    $(`#${optionId} .custom-radio-remove-btn`)
                                                                        .off('click').on('click', function(
                                                                            e) {
                                                                            e
                                                                                .stopPropagation(); // Prevent event bubbling
                                                                            $(`#${optionId}`).remove();
                                                                            updateStepJSON();
                                                                        });


                                                                    const whiteDropzoneId =
                                                                        `white-image-dropzone-${optionId}`;
                                                                    const blackDropzoneId =
                                                                        `black-image-dropzone-${optionId}`;
                                                                    if($(`#${whiteDropzoneId}`).length> 0 ){
                                                                        // Append dropzone containers for white and black image
                                                                        const $whiteDropzone = new Dropzone(
                                                                            `#${whiteDropzoneId}`, {
                                                                                url: "/back/upload/white-image", // Replace with your route
                                                                                maxFiles: 1,
                                                                                addRemoveLinks: true,
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': document
                                                                                        .querySelector(
                                                                                            'meta[name="csrf-token"]'
                                                                                            ).getAttribute(
                                                                                            'content')
                                                                                },
                                                                                init: function() {
                                                                                    const dz = this;

                                                                                    dz.on("addedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            if (dz
                                                                                                .files
                                                                                                .length >
                                                                                                1) {
                                                                                                dz.removeFile(
                                                                                                    file
                                                                                                    );
                                                                                                Swal.fire({
                                                                                                    icon: 'warning',
                                                                                                    title: 'Only one image allowed',
                                                                                                    text: 'Please remove the existing image before uploading a new one.',
                                                                                                    confirmButtonText: 'OK'
                                                                                                });
                                                                                            }
                                                                                        });

                                                                                    if (option
                                                                                        .whiteImage
                                                                                        ) {
                                                                                        const
                                                                                        mockFile = {
                                                                                            name: "white.jpg",
                                                                                            size: 12345
                                                                                        };
                                                                                        dz.emit("addedfile",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.emit("thumbnail",
                                                                                            mockFile,
                                                                                        /*    "{{ url('/') }}/" + */
                                                                                            option
                                                                                            .whiteImage
                                                                                            );
                                                                                        dz.emit("complete",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.files.push(
                                                                                            mockFile
                                                                                            );

                                                                                        $(`#${optionId} .white-image-data`)
                                                                                            .val(option
                                                                                                .whiteImage
                                                                                                );
                                                                                        $(`#${optionId} .white-image-preview`)
                                                                                            .html(
                                                                                                `<img src="${option.whiteImage}" alt="White Image" style="max-width: 100px;">`
                                                                                                );

                                                                                        mockFile
                                                                                            .previewElement
                                                                                            .querySelector(
                                                                                                ".dz-remove"
                                                                                                )
                                                                                            .addEventListener(
                                                                                                "click",
                                                                                                function() {
                                                                                                    const
                                                                                                        oldImageUrl =
                                                                                                        $(
                                                                                                            `#${optionId} .white-image-data`)
                                                                                                        .val();
                                                                                                    // if (oldImageUrl) {
                                                                                                    //     $.ajax({
                                                                                                    //         url: '/back/delete/white-image',
                                                                                                    //         type: 'POST',
                                                                                                    //         data: {
                                                                                                    //             image_url: oldImageUrl,
                                                                                                    //             _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                                                    //         }
                                                                                                    //     });
                                                                                                    // }

                                                                                                    dz.removeFile(
                                                                                                        mockFile
                                                                                                        );
                                                                                                    $(`#${optionId} .white-image-data`)
                                                                                                        .val(
                                                                                                            ""
                                                                                                            );
                                                                                                    updateStepJSON
                                                                                                        ();
                                                                                                });
                                                                                    }

                                                                                    dz.on("success",
                                                                                        function(
                                                                                            file,
                                                                                            response
                                                                                            ) {
                                                                                            $(`#${optionId} .white-image-data`)
                                                                                                .val(
                                                                                                    response
                                                                                                    .path
                                                                                                    );
                                                                                            $(`#${optionId} .white-image-preview`)
                                                                                                .html(
                                                                                                    `<img src="${response.path}" alt="White Image" style="max-width: 100px;">`
                                                                                                    );
                                                                                            updateStepJSON
                                                                                                ();
                                                                                        });

                                                                                    dz.on("removedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // Prevent auto-clearing here (handled above on .dz-remove)
                                                                                        });
                                                                                }

                                                                            });
                                                                    }
                                                                    if($(`#${blackDropzoneId}`).length> 0 ){
                                                                        const $blackDropzone = new Dropzone(
                                                                            `#${blackDropzoneId}`, {
                                                                                url: "/back/upload/black-image", // Replace with your route
                                                                                maxFiles: 1,
                                                                                addRemoveLinks: true,
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': document
                                                                                        .querySelector(
                                                                                            'meta[name="csrf-token"]'
                                                                                            ).getAttribute(
                                                                                            'content')
                                                                                },
                                                                                init: function() {
                                                                                    const dz = this;

                                                                                    dz.on("addedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // if (dz.files.length > 1) {
                                                                                            //     dz.removeFile(file);
                                                                                            //     Swal.fire({
                                                                                            //         icon: 'warning',
                                                                                            //         title: 'Only one image allowed',
                                                                                            //         text: 'Please remove the existing image before uploading a new one.',
                                                                                            //         confirmButtonText: 'OK'
                                                                                            //     });
                                                                                            // }
                                                                                        });

                                                                                    if (option
                                                                                        .blackImage
                                                                                        ) {
                                                                                        const
                                                                                        mockFile = {
                                                                                            name: "black.jpg",
                                                                                            size: 12345
                                                                                        };
                                                                                        dz.emit("addedfile",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.emit("thumbnail",
                                                                                            mockFile,
                                                                                        /*   "{{ url('/') }}/" + */
                                                                                            option
                                                                                            .blackImage
                                                                                            );
                                                                                        dz.emit("complete",
                                                                                            mockFile
                                                                                            );
                                                                                        dz.files.push(
                                                                                            mockFile
                                                                                            );

                                                                                        $(`#${optionId} .black-image-data`)
                                                                                            .val(option
                                                                                                .blackImage
                                                                                                );
                                                                                        $(`#${optionId} .black-image-preview`)
                                                                                            .html(
                                                                                                `<img src="${option.blackImage}" alt="Black Image" style="max-width: 100px;">`
                                                                                                );

                                                                                        mockFile
                                                                                            .previewElement
                                                                                            .querySelector(
                                                                                                ".dz-remove"
                                                                                                )
                                                                                            .addEventListener(
                                                                                                "click",
                                                                                                function() {
                                                                                                    const
                                                                                                        oldImageUrl =
                                                                                                        $(
                                                                                                            `#${optionId} .black-image-data`)
                                                                                                        .val();
                                                                                                    if (
                                                                                                        oldImageUrl) {
                                                                                                        $.ajax({
                                                                                                            url: '/back/delete/black-image',
                                                                                                            type: 'POST',
                                                                                                            data: {
                                                                                                                image_url: oldImageUrl,
                                                                                                                _token: document
                                                                                                                    .querySelector(
                                                                                                                        'meta[name="csrf-token"]'
                                                                                                                        )
                                                                                                                    .getAttribute(
                                                                                                                        'content'
                                                                                                                        )
                                                                                                            }
                                                                                                        });
                                                                                                    }

                                                                                                    dz.removeFile(
                                                                                                        mockFile
                                                                                                        );
                                                                                                    $(`#${optionId} .black-image-data`)
                                                                                                        .val("");
                                                                                                    updateStepJSON
                                                                                                        ();
                                                                                                });
                                                                                    }

                                                                                    dz.on("success",
                                                                                        function(
                                                                                            file,
                                                                                            response
                                                                                            ) {
                                                                                            $(`#${optionId} .black-image-data`)
                                                                                                .val(
                                                                                                    response
                                                                                                    .path
                                                                                                    );
                                                                                            $(`#${optionId} .black-image-preview`)
                                                                                                .html(
                                                                                                    `<img src="${response.path}" alt="Black Image" style="max-width: 100px;">`
                                                                                                    );
                                                                                            updateStepJSON
                                                                                                ();
                                                                                        });

                                                                                    dz.on("removedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // Skip auto-clear; handled manually
                                                                                        });
                                                                                }
                                                                            });
                                                                    }




                                                                });
                                                            }




                                                            // Handle slide options
                                                            else if (key === 'slideOptions' && field.type ===
                                                                'slide_options' && Array.isArray(field.slideOptions)
                                                            ) {
                                                                // Clear existing default options
                                                                $fieldOptions.find('.slide-options-container')
                                                                    .empty();

                                                                // Add each saved slide option
                                                                field.slideOptions.forEach(function(option) {
                                                                    const newOption = `
                                                                    <div class="slide-option mb-2 p-2 border rounded">
                                                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                            <div class="w-100">
                                                                                <label class="form-label">Label</label>
                                                                                <input type="text" class="form-control field-input" name="slide_labels[]" placeholder="Option label" value="${option.label || ''}">
                                                                            </div>
                                                                            <div class="w-100">
                                                                                <label class="form-label">Quantity</label>
                                                                                <input type="text" class="form-control field-input" name="slide_quantities[]" placeholder="Quantity" min="1" value="${option.quantity || 1}">
                                                                            </div>
                                                                            <div class="d-flex flex-column w-100">
                                                                                <label class="form-label">Image</label>
                                                                                <input type="file" class="form-control field-input slide-image-input" name="slide_images[]" accept="image/*">
                                                                                <input type="hidden" class="slide-image-data" name="slide_image_data[]" value="${option.imageData || ''}">
                                                                                <div class="slide-image-preview mt-2" style="max-width: 100px;">
                                                                                    ${option.image_url ? `<img src="${option.image_url}" class="img-fluid rounded">` : ''}
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="btn btn-danger btn-sm remove-slide-option mt-3"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                                        </div>
                                                                    </div>`;
                                                                    $fieldOptions.find(
                                                                            '.slide-options-container')
                                                                        .append(newOption);
                                                                });
                                                            }

                                                            // Populate saved product type options
                                                            else if (key === 'productType' && field.type ===
                                                                'products') {
                                                                $fieldOptions.find('.product-types-container')
                                                                    .empty(); // Clear existing options

                                                                // field.productType
                                                                // .filter(option => option && option
                                                                //     .value) // Remove null values
                                                                // .forEach(function(option) {
                                                                const newOption = `
                                                                        <select class="form-select field-input" name="product_type">
                                                                            <option value="internals" ${field.productType === 'internals' ? 'selected' : ''}>Internal</option>
                                                                            <option value="external" ${field.productType === 'external' ? 'selected' : ''}>External</option>
                                                                        </select>`;
                                                                $fieldOptions.find(
                                                                        '.product-types-container')
                                                                    .append(newOption);
                                                                // });
                                                            }



                                                            // Handle colors
                                                            else if (key === 'colors' && field.type === 'colors' &&
                                                                Array.isArray(field.colors)) {
                                                                // Clear existing default options
                                                                $fieldOptions.find('.color-options-container')
                                                                    .empty();

                                                                // Add each saved color option
                                                                field.colors.forEach(function(color, index) {
                                                                    const optionId =
                                                                        `option-${fieldId}-${index}`;
                                                                    const newOption = `
                                                                    <div class="color-option mb-2" id="${optionId}">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <input type="text" class="form-control field-input" name="color_names[]" placeholder="Color name" value="${color.name || ''}">
                                                                            <input type="text" class="form-control field-input" name="color_labels[]" placeholder="Display label" value="${color.label || ''}">
                                                                            <div id="colors_img_dropzone_${optionId}" class="dropzone color-img-dropzone">
                                                                                <div class="dz-message">
                                                                                    Drop image here or click to upload.
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" class="form-control field-input" name="color_images[]" accept="image/*">
                                                                            <input type="hidden" class="color-image-data" name="color_image_data[]" value="${color.imageData || ''}">
                                                                            <button type="button" class="btn btn-danger btn-sm remove-color"><img src="{{ asset('images') }}/aarow-cut.svg"></button>
                                                                        </div>
                                                                    </div>`;
                                                                    $fieldOptions.find(
                                                                            '.color-options-container')
                                                                        .append(newOption);

                                                                    if($(`#colors_img_dropzone_${optionId}`).length > 0) {
                                                                        // Initialize dropzone for color images
                                                                        const colorDropzone = new Dropzone(
                                                                            `#colors_img_dropzone_${optionId}`, {
                                                                                url: "/back/upload/color-image",
                                                                                maxFiles: 1,
                                                                                addRemoveLinks: true,
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': document
                                                                                        .querySelector(
                                                                                            'meta[name="csrf-token"]'
                                                                                        ).getAttribute(
                                                                                            'content')
                                                                                },
                                                                                init: function() {
                                                                                    const dz = this;

                                                                                    dz.on("addedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            if (dz
                                                                                                .files
                                                                                                .length >
                                                                                                1) {
                                                                                                dz.removeFile(
                                                                                                    file
                                                                                                );
                                                                                                Swal.fire({
                                                                                                    icon: 'warning',
                                                                                                    title: 'Only one image allowed',
                                                                                                    text: 'Please remove the existing image before uploading a new one.',
                                                                                                    confirmButtonText: 'OK'
                                                                                                });
                                                                                            }
                                                                                        });

                                                                                    if (color
                                                                                        .image_url) {
                                                                                        const
                                                                                            mockFile = {
                                                                                                name: "color.jpg",
                                                                                                size: 12345
                                                                                            };
                                                                                        dz.emit("addedfile",
                                                                                            mockFile
                                                                                        );
                                                                                        dz.emit("thumbnail",
                                                                                            mockFile,
                                                                                            color
                                                                                            .image_url
                                                                                        );
                                                                                        dz.emit("complete",
                                                                                            mockFile
                                                                                        );
                                                                                        dz.files.push(
                                                                                            mockFile
                                                                                        );


                                                                                        // $(`#${optionId} .color-images`).val(color.image_url);
                                                                                        $(`#color_option_${index} .color-image-data`)
                                                                                            .val(color
                                                                                                .image_url
                                                                                            );
                                                                                        $(`#color_option_${index} .color-img-preview`)
                                                                                            .html(
                                                                                                `<img src="${color.image_url}" alt="Black Image" style="max-width: 100px;">`
                                                                                            );


                                                                                        mockFile
                                                                                            .previewElement
                                                                                            .querySelector(
                                                                                                ".dz-remove"
                                                                                            )
                                                                                            .addEventListener(
                                                                                                "click",
                                                                                                function() {
                                                                                                    const
                                                                                                        oldImageUrl =
                                                                                                        color
                                                                                                        .image_url;
                                                                                                    if (
                                                                                                        oldImageUrl
                                                                                                        ) {
                                                                                                        $.ajax({
                                                                                                            url: '/back/delete/color-image',
                                                                                                            type: 'POST',
                                                                                                            data: {
                                                                                                                image_url: oldImageUrl,
                                                                                                                _token: document
                                                                                                                    .querySelector(
                                                                                                                        'meta[name="csrf-token"]'
                                                                                                                    )
                                                                                                                    .getAttribute(
                                                                                                                        'content'
                                                                                                                    )
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                    dz.removeFile(
                                                                                                        mockFile
                                                                                                    );
                                                                                                    $(`#${optionId}`)
                                                                                                        .find(
                                                                                                            '.color-image-data'
                                                                                                        )
                                                                                                        .val(
                                                                                                            ""
                                                                                                        );
                                                                                                    updateStepJSON
                                                                                                        ();
                                                                                                });
                                                                                    }

                                                                                    dz.on("success",
                                                                                        function(
                                                                                            file,
                                                                                            response
                                                                                        ) {
                                                                                            $(`#${optionId}`)
                                                                                                .find(
                                                                                                    '.color-images'
                                                                                                )
                                                                                                .val(
                                                                                                    response
                                                                                                    .path
                                                                                                );
                                                                                            $(`#${optionId}`)
                                                                                                .find(
                                                                                                    '.color-image-data'
                                                                                                )
                                                                                                .val(
                                                                                                    response
                                                                                                    .path
                                                                                                );
                                                                                            updateStepJSON
                                                                                                ();
                                                                                        });

                                                                                    dz.on("removedfile",
                                                                                        function(
                                                                                            file) {
                                                                                            // Handled by dz-remove click event
                                                                                        });
                                                                                }
                                                                            });
                                                                    }
                                                                });
                                                            }


                                                            // Handle regular fields
                                                            else {
                                                                let $input = $fieldOptions.find(`[name="${key}"]`);
                                                                if ($input.length) {
                                                                    if ($input.attr('type') === 'checkbox') {
                                                                        $input.prop('checked', field[key]);
                                                                    } else {
                                                                        $input.val(field[key]);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                });
                                            }

                                            // Initialize Bootstrap collapse
                                            new bootstrap.Collapse(document.getElementById(contentId), {
                                                toggle: true
                                            });

                                            // Add event listener for toggle icon rotation
                                            $(`#${stepId} .toggle-icon`).on('click', function() {
                                                $(this).toggleClass('fa-chevron-down fa-chevron-up');
                                            });
                                        }
                                    });

                                    updateStepJSON();
                                }
            });

            $('body').on('click', '.save-edit-field', function(){
                
                var $this = $(this);
                updateStepJSON();
                var label = $this.parent().parent().find('.field-options').find('input[name="label"]').val();
                var fieldId = $this.parent().parent().parent().find('input[name="fieldId"]').val();
               
               
                const $targets = $this
                .parent().parent().parent().parent().parent().parent()
                .find('.extr-field .extra-add');
                var html = $targets.html();

               
                
                if ($targets.is('[data-id="'+fieldId+'"]')) {
                     var $target = $targets.filter('[data-id="'+fieldId+'"]');
                      $target.find('.extra-add-span').text(label);
                }

                $(this).closest('.edit-field').hide();
              
            })

            $('body').on('click', '.save-form-step', function(){
                let stepId = $(this).data('stepid');
                let nextStepId = $(this).data('nextstepid');

                var step = [];
                // // console.log('Steps before stringify:', steps);
                for (let index = 0; index < steps.length; index++) {
                    step = steps[index];
                    if(step["id"] != stepId){
                        continue;
                    }
                    let formData = new FormData();
                    /*formData.append('name', formName);
                    formData.append('slug', formSlug);*/
                    formData.append('step_index', index);
                    formData.append('steps', JSON.stringify(step));
                    /*formData.append('logic', JSON.stringify({}));*/
                    formData.append('_method', 'PUT');

                    // // console.log('FormData steps:', formData.get('steps'));
                    // console.log('Sending Step:', step);
                    // Return or stop further execution if needed
                    // return;

                    // // Debug: Log formData
                    // for (let pair of formData.entries()) {
                    //     // console.log(pair[0] + ': ' + pair[1]);
                    // }

                    // Handle color image uploads
                    let colorImageCount = 0;
                    $(".color-options-container input[name='color_images[]']").each(function(index) {
                        if (this.files && this.files[0]) {
                            let file = this.files[0];
                            formData.append('color_images[]', file);
                            colorImageCount++;

                            // Track which step and field this image belongs to
                            let stepIndex = $(this).closest('.card').index();
                            let fieldIndex = $(this).closest('.accordion').index();
                            let optionIndex = $(this).closest('.color-option').index();

                            formData.append('color_image_locations[]', JSON.stringify({
                                stepIndex: stepIndex,
                                fieldIndex: fieldIndex,
                                optionIndex: optionIndex
                            }));
                        }
                    });

                    // Update color image placeholders to real filenames
                    if (colorImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if (field.type === "colors" && field.colors) {
                                    field.colors.forEach(color => {
                                        if (color.imageData ===
                                            'upload_placeholder') {
                                            color.image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // 🔹 Append images and store their location in `image_url`
                    let whiteImageCount = 0;
                    let blackImageCount = 0;
                    let slideImageCount = 0;

                    // Handle white image uploads
                    $(".custom-radio-options-container input[name='option_white_image[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('white_images[]', file);
                                whiteImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('white_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });

                    // Handle black image uploads
                    $(".custom-radio-options-container input[name='option_black_image[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('black_images[]', file);
                                blackImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('black_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });


                     // Handle white image uploads
                    $(".custom-radio-options-container input[name='option_white_image_withHeadboard[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('white_images[]', file);
                                whiteImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('white_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });

                    // Handle black image uploads
                    $(".custom-radio-options-container input[name='option_black_image_withHeadboard[]']").each(
                        function(
                            index) {
                            if (this.files && this.files[0]) {
                                let file = this.files[0];
                                formData.append('black_images[]', file);
                                blackImageCount++;

                                // Track which step and field this image belongs to
                                let stepIndex = $(this).closest('.card').index();
                                let fieldIndex = $(this).closest('.accordion').index();
                                let optionIndex = $(this).closest('.custom-radio-option').index();

                                formData.append('black_image_locations[]', JSON.stringify({
                                    stepIndex: stepIndex,
                                    fieldIndex: fieldIndex,
                                    optionIndex: optionIndex
                                }));
                            }
                        });


                    // Handle slide image uploads
                    $(".slide-options-container input[name='slide_images[]']").each(function(index) {
                        if (this.files && this.files[0]) {
                            let file = this.files[0];
                            formData.append('slide_images[]', file);
                            slideImageCount++;

                            // Track which step and field this image belongs to
                            let stepIndex = $(this).closest('.card').index();
                            let fieldIndex = $(this).closest('.accordion').index();
                            let optionIndex = $(this).closest('.slide-option').index();

                            formData.append('slide_image_locations[]', JSON.stringify({
                                stepIndex: stepIndex,
                                fieldIndex: fieldIndex,
                                optionIndex: optionIndex
                            }));
                        }
                    });

                    // Update white image placeholders to real filenames
                    if (whiteImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if ((field.type === "custom_radio" || field.type ===
                                        "headboard_checkbox" || field.type ===
                                        "canopy_checkbox" || field.type ===
                                        "tray_sides_checkbox") && field.options) {
                                    field.options.forEach(option => {
                                        if (option.whiteImage ===
                                            'white_upload_placeholder') {
                                            option.white_image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                        if (option.whiteImage_withHeadboard ===
                                            'white_upload_placeholder') {
                                            option.white_image_url_withHeadboard =
                                                'new_upload'; // This will be updated on the server
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // Update black image placeholders to real filenames
                    if (blackImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if ((field.type === "custom_radio" || field.type ===
                                        "headboard_checkbox" || field.type ===
                                        "canopy_checkbox" || field.type ===
                                        "tray_sides_checkbox") && field.options) {
                                    field.options.forEach(option => {
                                        if (option.blackImage ===
                                            'black_upload_placeholder') {
                                            option.black_image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                        if (option.blackImage_withHeadboard ===
                                            'black_upload_placeholder') {
                                            option.black_image_url_withHeadboard =
                                                'new_upload';
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // Update slide image placeholders to real filenames
                    if (slideImageCount > 0) {
                        steps.forEach(step => {
                            step.fields.forEach(field => {
                                if (field.type === "slide_options" && field
                                    .slideOptions) {
                                    field.slideOptions.forEach(option => {
                                        if (option.imageData ===
                                            'slide_upload_placeholder') {
                                            option.image_url =
                                                'new_upload'; // This will be updated on the server
                                        }
                                    });
                                }
                            });
                        });
                    }

                    // Final cleanup and normalization of data before submission
                    if (step.fields) {
                        step.fields.forEach(field => {
                            if ((field.type === "custom_radio" || field.type ===
                                    "canopy_checkbox" || field.type ===
                                    "tray_sides_checkbox") && field.options) {
                                field.options.forEach(option => {
                                    // Ensure numeric values are properly formatted
                                    if (option.price !== undefined && option
                                        .price !== '') {
                                        option.price = parseFloat(option.price) ||
                                            0;
                                    } else {
                                        option.price = 0;
                                    }

                                    // Make sure we're not sending too much redundant data
                                    // If we have an image URL, make sure both URL formats are set correctly
                                    // _withHeadboard
                                    if (option.white_image_url && option
                                        .white_image_url !== 'new_upload') {
                                        option.whiteImage = option.white_image_url;
                                    } else if (option.whiteImage && option
                                        .whiteImage !==
                                        'white_upload_placeholder' && option
                                        .whiteImage !== 'new_upload') {
                                        option.white_image_url = option.whiteImage;
                                    }

                                    if (option.black_image_url && option
                                        .black_image_url !== 'new_upload') {
                                        option.blackImage = option.black_image_url;
                                    } else if (option.blackImage && option
                                        .blackImage !==
                                        'black_upload_placeholder' && option
                                        .blackImage !== 'new_upload') {
                                        option.black_image_url = option.blackImage;
                                    }

                                    // Convert boolean values properly
                                    option.isActive = !!option.isActive;
                                });
                            }

                            if ((field.type === "headboard_checkbox") && field.options) {
                                field.options.forEach(option => {
                                    // Ensure numeric values are properly formatted
                                    if (option.price !== undefined && option
                                        .price !== '') {
                                        option.price = parseFloat(option.price) ||
                                            0;
                                    } else {
                                        option.price = 0;
                                    }

                                    // Make sure we're not sending too much redundant data
                                    // If we have an image URL, make sure both URL formats are set correctly
                                    // _withHeadboard
                                    if (option.white_image_url && option
                                        .white_image_url !== 'new_upload') {
                                        option.whiteImage = option.white_image_url;
                                    } else if (option.whiteImage && option
                                        .whiteImage !==
                                        'white_upload_placeholder' && option
                                        .whiteImage !== 'new_upload') {
                                        option.white_image_url = option.whiteImage;
                                    }

                                    if (option.black_image_url && option
                                        .black_image_url !== 'new_upload') {
                                        option.blackImage = option.black_image_url;
                                    } else if (option.blackImage && option
                                        .blackImage !==
                                        'black_upload_placeholder' && option
                                        .blackImage !== 'new_upload') {
                                        option.black_image_url = option.blackImage;
                                    }

                                    if (option.white_image_url_withHeadboard && option
                                        .white_image_url_withHeadboard !== 'new_upload') {
                                        option.whiteImage = option.white_image_url_withHeadboard;
                                    } else if (option.whiteImage_withHeadboard && option
                                        .whiteImage_withHeadboard !==
                                        'white_upload_placeholder' && option
                                        .whiteImage_withHeadboard !== 'new_upload') {
                                        option.white_image_url_withHeadboard = option.whiteImage_withHeadboard;
                                    }

                                    if (option.black_image_url_withHeadboard && option
                                        .black_image_url_withHeadboard !== 'new_upload') {
                                        option.blackImage_withHeadboard = option.black_image_url_withHeadboard;
                                    } else if (option.blackImage_withHeadboard && option
                                        .blackImage_withHeadboard !==
                                        'black_upload_placeholder' && option
                                        .blackImage_withHeadboard !== 'new_upload') {
                                        option.black_image_url_withHeadboard = option.blackImage_withHeadboard;
                                    }

                                    // Convert boolean values properly
                                    option.isActive = !!option.isActive;
                                });
                            }
                            // Handle slide options data normalization
                            if (field.type === "slide_options" && field.slideOptions) {
                                field.slideOptions.forEach(option => {
                                    // Ensure quantity is a number
                                    if (option.quantity !== undefined && option
                                        .quantity !== '') {
                                        option.quantity = parseInt(option
                                            .quantity) || 1;
                                    } else {
                                        option.quantity = 1;
                                    }

                                    // Handle image data consistency
                                    if (option.image_url && option.image_url !==
                                        'new_upload') {
                                        option.imageData = option.image_url;
                                    } else if (option.imageData && option
                                        .imageData !== 'slide_upload_placeholder' &&
                                        option.imageData !== 'new_upload') {
                                        option.image_url = option.imageData;
                                    }
                                });
                            }
                            // Handle colors data normalization
                            if (field.type === "colors" && field.colors) {
                                field.colors.forEach(color => {
                                    // Ensure all required properties exist
                                    if (!color.name) color.name = '';
                                    if (!color.label) color.label = '';
                                    if (!color.image_url) color.image_url = null;
                                    if (!color.imageData) color.imageData = null;

                                    // Ensure consistency between image properties
                                    if (color.image_url && !color.imageData) {
                                        color.imageData = color.image_url;
                                    } else if (color.imageData && !color
                                        .image_url) {
                                        color.image_url = color.imageData;
                                    }
                                });
                            }
                        });
                    }

                    // Re-stringify the steps for sending to the server
                    formData.set('steps', JSON.stringify(step));

                    // // Debug: Log the final steps JSON before sending
                    // // console.log('Final steps JSON before submission:', steps);
                    // // console.log('Stringified steps:', JSON.stringify(steps));

                    // // Specifically log template values for each step
                    // steps.forEach((step, index) => {
                    //     // console.log(
                    //         `Step ${index+1} (${step.id}): Template value = "${step.template}"`);
                    // });

                    $.ajax({
                        url: "{{ route('forms-new.update', $form->id) }}",
                        type: "PUT",
                        data: JSON.stringify({
                            _method: "PUT",  // Laravel spoof method
                            step_index: index,
                            steps: step
                        }),
                        processData: false,
                        contentType: 'application/json',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        beforeSend: function() {
                            // Show loading indicator
                            /*Swal.fire({
                                title: 'Saving steps ',
                                html: 'Please wait while the form is being updated.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });*/
                        },
                        success: function(response) {
                            $('#'+stepId+' .form-message').text('Step updated successfully!');
                            setTimeout(() => {
                                if(nextStepId.trim() == "") {
                                    window.location.href="{{ route('forms-new.edit', $form->id) }}?submitted=true";
                                } else {
                                    $('.tab-link[data-tab="'+nextStepId+'"]').trigger('click');
                                }
                               $('#'+stepId+' .form-message').text('');
                            }, 1000);
                            // // console.log('Success Response:', response);
                            /*Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Step ' + (index + 1) + ' updated successfully!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {});*/


                            /*$('#edit-progress-bar').css('width', (((index + 1) / steps
                                .length) * 100) + '%');
                            $('#edit-progress-bar').attr('aria-valuenow', (((index + 1) /
                                steps.length) * 100));

                            $('#edit-progress-bar').text(Math.round((((index + 1) / steps
                                .length) * 100)) + '%');*/

                            //$('#save-message').text('Saving...');


                            if (((index + 1) / steps.length) * 100 == 100) {

                                $('#'+stepId).find('.save-message').text('Saved!');
                                setTimeout(() => {
                                    /*Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Updated successfully!',
                                    showConfirmButton: false,
                                    timer: 2000
                                    });*/
                                    /*$('#edit-progress-bar').css('width', '0%');
                                    $('#edit-progress-bar').attr('aria-valuenow',
                                        "0");
                                    $('.progress-outer').hide();*/
                                }, 2000);


                            }

                        },
                        error: function(xhr) {
                            console.error('Error Response:', xhr);
                            console.error('Response JSON:', xhr.responseJSON);
                            console.error('Response Text:', xhr.responseText);

                            let errorMessage = 'An error occurred while updating the form.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage += '\n' + Object.values(xhr.responseJSON
                                        .errors).flat()
                                    .join('\n');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                                customClass: {
                                    content: 'text-left'
                                }
                            });
                        }
                    });

                }
            });
        });

        $(document).ready(function () {
            /*$('.step-input-new').on('input', function () {
                const max = 20;
                const val = $(this).val();
                if (val.length > max) {
                    $(this).val(val.slice(0, max));
                }
            });*/

            $('body').on('click','.template-select', function(){
                var $this = $(this);
                var tempSelectionArray = [
                    {
                        "id": "0", 
                        "step-mainHeading" : 0,
                        "step-subheading" : 0,
                        "step-sideHeading" : 0,   
                    },
                     {
                        "id": "1", 
                        "step-mainHeading" : 1,
                        "step-subheading" : 1,
                        "step-sideHeading" : 1,   
                    },
                     {
                        "id": "2", 
                        "step-mainHeading" : 1,
                        "step-subheading" : 1,
                        "step-sideHeading" : 1,   
                    },
                     {
                        "id": "3", 
                        "step-mainHeading" : 1,
                        "step-subheading" : 1,
                        "step-sideHeading" : 0,   
                    },
                     {
                        "id": "4", 
                        "step-mainHeading" : 1,
                        "step-subheading" : 1,
                        "step-sideHeading" : 0,   
                    },
                ];

                tempSelectionArray.forEach(function( value,index){
                    if($this.val() == value.id){
                        console.log(value);
                        if(value["step-mainHeading"] == 1) {
                            $this.closest('.tab-content').find(".step-mainHeading").show();
                        } else {
                            $this.closest('.tab-content').find(".step-mainHeading").hide();
                        }

                         if(value["step-subheading"] == 1) {
                            $this.closest('.tab-content').find(".step-subheading").show();
                        } else {
                            $this.closest('.tab-content').find(".step-subheading").hide();
                        }

                         if(value["step-sideHeading"] == 1) {
                            $this.closest('.tab-content').find(".step-sideHeading").show();
                        } else {
                            $this.closest('.tab-content').find(".step-sideHeading").hide();
                        }
                        
                    }
                });
                
            });
            
        });
    </script>
@endsection
