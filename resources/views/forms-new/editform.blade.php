@extends('layouts.app_new')

@section('content')
<div class="craete-form-outer-panel">
    <div class="col-12 pade-none create-heading-con">
        <h2>Edit Form</h2>
        <div class="create-form-CTA auto-width">
            <a href="{{ route('forms-new.index') }}">
                <img src="{{ asset('images/back-bttn-icon.svg') }}" alt="back"> Back
            </a>
        </div>
    </div>

    <div class="col-12 pade-none cont-conditions-added">
        <div class="navigation-steps pd-remove">
            <div class="nav-form-grid">
                <form id="editFormForm" method="POST" action="{{ route('forms-new.editform', $form->id) }}">
                    @csrf

                    <label for="form">Form Name</label><br>
                    <input type="text" id="formName" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $form->name) }}" placeholder="Enter form name">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <br>
                    <label for="admin_emails">Admin Emails <span>(Separate emails with commas)</span></label><br>
                    <textarea id="admin_emails" name="admin_emails" rows="5"
                        class="form-control @error('admin_emails') is-invalid @enderror"
                        placeholder="Enter comma-separated emails">{{ old('admin_emails', $form->admin_emails) }}</textarea>
                    @error('admin_emails')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary d-none" id="submit-btn-edit-form">
                        <i class="fa fa-check"></i> Update Form
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="create-form-CTA save-continue-outer">
        <a href="#" id="saveEditBtn">Update Changes <img src="{{ asset('images/save-btn.svg') }}" alt="icon"></a>
    </div>
</div>
@endsection

@section('customScript')
<script>
    $(document).ready(function () {
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
        }

        function isValidFormName(formName) {
            return /^[A-Za-z0-9\- ]+$/.test(formName);
        }

        $('#saveEditBtn').click(function (e) {
            e.preventDefault();

            $('.invalid-feedback-email').remove();
            let formName = $('#formName').val().trim();
            let adminEmails = $('#admin_emails').val().trim();
            let hasError = false;

            if (!formName) {
                $('#formName').after('<div class="invalid-feedback-email text-danger">Form name is required.</div>');
                hasError = true;
            } else if (!isValidFormName(formName)) {
                $('#formName').after('<div class="invalid-feedback-email text-danger">Only alphanumeric, spaces, and dashes allowed.</div>');
                hasError = true;
            } else if (formName.length > 30) {
                $('#formName').after('<div class="invalid-feedback-email text-danger">Max 30 characters allowed.</div>');
                hasError = true;
            }

            if (adminEmails !== '') {
                let emails = adminEmails.split(',').map(e => e.trim()).filter(e => e !== '');
                let invalidEmails = [];
                let duplicates = [];
                let seen = new Set();

                emails.forEach(email => {
                    if (!isValidEmail(email)) {
                        invalidEmails.push(email);
                    } else if (seen.has(email.toLowerCase())) {
                        duplicates.push(email);
                    } else {
                        seen.add(email.toLowerCase());
                    }
                });

                if (adminEmails.includes(' ') && !adminEmails.includes(',')) {
                    invalidEmails.push('Emails must be separated by commas');
                }

                if (invalidEmails.length || duplicates.length) {
                    let message = '';
                    if (invalidEmails.length) message += `Invalid email(s): ${invalidEmails.join(', ')}<br>`;
                    if (duplicates.length) message += `Duplicate email(s): ${duplicates.join(', ')}`;
                    $('#admin_emails').after(`<div class="invalid-feedback-email text-danger">${message}</div>`);
                    hasError = true;
                }
            }

            if (!hasError) {
                $('#submit-btn-edit-form').click();
            }
        });
    });
</script>
@endsection
