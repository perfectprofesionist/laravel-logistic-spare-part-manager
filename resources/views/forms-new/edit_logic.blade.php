@extends('layouts.app_new')

@section('content')
<div class="">
    <div class="craete-form-outer-panel">
        <div class="col-12 pade-none create-heading-con">
            <h2>Edit Condition</h2>
            <div class="create-form-CTA auto-width">
                <a href="{{ route('form.conditions', ['id' => $logic->form_id]) }}">
                    <img src="{{ asset('images') . '/back-bttn-icon.svg' }}" alt="Back"> Back
                </a>
            </div>
        </div>

        <div class="col-12 pade-none cont-conditions-added">
            <div class="col-12 pade-none cont-new-condition">
                <form id="edit-logic-form" method="POST" action="{{ route('form.logic.update', $logic->id) }}">
                    @csrf
                    @method('PUT') <!-- Use PUT or PATCH if your route requires it -->

                    <div class="col-12 otr-form-field">
                        <h4>Condition Name</h4>
                        <div class="col-12 otr-single-field">
                            <input class="form-field" type="text" name="condition_name" value="{{ $logic->name }}" placeholder="Condition Name">
                            <span class="error-message text-danger" style="display:none;"></span>
                        </div>
                    </div>

                    <div class="col-12 otr-form-field">
                        <h4>Select Condition</h4>
                        <label>Depends Upon</label>
                        <pre style="display:none;">{{ $logic->recipe_id }}</pre>
                        <div class="col-12 otr-single-field">
                            {{--
                            <label class="otr-radio">Make vs Model
                                <input type="radio" name="conditionOptions" value="1" {{ $logic->recipe_id == 1 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <label class="otr-radio">Model vs Year
                                <input type="radio" name="conditionOptions"  value="2" {{ $logic->recipe_id == 2 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            --}}
                            <label class="otr-radio">Canopy Length vs Product Length
                                <input type="radio" name="conditionOptions" value="5" {{ $logic->recipe_id == 5 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        
                        <label>Show/Hide Condition</label>
                        <div class="col-12 otr-single-field">
                            <label class="otr-radio">Field to Field
                                <input type="radio" name="conditionOptions" value="3" {{ $logic->recipe_id == 3 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <label class="otr-radio">Field to Step
                                <input type="radio" name="conditionOptions" value="4" {{ $logic->recipe_id == 4 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <label class="otr-radio">Truck Type to Product
                                <input type="radio" name="conditionOptions" value="6" {{ $logic->recipe_id == 6 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                             <label class="otr-radio">Canopy to Product
                                <input type="radio" name="conditionOptions" value="7" {{ $logic->recipe_id == 7 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <label class="otr-radio">Product Notice
                                <input type="radio" name="conditionOptions" value="8" {{ $logic->recipe_id == 8 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <label>miscellaneous</label>
							<div class="col-12 otr-single-field">
								<label class="otr-radio">Canopy Length Capacity
								  <input type="radio" name="conditionOptions"  value="9" {{ $logic->recipe_id == 9 ? 'checked' : '' }}>
								  <span class="checkmark"></span>
								</label>
                            </div>

                        <div class="col-12 cont-conditions-fields">
                            <h4>Condition you selected</h4>
                            <div id="logic-container">
                                {{-- Existing logic HTML will be injected here --}}
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="logic_json" id="logic-json">
                    <input type="hidden" name="logic_id" id="logic_id" value="{{ $logic->id }}">

                    <div class="d-flex align-items-start gap-4 save-form-bttn">
                        <button type="submit" class="btn btn-primary">Save Condition</button>
                        <div class="update-status ms-3 text-success fw-bold fs-6"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$canopyNames = [];
foreach ($form->steps as $step) {
    foreach ($step["fields"] as $field) {
        if ($field["type"] == "canopy_radio") {
            foreach ($field["options"] as $option) {
                $canopyNames[] = $option["text"];
            }
        }
    }
}
?>
{{-- Assuming JS from the create form is already included or available --}}
<script>
    const recipes = @json($recipes);
    const form = @json($form);
    const products = @json($products);
    var logicData = @json($logic->parameters);
    const allFields = [];
    const formSteps = [];
    const productNames = [];
    const formId = $('#form-id').val();
    const canopyNames = @json($canopyNames);
    $.each(form.steps, function (index, step) {
        formSteps.push(step); 
        if (Array.isArray(step.fields)) {
            $.each(step.fields, function (i, field) {
                //allFields.push({ id: field.id, type: field.type });
                allFields.push({ id: field.id, type: field.type, name: field.label });
            });
        }
    });

    console.log("allFields",allFields)
    console.log("formSteps",formSteps)

    $.each(products, function (index, product) {
        productNames.push(product.name);
    });
    console.log("Product Names:", productNames);

    function updateLogicContainer(recipeId) {
        const logicContainer = $('#logic-container');
        
        
        // Check if the recipe exists and load its logic code
        if (recipes[recipeId]) {
            console.log('Injected Code:', recipes[recipeId].code);
            logicContainer.html(recipes[recipeId].code || '<p style="color:red;">No logic found for this condition.</p>');

            // Reset the dropdown and add the "Select Field" placeholder
            $('#logic-container .paraSelect').each(function () {
                const $select = $(this);
                const firstOptionText = $select.find('option:first').text().trim().toLowerCase();

                $select.find('option.dynamic-option').remove(); // Remove previously added dynamic options

                if (firstOptionText === 'select product name') {
                    $.each(productNames, function (index, name) {
                        const option = $('<option class="dynamic-option"></option>').val(name).text(name);
                        $select.append(option);
                    });

                } else if (firstOptionText === 'select step') {
                    $.each(form.steps, function (index, step) {
                        const option = $('<option class="dynamic-option"></option>').val(step.id).text(`${step.title} (${step.id})`);
                        $select.append(option);
                    });

                } else {
                    let targetType = null;
                    if (firstOptionText.includes('make')) targetType = 'make';
                    else if (firstOptionText.includes('model')) targetType = 'model';
                    else if (firstOptionText.includes('year')) targetType = 'year';
                    else if (firstOptionText.includes('select field')) targetType = 'all';

                    if (!targetType) return;

                    $.each(allFields, function (index, field) {
                        if (targetType === 'all' || field.type.toLowerCase() === targetType) {
                            const option = $('<option class="dynamic-option"></option>').val(field.id).text(`${field.name} (${field.id})`);
                            $select.append(option);
                        }
                    });
                }
            });


            // Pre-fill the fields with existing data (logicData)
            if (logicData) {
                if (typeof logicData === 'string') {
                    logicData = JSON.parse(logicData);
                }

                console.log("logicdata", logicData);
                Object.keys(logicData).forEach(function(key) {
                    const value = logicData[key];
                    const $input = $('.parameter-' + key + '.paraSelect');
                    console.log("value", value);
                    console.log("input", $input);

                    if ($input.length) {
                        $input.val(value).trigger('change'); // trigger if it's select2 or similar
                        console.log('Filling parameter-' + key + ':', $input);
                    } else {
                        console.warn('No element found for parameter-' + key);
                    }
                });
            }

            if($('#logic-container .canopy-table tbody').length > 0) { 
                var html = "";
                canopyNames.forEach(function(value, index) {
                    html += `<tr>
                        <td>${value}</td>
                        <td><input type="text" data-id= "${value}" name="length_units[${value}]" class="length-input" value=""></td>
                    </tr>`;
                });

                $('#logic-container .canopy-table tbody').html(html);


                if (logicData) {
                    if (typeof logicData === 'string') {
                        logicData = JSON.parse(logicData);
                    }

                    console.log("logicdata", logicData);
                    Object.keys(logicData).forEach(function(key) {
                        const value = logicData[key];
                        const $input = $(`[name="length_units[${key}]"]`);
                        console.log("value", value);
                        console.log("input", $input);

                        if ($input.length) {
                            $input.val(value).trigger('change'); // trigger if it's select2 or similar
                            console.log('Filling parameter-' + key + ':', $input);
                        } else {
                            console.warn('No element found for parameter-' + key);
                        }
                    });
                }
            }

        } else {
            logicContainer.html('<p style="color:red;">No logic found for this recipe.</p>');
        }
    }


 $(document).ready(function () {

    // Ensure we select the radio button correctly
    const selected = $('input[name="conditionOptions"]:checked').val();
    console.log('Selected condition option on page load:', selected); // Log the selected value
    if (selected) updateLogicContainer(selected);

    // Event listener for radio button change
    $('input[name="conditionOptions"]').on('change', function () {
        const selectedRecipeId = $(this).val();
        console.log('Selected Recipe ID on change:', selectedRecipeId); // Log the selected value

        updateLogicContainer(selectedRecipeId);
    });

    // Form submission handling
   $('#edit-logic-form').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission
        const logicData = {}; 
        
        let isConditionNameValid = true;  // Flag for condition_name validation

        $('.error-message').hide().text('');

        const conditionName = $('input[name="condition_name"]').val();
        const logicid = $('input[name="logic_id"]').val();

        if (!conditionName) {
            isConditionNameValid = false;
            $('input[name="condition_name"]').next('.error-message').text('Condition Name is required.').show();
        }

        $('#logic-container .automation-item').each(function () {
            const param1 = $(this).find('.parameter-1').val();
            const param2 = $(this).find('.parameter-2').val();
            const param3 = $(this).find('.parameter-3').val();
            const param4 = $(this).find('.parameter-4').val();

            console.log('Param 1:', param1);
            console.log('Param 2:', param2);
            console.log('Param 3:', param3);
            console.log('Param 4:', param4);

            if (param1 || param2 || param3 || param4) {
                if (param1) logicData["1"] = param1;
                if (param2) logicData["2"] = param2;
                if (param3) logicData["3"] = param3;
                if (param4) logicData["4"] = param4;
            }
        });

        if (!isConditionNameValid) {
            return; // Stop the form submission
        }

           if($('#logic-container .canopy-table').length > 0) {
                canopyNames.forEach(function(value, index) {
                    logicData[value] = $(`[name="length_units[${value}]"]`).val();
                });
            }

        console.log('Logic Data:', logicData);  // Log final logic data
        const recipeId = $('input[name="conditionOptions"]:checked').val();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        // var idlogic = "{{ $logic->id }}";
        // console.log("idlogic",idlogic);
        // Send AJAX request
        $.ajax({
            url: "{{ route('form.logic.update', ['id' => $logic->id]) }}",  // Ensure this route is correct
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                logic_id: logicid,
                recipe_id: recipeId,
                logic_json: JSON.stringify(logicData),
                condition_name: conditionName  
            },
            success: function (response) {
                console.log("Success:", response);
                if (response.success) {
                    $('.update-status').text(response.message); // Show backend message

                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 1500); // Redirect after 1.5 seconds
                } else {
                    $('.update-status')
                        .text('Something went wrong.')
                        .removeClass('text-success')
                        .addClass('text-danger');
                }
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                alert('Something went wrong while saving logic.');
            }
        });
    });
});

</script>
@endsection
