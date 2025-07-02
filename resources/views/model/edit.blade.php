{{--
    File: resources/views/model/edit.blade.php
    Purpose: Edit Model form view. Allows admin/user to update a car model's details (make, name, truck type, price, and series/years) with a user-friendly UI and tag-based input for series. Includes validation and dynamic tag management using jQuery.
    Features:
    - Form for editing model details (make, name, truck type, price, years/series)
    - Tag input for years/series
    - Validation and error display
    - Responsive, accessible design
    - Uses CSRF and method spoofing for security
--}}

@extends('layouts.app_new')

@section('content')
<div class="craete-form-outer-panel">
    <div class="row">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
            <h2 class="">Edit Model</h2>
        </div>

        <div class="d-flex">
            <!-- Form Card: Main container for the edit form -->
            <div class="card shadow-lg w-100 makes1-card card-margin-outer create-make-name-con">
                <!-- Edit Model Form -->
                <form action="{{ route('model.update', $model->id) }}" method="POST" id="modelForm">
                    @csrf
                    @method('PUT')

                    <!-- Make & Model Row: Select Make and enter Model Name -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <!-- Dropdown to select the car make -->
                            <label class="form-label">Select Make</label>
                            <select name="make_id" id="make_id" class="form-select" required>
                                <option value="" disabled>Select a Make</option>
                                @foreach ($makes as $make)
                                    <option value="{{ $make->id }}" {{ $make->id == $model->make_id ? 'selected' : '' }}>
                                        {{ $make->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <!-- Input for model name -->
                            <label class="form-label">Model Name</label>
                            <input type="text" name="model_name" id="model_name" class="form-control"
                                   value="{{ $model->model_name }}" required>
                        </div>
                    </div>

                    <!-- Truck Type Dropdown -->
                    <div class="mb-3">
                        <label class="form-label">Truck Type</label>
                        <select name="truck_type" id="truck_type" class="form-select" required>
                            <option value="">Select Truck Type</option>
                            <option value="Mid-Sized" {{ $model->truck_type == 'Mid-Sized' ? 'selected' : '' }}>Mid-Sized</option>
                            <option value="Toyota-79" {{ $model->truck_type == 'Toyota-79' ? 'selected' : '' }}>Toyota-79</option>
                            <option value="USA-Truck" {{ $model->truck_type == 'USA-Truck' ? 'selected' : '' }}>USA-Truck</option>
                        </select>
                    </div>

                    <!-- Model Price Input -->
                    <div class="col-md-6">
                        <label class="form-label">Model price</label>
                        <input type="text" name="price" id="price" class="form-control"
                               value="{{ $model->price }}" required>
                    </div>

                    <!-- Series/Years Tag Input Section -->
                    <div class="mb-3 mt-3">
                        <label class="form-label">Select Series</label>
                        <!-- Tag input UI for entering multiple years/series -->
                        <div id="seriesTags" class="tag-container" tabindex="0"></div>
                        <!-- Hidden input to store comma-separated years for form submission -->
                        <input type="hidden" name="years" id="years" value="{{ $model->years }}">
                        @error('years')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid create-form-CTA">
                        <button type="submit" class="btn btn-success" id="submit-btn">Update Model</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Script for Tag Input and Dynamic UI -->
<script>
  $(document).ready(function(){
    // Tag input logic for managing series/years as tags
    const tagContainer = $('#seriesTags');
    const hiddenInput = $('#years');

    // Initialize tags from hidden input value (comma separated)
    let tags = hiddenInput.val()
      ? hiddenInput.val().split(',').map(s => s.trim()).filter(s => s.length > 0)
      : [];

    // Render tags and input field
    function renderTags() {
      tagContainer.empty();

      tags.forEach(tag => {
        // Create tag element with remove button
        const tagEl = $('<span class="tag"></span>').text(tag);
        const removeBtn = $('<span class="remove-tag"><i class="fa fa-times" aria-hidden="true"></i></span>');
        removeBtn.on('click', () => {
          tags = tags.filter(t => t !== tag); // Remove tag from list
          updateHiddenInput();
          renderTags();
        });
        tagEl.append(removeBtn);
        tagContainer.append(tagEl);
      });

      // Input for adding new tags
      const input = $('<input type="text" class="tag-input" placeholder="Type a series and press Enter" autocomplete="off" />');
      input.on('keydown', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          const val = input.val().trim();
          if (val.length > 0) {
            if (!tags.includes(val)) {
              tags.push(val); // Add new tag
              updateHiddenInput();
              renderTags();
            } else {
              alert('Series already added'); // Prevent duplicate tags
            }
            input.val('');
          }
        }
      });

      tagContainer.append(input);
      input.focus();
    }

    // Update hidden input with comma-separated tags for form submission
    function updateHiddenInput() {
      hiddenInput.val(tags.join(','));
    }

    // Focus input when container is clicked
    tagContainer.on('click', function() {
      $(this).find('input.tag-input').focus();
    });

    // Initial render of tags
    renderTags();

    // --- Legacy code for dual-list year selection is commented out below for reference ---
    // This code was replaced by the tag input UI for better UX.
    // ...
  });
</script>
@endsection
