@extends('layouts.app')

@section('content')
    <div class="container py-4">

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
            <input type="text" id="formName" class="form-control" placeholder="Enter form name" value="{{ $form->name ?? '' }}">
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
                <i class="fa fa-save"></i> Update Form
            </button>
        </div>

    </div>
@endsection

@section('customScript')
    <script>
        $(document).ready(function() {
            let stepCount = 0;
            let fieldCount = 0;
            let steps = @json($form->steps ?? []);

            // Field types configuration
            const fieldTypes = {
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
                            <input type="number" class="form-control field-input" name="rows" value="3" min="1" max="10">
                        </div>
                    `
                },
                number: {
                    label: 'Number Input',
                    template: `
                        <div class="mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Min Value</label>
                            <input type="number" class="form-control field-input" name="min" placeholder="Enter minimum value">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Max Value</label>
                            <input type="number" class="form-control field-input" name="max" placeholder="Enter maximum value">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Step</label>
                            <input type="number" class="form-control field-input" name="step" value="1" min="0.1">
                        </div>
                    `
                },
                select: {
                    label: 'Select Dropdown',
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
                            <label class="form-label">Default Checked</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input field-input" name="checked">
                            </div>
                        </div>
                    `
                },
                radio: {
                    label: 'Radio Buttons',
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
                date: {
                    label: 'Date Input',
                    template: `
                        <div class="mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Min Date</label>
                            <input type="date" class="form-control field-input" name="min">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Max Date</label>
                            <input type="date" class="form-control field-input" name="max">
                        </div>
                    `
                },
                file: {
                    label: 'File Upload',
                    template: `
                        <div class="mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" class="form-control field-input" name="label" placeholder="Enter label">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Accepted File Types</label>
                            <input type="text" class="form-control field-input" name="accept" placeholder="e.g., .pdf,.doc,.docx">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Max File Size (MB)</label>
                            <input type="number" class="form-control field-input" name="max_size" value="5" min="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Multiple Files</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input field-input" name="multiple">
                            </div>
                        </div>
                    `
                }
            };

            function updateStepJSON() {
                steps = [];
                $(".add_Step .card").each(function(index) {
                    let stepId = $(this).attr("id");
                    let stepTitle = $(this).find(".step-title").text();
                    let stepData = {
                        id: stepId,
                        title: stepTitle,
                        order: index,
                        label: $(this).find('input[placeholder="Enter form name"]').val(),
                        mainHeading: $(this).find('input[placeholder="Enter main heading"]').val(),
                        subheading: $(this).find('input[placeholder="Enter subheading"]').val(),
                        sideHeading: $(this).find('input[placeholder="Enter side heading"]').val(),
                        template: $(this).find('.template-select').val(),
                        fields: []
                    };

                    // Get fields in this step
                    $(this).find(".field-container .accordion").each(function() {
                        let fieldId = $(this).attr("id").replace("accordion-", "");
                        let fieldType = $(this).find('.field-type-select').val();
                        let fieldData = {
                            id: fieldId,
                            type: fieldType,
                            required: $(this).find('input[name="required"]').is(':checked')
                        };

                        // Get common field properties
                        $(this).find('.field-input').each(function() {
                            let name = $(this).attr('name');
                            let value = $(this).val();
                            if (name === 'checked' || name === 'multiple' || name === 'required') {
                                fieldData[name] = $(this).is(':checked');
                            } else if (value !== '') {
                                fieldData[name] = value;
                            }
                        });

                        stepData.fields.push(fieldData);
                    });

                    steps.push(stepData);
                });

                console.log("Updated Steps:", steps);
            }

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

                let stepTemplate = `
                    <div class="card shadow-sm border-0 mb-3" id="${stepId}">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold step-title">Step ${stepCount}</span>
                            <div>
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
                                        <input type="text" class="form-control" placeholder="Enter form name" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Main Heading:</label>
                                        <input type="text" class="form-control" placeholder="Enter main heading" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Subheading:</label>
                                        <input type="text" class="form-control" placeholder="Enter subheading" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Side Heading:</label>
                                        <input type="text" class="form-control" placeholder="Enter side heading" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="fw-bold">Template:</label>
                                        <select class="form-select template-select">
                                            <option value="1" data-image="{{ asset('assets/template_image/template1.png') }}">Template 1</option>
                                            <option value="2" data-image="{{ asset('assets/template_image/template2.png') }}">Template 2</option>
                                            <option value="3" data-image="{{ asset('assets/template_image/template3.png') }}">Template 3</option>
                                            <option value="4" data-image="{{ asset('assets/template_image/template4.png') }}">Template 4</option>
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
                    toggle: true
                });

                // Add event listener for toggle icon rotation
                $(`#${stepId} .toggle-icon`).on('click', function() {
                    $(this).toggleClass('fa-chevron-down fa-chevron-up');
                });

                updateStepJSON();

                // Reinitialize sortable after adding a new step
                $(".add_Step").sortable("refresh");
            });

            // Add field to a specific step
            $(document).on("click", ".addField", function() {
                fieldCount++;
                let fieldId = `field-${fieldCount}`;
                let stepCard = $(this).closest('.card');

                let fieldTemplate = `
                <div class="accordion mt-2" id="accordion-${fieldId}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-${fieldId}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-${fieldId}" aria-expanded="true" aria-controls="collapse-${fieldId}">
                                <span class="field-label">New Field</span>
                            </button>
                        </h2>
                        <div id="collapse-${fieldId}" class="accordion-collapse collapse show"
                            aria-labelledby="heading-${fieldId}" data-bs-parent="#accordion-${fieldId}">
                            <div class="accordion-body">
                                <div class="d-flex flex-column gap-2">
                                    <div class="mb-3">
                                        <label class="form-label">Field Type</label>
                                        <select class="form-select field-type-select">
                                            <option value="text">Text Input</option>
                                            ${Object.entries(fieldTypes).filter(([type]) => type !== 'text').map(([type, config]) =>
                                                `<option value="${type}">${config.label}</option>`
                                            ).join('')}
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Required</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="required">
                                        </div>
                                    </div>
                                    <div class="field-options">
                                        <!-- Field type specific options will be loaded here -->
                                    </div>
                                    <button class="btn btn-danger btn-sm removeField mt-2">
                                        <i class="fa fa-trash"></i> Remove Field
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                // Append the field to the field container of the step
                stepCard.find(".field-container").append(fieldTemplate);

                // Load field type specific options
                const $fieldOptions = stepCard.find(`#accordion-${fieldId} .field-options`);
                $fieldOptions.html(fieldTypes.text.template);

                // Add event listener for label changes
                stepCard.find(`#accordion-${fieldId} input[name="label"]`).on('input', function() {
                    const label = $(this).val() || 'New Field';
                    $(this).closest('.accordion').find('.field-label').text(label);
                });

                updateStepJSON();
            });

            // Handle field type change
            $(document).on("change", ".field-type-select", function() {
                const $fieldOptions = $(this).closest('.accordion-body').find('.field-options');
                const fieldType = $(this).val();
                $fieldOptions.html(fieldTypes[fieldType].template);

                // Add label change listener
                $fieldOptions.find('input[name="label"]').on('input', function() {
                    const label = $(this).val() || 'New Field';
                    $(this).closest('.accordion').find('.field-label').text(label);
                });

                updateStepJSON();
            });

            // Handle field input changes
            $(document).on("change input", ".field-input", function() {
                updateStepJSON();
            });

            $(document).on("click", ".removeField", function() {
                $(this).closest(".accordion").remove();
                updateStepJSON();
            });

            $(document).on("change", ".template-select", function() {
                const selectedTemplate = $(this).val();
                const templateImage = $(this).find("option:selected").data("image");
                $(".template-preview").attr("src", templateImage);
            });

            // Initialize form with existing data
            if (steps && steps.length > 0) {
                steps.forEach(function(step) {
                    stepCount++;
                    let stepId = step.id || `step-${stepCount}`;
                    let contentId = `content-${stepCount}`;

                    let stepTemplate = `
                        <div class="card shadow-sm border-0 mb-3" id="${stepId}">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <span class="fw-bold step-title">${step.title || `Step ${stepCount}`}</span>
                                <div>
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
                                            <input type="text" class="form-control" placeholder="Enter form name" value="${step.label || ''}" />
                                        </div>
                                        <div class="mb-2">
                                            <label class="fw-bold">Main Heading:</label>
                                            <input type="text" class="form-control" placeholder="Enter main heading" value="${step.mainHeading || ''}" />
                                        </div>
                                        <div class="mb-2">
                                            <label class="fw-bold">Subheading:</label>
                                            <input type="text" class="form-control" placeholder="Enter subheading" value="${step.subheading || ''}" />
                                        </div>
                                        <div class="mb-2">
                                            <label class="fw-bold">Side Heading:</label>
                                            <input type="text" class="form-control" placeholder="Enter side heading" value="${step.sideHeading || ''}" />
                                        </div>
                                        <div class="mb-2">
                                            <label class="fw-bold">Template:</label>
                                            <select class="form-select template-select">
                                                <option value="1" data-image="{{ asset('assets/template_image/template1.png') }}" ${step.template === '1' ? 'selected' : ''}>Template 1</option>
                                                <option value="2" data-image="{{ asset('assets/template_image/template2.png') }}" ${step.template === '2' ? 'selected' : ''}>Template 2</option>
                                                <option value="3" data-image="{{ asset('assets/template_image/template3.png') }}" ${step.template === '3' ? 'selected' : ''}>Template 3</option>
                                                <option value="4" data-image="{{ asset('assets/template_image/template4.png') }}" ${step.template === '4' ? 'selected' : ''}>Template 4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Right Column (Template Image) -->
                                    <div class="col-md-6 text-left">
                                        <div class="fw-bold">Template Preview:</div>
                                        <img class="template-preview img-fluid rounded shadow-sm"
                                            src="{{ asset('assets/template_image/template') }}${step.template || '1'}.png"
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

                    // Add existing fields
                    if (step.fields && step.fields.length > 0) {
                        step.fields.forEach(function(field) {
                            fieldCount++;
                            let fieldId = field.id || `field-${fieldCount}`;
                            let stepCard = $(`#${stepId}`);

                            let fieldTemplate = `
                            <div class="accordion mt-2" id="accordion-${fieldId}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-${fieldId}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-${fieldId}" aria-expanded="true" aria-controls="collapse-${fieldId}">
                                            <span class="field-label">${field.label || 'New Field'}</span>
                                        </button>
                                    </h2>
                                    <div id="collapse-${fieldId}" class="accordion-collapse collapse show"
                                        aria-labelledby="heading-${fieldId}" data-bs-parent="#accordion-${fieldId}">
                                        <div class="accordion-body">
                                            <div class="d-flex flex-column gap-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Field Type</label>
                                                    <select class="form-select field-type-select">
                                                        <option value="text" ${field.type === 'text' ? 'selected' : ''}>Text Input</option>
                                                        ${Object.entries(fieldTypes).filter(([type]) => type !== 'text').map(([type, config]) =>
                                                            `<option value="${type}" ${field.type === type ? 'selected' : ''}>${config.label}</option>`
                                                        ).join('')}
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Required</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="required" ${field.required ? 'checked' : ''}>
                                                    </div>
                                                </div>
                                                <div class="field-options">
                                                    <!-- Field type specific options will be loaded here -->
                                                </div>
                                                <button class="btn btn-danger btn-sm removeField mt-2">
                                                    <i class="fa fa-trash"></i> Remove Field
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                            stepCard.find(".field-container").append(fieldTemplate);

                            // Load field type specific options with existing values
                            const $fieldOptions = stepCard.find(`#accordion-${fieldId} .field-options`);
                            $fieldOptions.html(fieldTypes[field.type].template);

                            // Set existing field values
                            Object.keys(field).forEach(function(key) {
                                if (key !== 'id' && key !== 'type') {
                                    let $input = $fieldOptions.find(`[name="${key}"]`);
                                    if ($input.length) {
                                        if ($input.attr('type') === 'checkbox') {
                                            $input.prop('checked', field[key]);
                                        } else {
                                            $input.val(field[key]);
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

            $("#saveFormBtn").click(function() {
                let formName = $("#formName").val();
                if (!formName) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please enter a form name!',
                    });
                    return;
                }

                // Debug: Log the steps array before stringifying
                console.log('Steps before stringify:', steps);

                let formData = new FormData();
                formData.append('name', formName);
                formData.append('steps', JSON.stringify(steps));
                formData.append('logic', JSON.stringify({}));
                formData.append('_method', 'PUT'); // Add this for PUT request

                // Debug: Log the form data
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                $.ajax({
                    url: "{{ route('forms.update', $form->id) }}",
                    type: "POST", // Keep as POST, but we're using _method for PUT
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Form updated successfully!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "{{ route('forms.index') }}";
                        });
                    },
                    error: function(xhr) {
                        console.log('Error Response:', xhr.responseJSON);
                        let errorMessage = 'An error occurred while updating the form.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage += '\n' + Object.values(xhr.responseJSON.errors).flat().join('\n');
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
            });
        });
    </script>
@endsection
