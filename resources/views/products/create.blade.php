@extends('layouts.app_new')

@section('content')
    <style>
        /* This class will hide the message */
        .remove-image-text {
            display: block !important;
        }

        /* This class will hide the message when not needed */
        .hide-image-text {
            display: none !important;
        }
    </style>
    <div class="craete-form-outer-panel">
        <div class="d-flex justify-content-between align-items-center mb-3 n-main-header create-heading-con addnewproduct-headings">
            <h2 class="fw-bold">Add New Product</h2>
            <div class="create-form-CTA auto-width">
                <a href="{{ route('products.index') }}" class="btn btn-secondary ">
                    <img src="{{ asset('images') }}/back-bttn-icon.svg"> Back to Products
                </a>
            </div>
            
        </div>

        <div class="card shadow p-4 products-card  card-margin-outer">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Name & Price -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Product Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Price</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Product Type -->
                <div class="mb-3">
                    <label class="form-label fw-medium">Product Type</label>
                    <div class="d-flex gap-3">
                        @foreach (['internal', 'external'] as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="internal_external"
                                    value="{{ $option }}"
                                    {{ old('internal_external', 'internal') === $option ? 'checked' : '' }}>
                                <label class="form-check-label">{{ ucfirst($option) }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('internal_external')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Width, Length, Height -->
                <div class="row mb-3">
                    @foreach (['width', 'length', 'height'] as $field)
                        <div class="col-md-4">
                            <label class="form-label fw-medium">{{ ucfirst($field) }}</label>
                            <input type="number" name="{{ $field }}" class="form-control"
                                value="{{ old($field) }}">
                            @error($field)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                    <label class="form-label fw-medium">Product Image</label>
                    <div class="position-relative">
                        <input type="file" name="image" class="form-control" id="image">
                        <div id="imageMessage" class="mt-2 d-flex align-items-center justify-content-center"
                            style="width: 300px; height: 300px; border: 1px solid #ccc; background-color: #f7f7f7;">
                            <small class="text-muted">Select an image</small>
                        </div>
                        <div id="imagePreview" style="display: none;">
                            <img id="preview" src="" alt="Image Preview" class="img-fluid"
                                style="width: 300px; height: 300px; object-fit: cover;">
                        </div>
                    </div>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label class="form-label fw-medium">Quantity</label>
                    <input type="text" name="length_units" class="form-control" value="{{ old('quantity') }}"
                        min="0">
                    @error('length_units')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <!-- Length Units -->
                <div class="mb-3">
                    <label class="form-label fw-medium">Length Units</label>
                    <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}"
                        min="0">
                    @error('quantity')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Fitment Time</label>
                    <input type="text" name="fitment_time" class="form-control" value="{{ old('fitment_time') }}"
                        min="0">
                    @error('fitment_time')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="d-grid create-form-CTA" style="width: auto;">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $('#image').on('change', function(event) {
            var reader = new FileReader();

            reader.onload = function() {
                // Update the preview image with the selected file
                $('#preview').attr('src', reader.result);
                $('#imagePreview').show(); // Show the image preview
                $('#imageMessage').addClass('hide-image-text'); // Hide the "Select an image" message
            };

            if (event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                $('#imagePreview').hide(); // Hide the image preview if no file is selected
                $('#imageMessage').removeClass('hide-image-text'); // Show the "Select an image" message again
            }
        });
    </script>
@endsection
