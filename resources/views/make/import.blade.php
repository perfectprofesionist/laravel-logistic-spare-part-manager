{{--
    Import Make Page (make/import.blade.php)
    
    This template provides a form for importing car makes from an Excel or CSV file.
    Includes file upload, success/error message display, and a submit button.
--}}

@extends('layouts.app_new')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
    <h2 class="fw-bold mb-3">Import Make</h2>

    

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted">Upload an Excel or CSV file to import Make.</p>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Error message --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>

            
            
            <form action="{{ route('make.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label fw-bold">Choose File</label>
                    <input type="file" name="file" class="form-control" accept=".xls, .xlsx, .csv" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-import me-2"></i> Import File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
@endsection
