{{-- 
    Profile Edit Page (profile/index.blade.php)
    
    This Blade template provides a user profile editing interface where authenticated users
    can update their personal information including name, email, and password.
    
    Features:
    - User profile information editing
    - Password change functionality with confirmation
    - Password visibility toggle buttons
    - Form validation with error display
    - CSRF protection for secure form submission
    - Bootstrap styling with custom design
    - Auto-complete disabled for security
    
    Form Fields:
    - Name (text input with current user's name)
    - Email (email input with current user's email)
    - New Password (password input with visibility toggle)
    - Confirm Password (password input with visibility toggle)
    
    Security Features:
    - CSRF token protection
    - Password confirmation requirement
    - Auto-complete disabled on form
    - Validation error display
    - Secure password input handling
--}}

@extends('layouts.app_new')

@section('content')
 {{-- Main container for profile editing interface --}}
 <div class="craete-form-outer-panel">
    <div class="row">
       
        {{-- Profile editing form container --}}
        <div class="profile-inner-grid">
            {{-- Page header with title --}}
            <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
              <h2>Edit Profile</h2>
           </div>

           {{-- Profile form card with shadow and styling --}}
           <div class="w-100 card shadow-lg  makes1-card create-make-name-con card-margin-outer">
                {{-- Profile update form with POST method and CSRF protection --}}
                <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                    @csrf {{-- CSRF protection token --}}

                    {{-- Name input field --}}
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               class="form-control ">
                        {{-- Display validation error for name field --}}
                        @error('name') <small class="text-warning">{{ $message }}</small> @enderror
                    </div>

                    {{-- Email input field --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               class="form-control ">
                        {{-- Display validation error for email field --}}
                        @error('email') <small class="text-warning">{{ $message }}</small> @enderror
                    </div>

                    {{-- New Password input field with visibility toggle --}}
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            {{-- Password input with auto-complete disabled for security --}}
                            <input type="password" name="password" id="password"
                                   class="form-control " autocomplete="new-password">
                            {{-- Password visibility toggle button --}}
                            <button type="button" class="btn custom-toggle" id="togglePassword">
                                Show
                            </button>
                        </div>
                        {{-- Display validation error for password field --}}
                        @error('password') <small class="text-warning">{{ $message }}</small> @enderror
                    </div>

                    {{-- Confirm Password input field with visibility toggle --}}
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            {{-- Confirm password input --}}
                            <input type="password" name="password_confirmation" id="confirmPassword"
                                   class="form-control ">
                            {{-- Confirm password visibility toggle button --}}
                            <button type="button" class="btn custom-toggle" id="toggleConfirmPassword">
                                Show
                            </button>
                        </div>
                    </div>
                    
                    {{-- Submit button container with full-width styling --}}
                    <div class="d-grid create-form-CTA">
                        <button >Update Profile</button>
                   </div>
                </form>
                </div>
            </div>

        
    </div>
</div>
@endsection

