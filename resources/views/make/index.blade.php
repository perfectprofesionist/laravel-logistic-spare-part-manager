{{-- 
    Make Index Page
    
    This Blade template displays the main interface for managing car makes.
    It includes a header with action buttons for downloading templates, importing data,
    and creating new makes, followed by a table displaying all existing makes
    with edit and delete actions.
    
    Features:
    - Template download functionality
    - Data import interface
    - Add new make button
    - Paginated table of existing makes
    - Edit and delete actions for each make
    - Responsive design with Bootstrap styling
--}}

@extends('layouts.app_new')

@section('content')
{{-- Main container for the make management interface --}}
<div class="product-model-outer-right product-space-right">
    {{-- Header section with title and action buttons --}}
    <div class="d-flex justify-content-between align-items-center mb-3 n-main-header create-form-heading-main">
        
        {{-- Left side: Page title and action buttons --}}
        <div class="col-12 pade-none create-heading-con makemodelproduct-headings"> 
            {{-- Page title --}}
            <h2>Make</h2>
            
            {{-- Action buttons container --}}
            <div class="create-form-CTA-outer">
                {{-- Download template button - Allows users to download Excel template for data import --}}
                <div class="n-header-buttons create-form-CTA download-temp-btn">
                    <a href="{{ asset('templates/template_make.xlsx') }}" download class="btn btn-primary">Download Template Make</a>
                </div>
                
                {{-- Import data button - Links to the import interface for bulk data upload --}}
                <div class="n-header-buttons create-form-CTA">
                    <a href="{{ route('make.import') }}" class="btn btn-success fw-bold rounded shadow">
                        <i class="fas fa-file-import me-2"></i> Import Data
                    </a>
                </div>
                
                {{-- Add new make button - Links to the create form for adding individual makes --}}
                <div class="n-header-buttons create-form-CTA">
                    <a href="{{ route('make.create') }}" class="btn btn-primary create-form-CTA">
                        <img src="{{ asset('images') }}/plus-icon.png"> Add New Make
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main content card containing the makes table --}}
    <div class="card shadow-sm n-card product-space-right">
        <div class="card-body">
            {{-- Responsive table container for displaying makes data --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    {{-- Table header with column titles --}}
                    <thead class="table-light">
                        <tr class="text-left">
                            {{-- <th>#</th> --}} {{-- Commented out row number column --}}
                            <th>Name</th> {{-- Column for make name --}}
                            <th>Actions</th> {{-- Column for edit/delete actions --}}
                        </tr>
                    </thead>
                    
                    {{-- Table body with makes data --}}
                    <tbody>
                        {{-- Loop through all makes with pagination support --}}
                        @forelse($make as $index => $item)
                            <tr class="text-left">
                                {{-- <td>{{ $index + 1 }}</td> --}} {{-- Commented out row number --}}
                                <td>{{ $item->name }}</td> {{-- Display make name --}}
                                <td>
                                    {{-- Edit button - Links to edit form for this make --}}
                                    <a href="{{ route('make.edit', $item->id) }}" class="btn btn-sm btn-info product-action-icons">
                                        <img src="{{ asset('images') }}/edit-icon.svg">
                                    </a>
                                    
                                    {{-- Delete form - POST form with DELETE method for secure deletion --}}
                                    <form action="{{ route('make.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf {{-- CSRF protection token --}}
                                        @method('DELETE') {{-- Method spoofing for DELETE request --}}
                                        <button type="submit" class="btn btn-sm btn-danger deleteButton product-action-icons">
                                            <img src="{{ asset('images') }}/trash-icon.svg">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Display message when no makes are found --}}
                            <tr>
                                <td colspan="3" class="text-center text-muted">No makes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination links - Bootstrap 4 pagination component --}}
            <div class="d-flex justify-content-center">
                {{ $make->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

</div>
@endsection
