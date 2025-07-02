@extends('layouts.app_new')

@section('content')


    <div class="">

             <!--Create Form Screen -->
              <!--div class="create-form-outer">
                  <div class="create-form-left"><img src="images/form-pic.png" alt="Form Icon"></div>
                  <div class="create-form-right">
                    <h2>Create Form <span><img src="images/create-form-icon.png" alt="arrow"></span></h2>
                  </div>
              </div-->


              <!--Create Form Screen 02 -->
              <div class="craete-form-outer-panel">
                <div class="col-12 pade-none create-heading-con">
                  <h2>Forms</h2>
                  <div class="create-form-CTA auto-width"><a href="{{ route('form.conditions', ['id' => $form['id']]) }}"><img src="{{ asset('images') . '/back-bttn-icon.svg' }}" alt="Plus"> Back</a></div>
                </div>
                <div class="col-12 pade-none cont-conditions-added">
					<div class="col-12 pade-none cont-new-condition">
                        <form id="logic-form" method="POST" action="{{ route('form.logic.store') }}">
                        @csrf
						<div class="col-12 otr-form-field">
							<h4>Condition Name</h4>
							<div class="col-12 otr-single-field">
								<input class="form-field" type="text" name="condition_name" value="" placeholder="Condition Name">
                                <span class="error-message text-danger" style="display:none;"></span>
							</div>
						</div>
						<div class="col-12 otr-form-field">
							<h4>Select Condition</h4>
							<label>Depends Upon</label>
							<div class="col-12 otr-single-field">
								{{--
                                <label class="otr-radio">Make vs Model
								  <input type="radio" name="conditionOptions"  value="1">
								  <span class="checkmark"></span>
								</label>
								<label class="otr-radio">Model vs Year
								  <input type="radio" name="conditionOptions"  value="2">
								  <span class="checkmark"></span>
								</label>
                                --}}
								<label class="otr-radio">Canopy Length vs Product Length
								  <input type="radio" name="conditionOptions" value="5">
								  <span class="checkmark"></span>
								</label>
							</div>
                            
							<label>Show/Hide Condition</label>
							<div class="col-12 otr-single-field">
								<label class="otr-radio">Field to Field
								  <input type="radio" name="conditionOptions"  value="3">
								  <span class="checkmark"></span>
								</label>
								<label class="otr-radio">Field to Step
								  <input type="radio" name="conditionOptions" value="4">
								  <span class="checkmark"></span>
								</label>
								<label class="otr-radio">Truck Type to Product
								  <input type="radio" name="conditionOptions" value="6">
								  <span class="checkmark"></span>
								</label>
                                <label class="otr-radio">Canopy to Product
								  <input type="radio" name="conditionOptions" value="7">
								  <span class="checkmark"></span>
								</label>
								<label class="otr-radio">Product Notice
								  <input type="radio" name="conditionOptions" value="8">
								  <span class="checkmark"></span>
								</label>
							</div>
                          
                            <label>miscellaneous</label>
							<div class="col-12 otr-single-field">
								<label class="otr-radio">Canopy Length Capacity
								  <input type="radio" name="conditionOptions"  value="9">
								  <span class="checkmark"></span>
								</label>
                            </div>
                          

							<div class="col-12 cont-conditions-fields">
								<h4>Condition you selected</h4>
								<div id="logic-container">
							    </div>
							</div>
							
						</div>
                          <input type="hidden" name="logic_json" id="logic-json">

                        <div class="d-flex align-items-start gap-4  save-form-bttn"> 
                            <button type="submit" class="btn btn-primary">Save Condition</button>
                            <div class="save-status ml-3 ms-3 text-success fw-bold fs-6"></div>
                        </div>

						<!-- <div class="col-12 otr-bttn"><a class="save-continue-bttn" href="#">Save & Continue <img src="{{ asset('images') . '/save-bttn-icon.svg' }}" alt="Plus"></a></div> -->
					</form>
                    </div>
				</div>

              <!--Create Form Screen 03 -->
