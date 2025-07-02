@extends('layouts.app_new')

@section('content')


 <!--Create Form Screen 02 -->
 <div class="craete-form-outer-panel">
    <div class="col-12 pade-none create-heading-con">
      <h2>Create New Form</h2>
      <div class="create-form-CTA auto-width"><a href="{{ route('forms-new.index') }}"><img src="{{ asset('images') }}/back-bttn-icon.svg" alt="back"> Back</a></div>
    </div>


    <div class="col-12 pade-none cont-conditions-added">
      <div class="navigation-steps pd-remove">
        <div class="nav-form-grid">
            <form id="createFormForm" method="POST" action="{{ route('forms-new.store') }}">
                @csrf
                <label for="form">Form Name</label><br>
                <input type="text" id="formName" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter form name">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <br>
                <label for="email">Admin Emails <span>(Separate emails by adding commas)</span></label><br>
               

                <textarea id="admin_emails" class="form-control  @error('admin_emails') is-invalid @enderror"  name="admin_emails" rows="5"
                placeholder="Enter emails">{{ old('admin_emails', $form->admin_emails ?? '') }}</textarea>

                @error('admin_emails')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror



                <button type="submit" class="btn btn-primary d-none" id="submit-btn-add-form">
                    <i class="fa fa-arrow-right"></i> Continue to Form Builder
                </button>

            </form>
        </div>
    </div>
      
    </div>

    <div class="create-form-CTA save-continue-outer"><a href="#">Save &amp; Continue <img src="{{ asset('images') }}/save-btn.svg" alt="icon"></a></div>
    
</div>











@endsection

@section('customScript')
<script>
    $(document).ready(function () {
        $('#formName').focus();
        function isValidEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email.trim());
        }

        function isValidFormName(formName) {
            const regex = /^[A-Za-z0-9\- ]+$/;
            return regex.test(formName);
        }

        $('.save-continue-outer a').click(function (e) {
            let hasError = false;
            $('.invalid-feedback-email').remove(); // Clear previous messages

            let formName = $('#formName').val().trim();
            let adminEmails = $('#admin_emails').val().trim();

            // Validate form name
            if (!formName) {
                e.preventDefault();
                $('#formName').after('<div class="invalid-feedback-email text-danger">Form name is required.</div>');
                hasError = true;
            } else if (!isValidFormName(formName)) {
                e.preventDefault();
                $('#formName').after('<div class="invalid-feedback-email text-danger">Form name must be alphanumeric (A–Z, a–z, 0–9) with spaces and dashes only.</div>');
                hasError = true;
            } else if (formName.length > 30) {
                e.preventDefault();
                $('#formName').after('<div class="invalid-feedback-email text-danger">Form name must be 30 characters or less.</div>');
                hasError = true;
            }

            if (adminEmails !== '') {
                let emails = adminEmails.split(',').map(e => e.trim()).filter(e => e !== '');
                let invalidEmails = [];
                let emailSet = new Set();
                let duplicateEmails = [];

                emails.forEach(function (email) {
                    if (!isValidEmail(email)) {
                        invalidEmails.push(email);
                    } else if (emailSet.has(email.toLowerCase())) {
                        duplicateEmails.push(email);
                    } else {
                        emailSet.add(email.toLowerCase());
                    }
                });

                // Check for accidental spaces without commas
                if (adminEmails.includes(' ') && !adminEmails.includes(',')) {
                    invalidEmails.push('Emails must be separated by commas');
                }

                if (invalidEmails.length > 0 || duplicateEmails.length > 0) {
                    e.preventDefault();

                    let errorMessage = '';
                    if (invalidEmails.length > 0) {
                        errorMessage += `Invalid email(s): ${invalidEmails.join(', ')}<br>`;
                    }
                    if (duplicateEmails.length > 0) {
                        errorMessage += `Duplicate email(s): ${duplicateEmails.join(', ')}`;
                    }

                    $('#admin_emails').after(
                        `<div class="invalid-feedback-email text-danger">${errorMessage}</div>`
                    );
                    hasError = true;
                }
            }

            if (!hasError) {
                $('#submit-btn-add-form').trigger('click');
            }
        });
    });
</script>
@endsection



