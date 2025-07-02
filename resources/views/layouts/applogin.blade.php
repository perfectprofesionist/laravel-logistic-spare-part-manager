{{-- 
    Application Login Layout (applogin.blade.php)
    
    This Blade template serves as the main layout for authenticated users in the application.
    It provides a responsive sidebar navigation with access to key management sections
    and includes all necessary CSS/JS dependencies for the admin interface.
    
    Features:
    - Responsive sidebar navigation for authenticated users
    - Bootstrap-based responsive design
    - FontAwesome icons for navigation items
    - SweetAlert2 for enhanced user notifications
    - jQuery UI for interactive components
    - Form builder integration
    - Select2 for enhanced dropdowns
    - Session message handling with auto-dismiss
    - Confirmation dialogs for delete actions
    
    Navigation Sections:
    - Forms management
    - Products management
    - Make management
    - Model management
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Meta tags for character encoding, viewport, and CSRF protection --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Spare Parts Manager</title>

    {{-- Commented out alternative CSS/JS includes (kept for reference) --}}
    {{--
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/newstyle.css') }}"> --}}

    {{-- Active CSS includes with cache-busting version parameters --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/style.css") }}?v={{ time() }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/media.css") }}?v={{ time() }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

</head>

<body>
    {{-- Main application container --}}
    <div id="app">

        {{-- Fluid container for full-width layout --}}
        <div class="container-fluid">
            <div class="row">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

        });
    </script>
</body>

</html>
