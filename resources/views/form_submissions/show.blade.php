{{-- 
    Form Submission Details Page (form_submissions/show.blade.php)
    
    This Blade template displays the details of a single form submission.
    It shows all submitted fields, their values, and the submission status in a grouped table format.
    
    Features:
    - Grouped display of form fields and their values
    - Rowspan for field labels with multiple values
    - Formatted value display (including quantity extraction)
    - Submission status badge (Submitted/Not Submitted)
    - Entry date and time display
    - Responsive table design
    - Bootstrap styling
    - Back button for navigation
    
    Table Columns:
    - Field: The label of the form field (grouped by field_id)
    - Value: The value(s) entered for the field
    
    Usage:
    - Used by administrators to review the details of a specific form submission
    - Provides a clear, grouped view of all submitted data
    - Indicates whether the submission was finalized or not
--}}

@extends('layouts.app_new')

@section('content')
 {{-- Main container for submission details --}}
 <div class="craete-form-outer-panel">

    {{-- Header with page title and back button --}}
    <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
        <h2 >Entry Details</h2>
    
        <div class="create-form-CTA auto-width">
            <a href="{{ url()->previous() }}">
                <img src="{{ asset('images') }}/back-bttn-icon.svg"> Back
            </a>
        </div>
    </div>
    
    {{-- Card containing the submission details table --}}
    <div class="card n-card">
        <div class="card-body">
            @php
                $data = json_decode($submission->options, true);
                // Group the fields by their field_id
                $groupedData = [];
                foreach ($data as $field) {
                    $groupedData[$field['feild_id']][] = $field;
                }
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            {{-- <th>Field-id</th> --}} {{-- Field ID column (commented out) --}}
                            <th>Field</th> {{-- Field label column --}}
                            <th>Value</th> {{-- Field value column --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through grouped fields by field_id --}}
                        @foreach($groupedData as $fieldId => $fields)
                            @foreach($fields as $index => $field)
                                <tr>
                                    @if($index == 0)
                                        {{-- Rowspan for field label if multiple values --}}
                                        {{-- <td rowspan="{{ count($fields) }}"><p class="text-white">{{ $fieldId }}</p></td> --}}
                                        <td rowspan="{{ count($fields) }}" ><p class="text-white">{!! html_entity_decode(ucfirst($field['label'])) !!}</p></td>
                                    @endif

                                    @php
                                        // Format value and extract quantity if present
                                        $value = $field['value'];
                                        $value = preg_replace('/\((\d+)\)$/', '<br>quantity: $1', $value);
                                    @endphp
                                    
                                    <td style="word-spacing: 4px;">{!! $value !!}</td>
                                </tr>
                            @endforeach
                        @endforeach

                        {{-- Submission status and entry date row --}}
                        <tr>
                            <td colspan="3" class="text-center fw-bold">
                                Filled On: {{ $submission->created_at->format('d M Y, h:i A') }}
                                @if($submission->is_submitted)
                                    <p class="badge bg-success">Submitted</p>
                                @else
                                    <p class="badge bg-warning">Not Submitted</p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
