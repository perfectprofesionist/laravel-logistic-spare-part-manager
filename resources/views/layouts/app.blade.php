{{-- 
    Main Application Layout (app.blade.php)
    
    This Blade template serves as the primary layout for the entire application.
    It provides a responsive navigation system with authentication-aware sidebar,
    user dropdown menu, and includes all necessary CSS/JS dependencies.
    
    Features:
    - Responsive Bootstrap navigation bar
    - Authentication-aware sidebar navigation
    - User profile dropdown with logout functionality
    - Form builder integration
    - File upload capabilities (Dropzone)
    - Enhanced dropdowns (Select2)
    - SweetAlert2 for user notifications
    - Session message handling with auto-dismiss
    - Password visibility toggle functionality
    - Delete confirmation dialogs
    
    Navigation Sections (for authenticated users):
    - Forms management
    - Products management
    - Make management
    - Model management
    
    Authentication Features:
    - Login/Register links for guests
    - User profile dropdown for authenticated users
    - Secure logout with CSRF protection
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Meta tags for character encoding, viewport, and CSRF protection --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Spare Parts Manager</title>

    {{-- Bootstrap CSS and Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- FontAwesome for enhanced icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- jQuery for JavaScript functionality --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Dropzone CSS for file upload functionality --}}
    <link
    rel="stylesheet"
    href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
    type="text/css"
  />
  
  {{-- Select2 CSS for enhanced dropdowns --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  {{-- Custom CSS with cache-busting version parameter --}}
  <link rel="stylesheet" href="{{ asset('css/newstyle.css') }}?v={{ time() }}">

</head>

<body>
    {{-- Main application container --}}
    <div id="app">
        {{-- Top navigation bar --}}
        <nav class="n-navbar navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                {{-- Brand/Logo link to forms index --}}
                <a class="navbar-brand" href="{{ route('forms.index') }}">
                    Forms
                </a>
                
                {{-- Mobile navigation toggle button --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Navigation menu items --}}
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        {{-- Guest user navigation (not authenticated) --}}
                        @guest
                            {{-- Login link for guests --}}
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            {{-- Register link (commented out) --}}
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            {{-- Authenticated user dropdown menu --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    {{-- Profile link --}}
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    {{-- Logout link with JavaScript form submission --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    {{-- Hidden logout form for CSRF protection --}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Main content area with sidebar and main content --}}
        <div class="container-fluid">
            <div class="row des-wrap">
                {{-- Sidebar Navigation - Only visible for authenticated users --}}
                @auth
                    {{-- Responsive sidebar with Bootstrap classes --}}
                    <nav class="col-md-3 col-lg-2 d-md-block sidebar n-sidebar">
                        <ul class="nav flex-column">
                            {{-- Forms Management Link --}}
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Request::is('forms*') ? 'active' : '' }}"
                                    href="{{ route('forms.index') }}">
                                    <i class="fa-solid fa-file-lines"></i> All Forms
                                </a>
                            </li>
                            {{-- Products Management Link --}}
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Request::is('products*') ? 'active' : '' }}"
                                    href="{{ route('products.index') }}">
                                    <i class="fa-solid fa-boxes-packing"></i> Products
                                </a>
                            </li>
                            {{-- Make Management Link --}}
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Request::is('make*') ? 'active' : '' }}"
                                    href="{{ route('make.index') }}">
                                    <i class="fa-solid fa-car"></i> Make
                                </a>
                            </li>
                            {{-- Model Management Link --}}
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Request::is('model*') ? 'active' : '' }}"
                                    href="{{ route('model.index') }}">
                                    <i class="fa-solid fa-wrench"></i> Model
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endauth

                {{-- Main content area where page content will be rendered --}}
                <main class="n-main">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    {{-- JavaScript Libraries and Dependencies --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    {{-- Dropzone JavaScript for file upload functionality --}}
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
   
    @yield('customScript') {{-- Custom scripts will be placed here --}}
    
    {{-- Main JavaScript functionality for the application --}}
    <script>
        $(document).ready(function() {
            {{-- Function to show SweetAlert with a 1.1-second timer --}}
            function showAlert(type, title, message) {
                Swal.fire({
                    icon: type,
                    title: title,
                    text: message,
                    timer: 1100, // Auto-close after 1.1 seconds
                    timerProgressBar: true, // Show timer progress bar
                    confirmButtonText: "OK"
                });
            }

            {{-- Check for Laravel session messages and show appropriate alert --}}
            @if (session('success'))
                showAlert('success', 'Success', "{{ session('success') }}");
            @endif

            @if (session('error'))
                showAlert('error', 'Error', "{{ session('error') }}");
            @endif

            @if (session('info'))
                showAlert('info', 'Information', "{{ session('info') }}");
            @endif

            @if (session('warning'))
                showAlert('warning', 'Warning', "{{ session('warning') }}");
            @endif

            {{-- Delete confirmation dialog using SweetAlert2 --}}
            $(document).on("click", ".deleteButton", function(e) {
                e.preventDefault();
                let deleteForm = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit(); // Submit form if confirmed
                    }
                });
            });

            {{-- Password visibility toggle for main password field --}}
            $('#togglePassword').on('click', function () {
                let input = $('#password');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).text(type === 'password' ? 'Show' : 'Hide');
            });

            {{-- Password visibility toggle for confirm password field --}}
            $('#toggleConfirmPassword').on('click', function () {
                let input = $('#confirmPassword');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).text(type === 'password' ? 'Show' : 'Hide');
            });

        });
    </script>
</body>

</html>