<input type="hidden" name="form_id" id="form-id" value="{{ $form['id'] }}">

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
<script>
    const recipes = @json($recipes);
    const products = @json($products);
    const form = @json($form);
    const allFields = [];  
    const formSteps = [];
    const productNames = [];
    const formId = $('#form-id').val();
    const canopyNames = @json($canopyNames);
    $.each(form.steps, function (index, step) {
        formSteps.push(step); 

        if (Array.isArray(step.fields)) {
            $.each(step.fields, function (index, field) {
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

        console.log(140);
        const logicContainer = $('#logic-container');
        logicContainer.html(recipes[recipeId]?.code || '<p style="color:red;">No logic found for this condition.</p>');

        $('#logic-container select.paraSelect').each(function () {
            const $select = $(this);
            const firstOptionText = $select.find('option:first').text().trim().toLowerCase();

            // Remove all previously added dynamic options
            $select.find('option.dynamic-option').remove();

            if (firstOptionText === 'select product name') {
                // Populate product names
                $.each(productNames, function (index, name) {
                    const option = $('<option class="dynamic-option"></option>')
                        .val(name)
                        .text(name);
                    $select.append(option);
                });

            } else if (firstOptionText === 'select step') {
                // Populate steps
                $.each(formSteps, function (index, step) {
                    const option = $('<option class="dynamic-option"></option>')
                        .val(step.id)
                        .text(`${step.title} (${step.id})`);
                    $select.append(option);
                });

            } else {
                // Determine field type from placeholder
                let targetType = null;
                if (firstOptionText.includes('make')) targetType = 'make';
                else if (firstOptionText.includes('model')) targetType = 'model';
                else if (firstOptionText.includes('year')) targetType = 'year';
                else if (firstOptionText.includes('select field')) targetType = 'all';

                if (!targetType) return;

                // Append matching field types
                $.each(allFields, function (index, field) {
                    if (targetType === 'all' || field.type.toLowerCase() === targetType) {
                        const option = $('<option class="dynamic-option"></option>')
                            .val(field.id)
                            .text(`${field.name} (${field.id})`);
                        $select.append(option);
                    }
                });
            }
            
        });

        if($('#logic-container .canopy-table tbody').length > 0) { 
            var html = "";
            canopyNames.forEach(function(value, index) {
                html += `<tr>
                    <td>${value}</td>
                    <td><input type="text" data-id= "${value}" name="length_units[${value}]" class="length-input" value=""></td>
                </tr>`;
            });

            $('#logic-container .canopy-table tbody').html(html);
        }
    }



    // function updateLogicContainer(recipeId) {
    //     const logicContainer = $('#logic-container');
    //     logicContainer.html(recipes[recipeId]?.code || '<p style="color:red;">No logic found for this condition.</p>');

    //     $('#logic-container select.paraSelect').each(function () {
    //         const $select = $(this);
    //         const firstOptionText = $select.find('option:first').text().trim().toLowerCase();

    //         // Clear existing options except the first
    //           $select.find('option.dynamic-option').remove();

    //         // Determine what to show
    //         let targetType = null;
    //         if (firstOptionText.includes('make')) targetType = 'make';
    //         else if (firstOptionText.includes('model')) targetType = 'model';
    //         else if (firstOptionText.includes('year')) targetType = 'year';
    //         else if (firstOptionText.includes('select field')) targetType = 'all';

    //         if (!targetType) return;

    //         // Append options based on match
    //         $.each(allFields, function (index, field) {
    //             if (targetType === 'all' || field.type.toLowerCase() === targetType) {
    //                 const option = $('<option></option>')
    //                     .val(field.id)
    //                     .text(`${field.type} (${field.id})`);
    //                 $select.append(option);
    //             }
    //         });
    //     });
    // }


    $(document).ready(function () {
        const initialDepends = $('input[name="Depends"]:checked').val();
        const initialHideShow = $('input[name="HideShow"]:checked').val();

        if (initialDepends) updateLogicContainer(initialDepends);
        if (initialHideShow) updateLogicContainer(initialHideShow);

        // Add event listeners to radio buttons
        $('input[name="conditionOptions"]').on('change', function () {
            updateLogicContainer($(this).val());
            
        });


 $('#logic-form').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission
    const logicData = {}; 
    
     let isConditionNameValid = true;  // Flag for condition_name validation

    $('.error-message').hide().text('');

    const conditionName = $('input[name="condition_name"]').val();

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
    console.log('conditionName: ', conditionName );
    
    const recipeId = $('input[name="conditionOptions"]:checked').val();
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    console.log('data: ', {
            form_id: formId,
            recipe_id: recipeId,
            logic_json: JSON.stringify(logicData),
            condition_name: conditionName  
        } );


    
    // Send AJAX request
    $.ajax({
        url: "{{ route('form.logic.store') }}",  // Ensure this route is correct
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            form_id: formId,
            recipe_id: recipeId,
            logic_json: JSON.stringify(logicData),
            condition_name: conditionName  
        },
        success: function (response) {
            console.log("Success:", response);
            if (response.success) {
                $('.save-status').remove(); // Remove existing message if any

                // Insert backend message below the Save button
                $('<div class="save-status" style="color: green; margin-top: 10px;">' + response.message + '</div>')
                    .insertAfter('.btn.btn-primary');

                setTimeout(function () {
                    //uncomment
                    window.location.href = response.redirect_url;
                }, 1500); // Wait 1.5 seconds before redirecting
            } else {
                alert('Something went wrong.');
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr.responseText);
            alert('Something went wrong while saving logic.');
        }
    });
});

       
    });

   // function updateLogicContainer(recipeId) {
    //     const logicContainer = $('#logic-container');
    //     logicContainer.html(recipes[recipeId]?.code || '<p style="color:red;">No logic found for this condition.</p>');

    //     // Clear existing options if any
    //       $('#logic-container select.paraSelect').each(function () {
    //         const $select = $(this);
    //         const firstOption = $select.find('option:first').text().trim();

    //         if (firstOption === 'Select Field') {
    //             // Clear existing options except the first one
    //             $select.find('option:not(:first)').remove();

    //             // Append allFields as options
    //             $.each(allFields, function (index, field) {
    //                 const option = $('<option></option>')
    //                     .val(field.id)
    //                     .text(`${field.type} (${field.id})`);
    //                 $select.append(option);
    //             });
    //         }
    //     });
    // }

</script>


@endsection



