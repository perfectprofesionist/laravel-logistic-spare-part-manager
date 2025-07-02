{{--
    Create Model Page (model/create.blade.php)
    
    This template provides a form for creating a new car model, including make selection,
    model details, truck type, price, and a tag-based input for series/years.
--}}

@extends('layouts.app_new')

@section('content')
    <div class="craete-form-outer-panel">
        <div class="row">
            {{-- Page header --}}
            <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
                <h2>Create New Model</h2>
             </div>

             <div class="d-flex">
                {{-- Form card --}}
                <div class="w-100 card shadow-lg  makes1-card create-make-name-con card-margin-outer">

                {{-- Model creation form --}}
                <form action="{{ route('model.store') }}" method="POST" id="modelForm">
                    @csrf
                    <div class="card shadow-lg w-100 makes-card">
                        {{-- Make and Model fields --}}
                        <div class="row mb-3 make-createcard-outer">
                            <div class="col-md-6 make-create-card">
                                <label class="form-label">Select Make</label>
                                <select name="make_id" id="make_id" class="form-select" required>
                                    <option value="" disabled selected>Select a Make</option>
                                    @foreach ($makes as $make)
                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger d-none" id="make-message">Please select a make first.</small>
                            </div>
                            <div class="col-md-6 make-create-card">
                                <label class="form-label">Model Name</label>
                                <input type="text" name="model_name" id="model_name" class="form-control"
                                    placeholder="Enter model name..." required disabled>
                            </div>
                        </div>

                        {{-- Truck type and price --}}
                        <div class="mb-3 make-create-card">
                            <label class="form-label">Truck Type</label>
                            <select name="truck_type" id="truck_type" class="form-select" disabled required>
                                <option value="" selected>Select a Truck Type</option>
                                <option value="Mid-Sized">Mid-Sized</option>
                                <option value="Toyota-79">Toyota-79</option>
                                <option value="USA-Truck">USA-Truck</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3 make-create-card">
                            <label class="form-label">Model price</label>
                            <input type="text" name="price" id="price" class="form-control"
                                placeholder="Enter model price..." required>
                        </div>

                        {{-- Tag-based input for series/years --}}
                        <div class="mb-3 mt-3">
                            <label class="form-label">Select Series</label>
                            <div id="seriesTags" class="tag-container" tabindex="0"></div>
                            <input type="hidden" name="years" id="years" >
                            @error('years')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Submit button --}}
                        <div class="d-grid create-form-CTA">
                            <button type="submit" class="" id="submit-btn" disabled>Create Model</button>
                        </div>
                    </div>

                </form>
                </div>
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery for tag input and form logic --}}
    <script>
        $(document).ready(function () {
            // Tag input logic for series/years
            const tagContainer = $('#seriesTags');
            const hiddenInput = $('#years');
            let tags = hiddenInput.val()
                ? hiddenInput.val().split(',').map(s => s.trim()).filter(s => s.length > 0)
                : [];
            function renderTags() {
                tagContainer.empty();
                tags.forEach(tag => {
                const tagEl = $('<span class="tag"></span>').text(tag);
                const removeBtn = $('<span class="remove-tag">&times;</span>');
                removeBtn.on('click', () => {
                    tags = tags.filter(t => t !== tag);
                    updateHiddenInput();
                    renderTags();
                });
                tagEl.append(removeBtn);
                tagContainer.append(tagEl);
                });
                // Input for new tags
                const input = $('<input type="text" class="tag-input" placeholder="Type a series and press Enter" autocomplete="off" />');
                input.on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const val = input.val().trim();
                    if (val.length > 0) {
                    if (!tags.includes(val)) {
                        tags.push(val);
                        updateHiddenInput();
                        renderTags();
                    } else {
                        alert('Series already added');
                    }
                    input.val('');
                    }
                }
                });
                tagContainer.append(input);
                input.focus();
            }
            function updateHiddenInput() {
                hiddenInput.val(tags.join(','));
            }
            tagContainer.on('click', function() {
                $(this).find('input.tag-input').focus();
            });
            renderTags();

            // Enable form fields when Make is selected
            $("#make_id").change(function () {
                $("#model_name, #truck_type, #submit-btn").prop("disabled", false);
                $("#make-message").addClass("d-none");
            });
            // Form validation logic (if needed)
            $("#modelForm").submit(function (e) {
                if (!$("#make_id").val()) {
                    e.preventDefault();
                    $("#make-message").removeClass("d-none");
                    return;
                }
            });
        });
    </script>
@endsection