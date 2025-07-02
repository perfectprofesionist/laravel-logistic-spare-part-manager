{{-- 
    Form Submissions Index Page (form_submissions/index.blade.php)
    
    This Blade template displays a paginated list of all form submissions.
    It provides a table with each submission's ID, entry date, and a link to view details.
    
    Features:
    - Paginated table of form submissions
    - Entry date formatted for readability
    - View button for each submission
    - Responsive table design
    - Bootstrap styling
    
    Table Columns:
    - ID: Unique identifier for the submission
    - Entry Date: Date and time the submission was created
    - Action: Button to view submission details
    
    Usage:
    - Used by administrators to review and manage form submissions
    - Provides quick access to submission details
    - Supports pagination for large datasets
--}}

@extends('layouts.app_new')

@section('content')
 {{-- Main container for form submissions listing --}}
 <div class="craete-form-outer-panel">
    <div class="d-flex flex-column">
        {{-- Table card for submissions --}}
        <div class="card shadow-sm n-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th> {{-- Submission ID column --}}
                                <th>Entry Date</th> {{-- Submission creation date column --}}
                                <th>Action</th> {{-- View action column --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop through all submissions --}}
                            @foreach ($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->id }}</td> {{-- Submission ID --}}
                                    <td>{{ $submission->created_at->format('d M Y, h:i A') }}</td> {{-- Formatted entry date --}}
                                    <td>
                                        {{-- View button linking to submission details --}}
                                        <a href="{{ route('form-submissions.show', $submission->id) }}" class="btn btn-primary btn-sm formsubmission-view-btn" role="button">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination links with margin-top for space --}}
        <div class="d-flex justify-content-between mt-3 pagination-outer-container">
            {{ $submissions->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
