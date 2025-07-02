{{--
    File: resources/views/model/import.blade.php
    Purpose: Import Make, Model, and Years via Excel/CSV upload. Provides a UI for uploading files, displays success/error messages, and ensures secure, user-friendly import workflow.
    Features:
    - File upload form for Excel/CSV
    - Success and error alert display
    - CSRF protection
    - User guidance and validation
--}}

@extends('layouts.app_new')

@section('content')
 <div class="craete-form-outer-panel">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
    <h2 class="">Import Make, Model & Years</h2>
   </div>
    
    <!-- Import Card -->
    <div class="card shadow-sm create-make-name-con">
        <div class="card-body">
            <!-- User instructions -->
            <p class="text-muted">Upload an Excel or CSV file to import Make, Model, and Years.</p>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Error Alert -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- File Upload Form -->
            <form action="{{ route('model.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- CSRF protection for security -->
                <div class="mb-3">
                    <label for="file" class="form-label fw-bold">Choose File</label>
                    <!-- File input: accepts Excel or CSV files only -->
                    <input type="file" name="file" class="form-control" accept=".xls, .xlsx, .csv" required>
                </div>

                <!-- Submit Button -->
                <div class="d-grid create-form-CTA">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-import me-2"></i> Import File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
