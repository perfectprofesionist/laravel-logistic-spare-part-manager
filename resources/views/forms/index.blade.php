@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 n-main-header">
        <h2 class="fw-bold">Forms</h2>
        <div class="n-header-buttons">

            <a href="{{ route('forms.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Create New Form
            </a>
        </div>
    </div>

    <div class="card shadow-sm n-card">
        <div class="card-body">
            @if($forms->isEmpty())
                <div class="text-center py-4">
                    <h4>No forms created yet</h4>
                    <p>Click the "Create New Form" button to get started</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Home</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $form)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="set-home-checkbox" data-id="{{ $form->id }}" {{ $form->set_as_home ? 'checked' : '' }}>
                                </td>
                                <td>{{ $form->name }}</td>
                                <td>
                                    @if($form->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $form->created_at->format('d-M-Y h:i A') }}</td>
                                <td>{{ $form->updated_at->format('d-M-Y h:i A') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('forms.edit', $form->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-info duplicate-form" data-id="{{ $form->id }}">
                                            <i class="fa fa-copy"></i> Duplicate
                                        </button> 
                                        <button type="button"
                                            class="btn btn-sm btn-secondary toggle-status-btn"
                                            data-id="{{ $form->id }}"
                                            data-status="{{ $form->status }}">
                                            <i class="fa fa-toggle-on"></i>
                                            {{ $form->status === 'published' ? 'Unpublish' : 'Publish' }}
                                        </button>
                                            {{-- <button type="button" class="btn btn-sm btn-success publish-form" data-id="{{ $form->id }}">
                                                <i class="fa fa-check"></i> Publish
                                            </button> --}}
                                            {{-- <a target="_blank" href="{{ route('forms.show', $form->slug) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i> View
                                            </a> --}}
                                            <a target="_blank" href="{{ route('forms.showForm', $form->slug) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i> Form View
                                            </a>
                                            <a href="{{ route('forms.submissions', $form->id) }}" class="btn btn-sm btn-dark">
                                                <i class="fa fa-list"></i> Entries
                                            </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-form" data-id="{{ $form->id }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script>
    $(document).ready(function() {
        // Handle publish form
        // $('.publish-form').click(function() {
        //     const formId = $(this).data('id');

        //     Swal.fire({
        //         title: 'Publish Form',
        //         text: 'Are you sure you want to publish this form?',
        //         icon: 'question',
        //         showCancelButton: true,
        //         confirmButtonText: 'Yes, publish it',
        //         cancelButtonText: 'No, cancel'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: `/back/forms/${formId}/publish`,
        //                 type: 'POST',
        //                 headers: {
        //                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //                 },
        //                 success: function(response) {
        //                     Swal.fire({
        //                         icon: 'success',
        //                         title: 'Success!',
        //                         text: response.message,
        //                         showConfirmButton: false,
        //                         timer: 2000
        //                     }).then(() => {
        //                         window.location.reload();
        //                     });
        //                 },
        //                 error: function(xhr) {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Error!',
        //                         text: 'Failed to publish form'
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // });

        // Handle duplicate form
        $('.duplicate-form').click(function() {
            const formId = $(this).data('id');

            Swal.fire({
                title: 'Duplicate Form',
                text: 'Are you sure you want to create a copy of this form?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, duplicate it',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/back/forms/${formId}/duplicate`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to duplicate form'
                            });
                        }
                    });
                }
            });
        });

        // Handle delete form
        $('.delete-form').click(function() {
            const formId = $(this).data('id');

            Swal.fire({
                title: 'Delete Form',
                text: 'Are you sure you want to delete this form?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'No, cancel',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/back/forms/${formId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete form'
                            });
                        }
                    });
                }
            });
        });


        // Toggle form publish/draft status
        $('.toggle-status-btn').click(function () {
            const formId = $(this).data('id');
            const currentStatus = $(this).data('status');
            const isPublished = currentStatus === 'published';

            const title = isPublished ? 'Unpublish Form' : 'Publish Form';
            const text = isPublished
                ? 'Are you sure you want to unpublish this form?'
                : 'Are you sure you want to publish this form?';

            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: isPublished ? 'Yes, unpublish' : 'Yes, publish',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/back/forms/${formId}/toggle-status`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire('Error', 'Unable to update form status.', 'error');
                        }
                    });
                }
            });
        });

        
        $('.set-home-checkbox').on('change', function () {
            var checkbox = $(this);
            var formId = checkbox.data('id');
            var token = '{{ csrf_token() }}';

            // Always show confirmation popup
            Swal.fire({
                title: 'Set as Home',
                text: 'Are you sure you want to set this form as the homepage?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, set as home',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("forms.setAsHome") }}',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ id: formId }),
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function (response) {
                            if (response.message) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', 'Something went wrong.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Server error occurred.', 'error');
                        }
                    });
                } else {
                    // Cancelled, revert checkbox state
                    checkbox.prop('checked', false);
                }
            });
        });




    });
</script>
@endsection
