{{-- 
    Products Index Page (products/index.blade.php)
    
    This Blade template displays the main products management interface where administrators
    can view all products in a paginated table format with options to add, edit, and delete products.
    
    Features:
    - Product listing with pagination
    - Product image display with fallback for missing images
    - Product details including name, price, type, quantity, dimensions, and fitment time
    - Add new product button
    - Edit and delete actions for each product
    - Responsive table design
    - Bootstrap styling and icons
    
    Product Information Displayed:
    - Product image (thumbnail with fallback)
    - Product name
    - Price (formatted with dollar sign)
    - Type (Internal/External)
    - Quantity
    - Length units
    - Fitment time (in hours)
    - Action buttons (edit/delete)
--}}

@extends('layouts.app_new')

@section('content')
    {{-- Main container for products management interface --}}
    <div class="product-model-outer-right product-space-right">
        {{-- Header section with page title and action buttons --}}
        <div class="col-12 pade-none n-main-header create-heading-con makemodelproduct-headings"> 
            {{-- Page title --}}
            <h2>Products</h2>
            {{-- Add new product button --}}
            <div class="n-header-buttons create-form-CTA">
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <img src="{{ asset('images') }}/plus-icon.png"> Add New Product
                </a>
            </div>
        </div>

        {{-- Main content card containing the products table --}}
        <div class="card shadow-sm n-card product-space-inner-right">
            <div class="card-body">

                {{-- Responsive table container for displaying products data --}}
                <div class="table-responsive">
                    <table class="table table-bordered">
                        {{-- Table header with column titles --}}
                        <thead class="table-light">
                            <tr class="text-left">
                                {{-- <th>#</th> --}} {{-- Commented out row number column --}}
                                <th>Image</th> {{-- Column for product image --}}
                                <th>Name</th> {{-- Column for product name --}}
                                <th>Price</th> {{-- Column for product price --}}
                                <th>Type</th> {{-- Column for product type (Internal/External) --}}
                                <th>Quantity</th> {{-- Column for available quantity --}}
                                <th>Length Unites</th> {{-- Column for length units --}}
                                <th>Fitment Time</th> {{-- Column for fitment time --}}
                                <th>Actions</th> {{-- Column for edit/delete actions --}}
                            </tr>
                        </thead>
                        
                        {{-- Table body with products data --}}
                        <tbody>
                            {{-- Loop through all products with pagination support --}}
                            @forelse($products as $index => $product)
                                <tr class="text-left">
                                    {{-- <td>{{ $index + 1 }}</td> --}} {{-- Commented out row number --}}

                                    {{-- Product image display with fallback for missing images --}}
                                    <td>
                                        @if ($product->image)
                                            {{-- Display product image as thumbnail with consistent sizing --}}
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail"
                                                style="width: 120px; height: 120px; object-fit: cover;">
                                        @else
                                            {{-- Fallback text when no image is available --}}
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    {{-- Product details columns --}}
                                    <td>{{ $product->name }}</td> {{-- Product name --}}
                                    <td>${{ $product->price }}</td> {{-- Product price with dollar sign --}}
                                    <td>{{ ucfirst($product->internal_external) }}</td> {{-- Product type (capitalized) --}}
                                    <td>{{ $product->quantity }}</td> {{-- Available quantity --}}
                                    <td>{{ $product->length_units }}</td> {{-- Length units --}}
                                    <td>{{ $product->fitment_time }} Hours</td> {{-- Fitment time with "Hours" suffix --}}
                                    
                                    {{-- Action buttons container --}}
                                    <td class="product-icons-inner">
                                        {{-- Edit product button - Links to edit form --}}
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info product-action-icons">
                                            <img src="{{ asset('images') }}/edit-icon.svg">
                                        </a>
                                        
                                        {{-- Delete product form - POST form with DELETE method for secure deletion --}}
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf {{-- CSRF protection token --}}
                                            @method('DELETE') {{-- Method spoofing for DELETE request --}}
                                            <button type="submit" class="btn btn-sm btn-danger deleteButton product-action-icons">
                                                <img src="{{ asset('images') }}/trash-icon.svg">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                {{-- Display message when no products are found --}}
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination links - Bootstrap 4 pagination component --}}
                <div class="d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div>
@endsection
