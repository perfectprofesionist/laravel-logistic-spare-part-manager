@extends('layouts.app_new')

@section('content')


@if($forms->isEmpty())
<!--Create Form Screen -->
<a href="{{ route('forms-new.create') }}"><img src="{{ asset('images') }}/plus-icon.png" alt="Plus"><div class="create-form-outer">
    <div class="create-form-left"><img src="{{ asset('images') }}/form-pic.png" alt="Form Icon"></div>
    <div class="create-form-right">
      <h2>Create Form <span><img src="{{ asset('images') }}/create-form-icon.png" alt="arrow"></span></h2>
    </div>
</div></a>

@else 
       

        <!--Create Form Screen 02 -->
        <div class="craete-form-outer-panel">
        <div class="col-12 pade-none create-heading-con">
            <h2>Forms</h2>
            <div class="create-form-CTA"><a href="{{ route('forms-new.create') }}"><img src="{{ asset('images') }}/plus-icon.png" alt="Plus"> Create Form</a></div>
        </div>
        <div class="col-12 pade-none create-form-table-con">

            <div class="form-table-outer">
            <div class="form-table-inner-con">


            <div class="form-heading-con form-haeding-inner">
                    <div class="form-left-con">
                    <div class="form-heading">Form Name</div>
                    <div class="form-heading">Status</div>
                    <div class="form-heading">Date of Creation</div>
                    <div class="form-heading">Publish</div>
                    <div class="form-heading">Actions</div>
                    <div class="form-heading">&nbsp;</div>
                    </div>
                    <div class="form-right-con">&nbsp;</div>
            </div>



              @foreach($home_form as $form)

                <div class="form-heading-con">
                    @if($form->set_as_home)
                        <div class="home-icon"><img src="{{ asset('images') }}/home-icon.png" alt="Home icon"></div>
                        
                    @endif
                    <div class="form-left-con form-content-con">
                        <div class="form-content">{{ $form->name }}</div>
                        <div class="form-content"> 
                                @if($form->status === 'published')
                                    Published
                                @else
                                    Draft
                                @endif
                            </div>
                        <div class="form-content">{{ $form->created_at->format('jS M Y') }}</div>
                        <div class="form-content">
                            <label class="switch">
                                <input type="checkbox"
                                    @if($form->status === 'published')
                                        checked
                                    @endif
                                    onclick="triggerStatusBtn(event, '{{ $form->id }}')"
                                >
                                <span class="slider"></span>
                            </label>

                            <button type="button"
                                class="btn btn-sm btn-secondary toggle-status-btn d-none"
                                data-id="{{ $form->id }}"
                                data-status="{{ $form->status }}">
                                <i class="fa fa-toggle-on"></i>
                                {{ $form->status === 'published' ? 'Unpublish' : 'Publish' }}
                            </button>


                        </div>
                        <div class="form-content">
                            <a href="{{ route('forms.showForm', $form->slug) }}" target="_blank" class="action-icons"><img src="{{ asset('images') }}/view-icon.svg" alt="View"></a>
                            <a href="{{ route('forms-new.edit', $form->id) }}" class="action-icons"><img src="{{ asset('images') }}/edit-icon.svg" alt="Edit"></a>
                            <a href="javascript:void(0);" class="action-icons" onclick="triggerDelete(event, '{{ $form->id }}')"><img src="{{ asset('images') }}/trash-icon.svg" alt="Trash"></a>
                            <button type="button" class="btn btn-sm btn-danger delete-form d-none" data-id="{{ $form->id }}">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                            <a href="javascript:void(0);" data-id="{{ $form->id }}" class="action-icons duplicate-form"><img src="{{ asset('images') }}/copy.svg" alt="Copy"></a>
                        </div>
                        
                            <div class="form-content form-condition-con"><a href="{{ route('form.conditions', $form->id) }}"  class="form-condition-link">Form Conditions</a> 
                                @if(!$form->set_as_home)
                                    <span class="set-home-con"  onclick="triggerSetHome(event, '{{ $form->id }}')">Set as Home</span>
                                    <input type="checkbox" class="set-home-checkbox d-none" data-id="{{ $form->id }}" {{ $form->set_as_home ? 'checked' : '' }}>
                                @endif
                            </div>
                        
                    </div>
                    <div class="form-right-con"><a href="{{ route('forms.submissions', $form->id) }}" class="check-entries-cta">{{-- <span>03</span>--}} Check Entries</a></div>
                </div>

            @endforeach

            @foreach($forms as $form)
                @if($form->set_as_home)
                 @continue
                @endif
                <div class="form-heading-con">
                    @if($form->set_as_home)
                        <div class="home-icon"><img src="{{ asset('images') }}/home-icon.png" alt="Home icon"></div>
                        
                    @endif
                    <div class="form-left-con form-content-con">
                        <div class="form-content">{{ $form->name }}</div>
                        <div class="form-content"> 
                                @if($form->status === 'published')
                                    Published
                                @else
                                    Draft
                                @endif
                            </div>
                        <div class="form-content">{{ $form->created_at->format('jS M Y') }}</div>
                        <div class="form-content">
                            <form autocomplete="off">
                                <label class="switch">
                                    <input type="checkbox"
                                        @if($form->status === 'published')
                                            checked
                                        @endif
                                        onclick="triggerStatusBtn(event, '{{ $form->id }}')"
                                    >
                                    <span class="slider"></span>
                                </label>
                            </form>
                            

                            <button type="button"
                                class="btn btn-sm btn-secondary toggle-status-btn d-none"
                                data-id="{{ $form->id }}"
                                data-status="{{ $form->status }}">
                                <i class="fa fa-toggle-on"></i>
                                {{ $form->status === 'published' ? 'Unpublish' : 'Publish' }}
                            </button>


                        </div>
                        <div class="form-content">
                            <a href="{{ route('forms.showForm', $form->slug) }}" target="_blank" class="action-icons"><img src="{{ asset('images') }}/view-icon.svg" alt="View"></a>
                            <a href="{{ route('forms-new.edit', $form->id) }}" class="action-icons"><img src="{{ asset('images') }}/edit-icon.svg" alt="Edit"></a>
                            <a href="javascript:void(0);" class="action-icons" onclick="triggerDelete(event, '{{ $form->id }}')"><img src="{{ asset('images') }}/trash-icon.svg" alt="Trash"></a>
                            <button type="button" class="btn btn-sm btn-danger delete-form d-none" data-id="{{ $form->id }}">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                            <a href="javascript:void(0);" data-id="{{ $form->id }}" class="action-icons duplicate-form"><img src="{{ asset('images') }}/copy.svg" alt="Copy"></a>
                        </div>
                        
                            <div class="form-content form-condition-con"><a href="{{ route('form.conditions', $form->id) }}"  class="form-condition-link">Form Conditions</a> 
                                @if(!$form->set_as_home)
                                    <span class="set-home-con"  onclick="triggerSetHome(event, '{{ $form->id }}')">Set as Home</span>
                                    <input type="checkbox" class="set-home-checkbox d-none" data-id="{{ $form->id }}" {{ $form->set_as_home ? 'checked' : '' }}>
                                @endif
                            </div>
                        
                    </div>
                    <div class="form-right-con"><a href="{{ route('forms.submissions', $form->id) }}" class="check-entries-cta">{{-- <span>03</span>--}} Check Entries</a></div>
                </div>

            @endforeach

            </div>

            </div>
        
        </div>
        </div>
@endif






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
                        url: `/back/forms-new/${formId}/duplicate`,
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


    function triggerDelete(event, id) {
        event.preventDefault();

        // Find the delete button with matching data-id
        const button = document.querySelector('.delete-form[data-id="' + id + '"]');
        if (button) {
            button.click();
        }
    }


    function triggerStatusBtn(event, id) {
        
        event.preventDefault();
        // Find the delete button with matching data-id
        const button = document.querySelector('.toggle-status-btn[data-id="' + id + '"]');
        if (button) {
            button.click();
        }

       
    }

    function triggerSetHome(event, id) {
        event.preventDefault();

        // Find the delete button with matching data-id
        const button = document.querySelector('.set-home-checkbox[data-id="' + id + '"]');
        if (button) {
            button.click();
        }
    }
    
    
</script>
@endsection
