@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Page Title & Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-4 n-main-header">
            <h2 class="fw-bold">Create New Form</h2>
            <a href="{{ route('forms.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Forms
            </a>
        </div>

        <!-- Form Name Input -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form id="createFormForm" method="POST" action="{{ route('forms.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Form Name:</label>
                        <input type="text" id="formName" name="name" class="form-control" placeholder="Enter form name" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-arrow-right"></i> Continue to Form Builder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customScript')
    <script>
        $(document).ready(function() {
            $("#createFormForm").on('submit', function(e) {
                let formName = $("#formName").val();
                if (!formName) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please enter a form name!',
                    });
                }
            });
        });
    </script>
@endsection
