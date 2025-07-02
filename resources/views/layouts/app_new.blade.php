<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Spare Parts Manager</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/app.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css')}}/slick.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css')}}/slick-theme.css">
    <link rel="stylesheet" href="{{ asset('css/newstyle.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}?v={{ time() }}" type="text/css">
    
</head>

<body>
    <header class="header-main-outer-panel">
        <div class="container-fluid">
            <div class="row">
                <span class="tusform-open-nav" onclick="openNav()"><i class="fa fa-bars"></i></span>
                <div class="col-6 pade-none logo-con"><a href="{{ route('forms-new.index') }}"><img
                            src="{{ asset('images/site-logo.png') }}" width="150" height="100" alt="Logo"></a></div>
                <div class="col-6 pade-none  profile-outer">
                    <div class="profile-inner">
                        <div class="dropdown-toggle profile-info-inner" data-bs-toggle="dropdown" aria-expanded="false"
                            role="button">
                            <span class="admin-pic"><img src="{{ asset('images/admin.png') }}" alt="Pic" width="30" height="30" class="rounded-circle m-0"></span>
                            <span class="admin-name-con">Welcome Admin</span> <img
                                src="{{ asset('images/down-arrow.svg') }}" alt="icon">
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('Profile') }}
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="tusform-area-outer">
        <div class="tusform-left-bar-links tusform-staff-sidenav" id="mySidenav">
            <div class="tusform-inner-links">
                <a href="javascript:void(0)" class="tusform-close-btn" onclick="closeNav()"><img
                        src="{{ asset('images/close.png') }}" alt="icon"></a>
                @auth

                    <div class="tusform-nav-links">
                        <a class="nav-link {{ Request::is('back/forms-new*') ? 'tusform-link-active' : '' }}"
                            href="{{ route('forms-new.index') }}"><span><img src="{{ asset('images/dashboard-icon.svg') }}"
                                    alt="icon"></span>{{ __('Dashboard') }}
                        </a>
                        <a class="nav-link {{ Request::is('back/products*') ? 'tusform-link-active' : '' }}"
                            href="{{ route('products.index') }}">
                            <span><img src="{{ asset('images/img-product-icon.svg') }}"
                                    alt="icon"></span>{{ __('Products') }}
                        </a>
                        <a class="nav-link {{ Request::is('back/make*') ? 'tusform-link-active' : '' }}"
                            href="{{ route('make.index') }}">
                            <span><img src="{{ asset('images/make-icon.svg') }}"
                                    alt="icon"></span>{{ __('Make') }}
                        </a>
                        <a class="nav-link {{ Request::is('back/model*') ? 'tusform-link-active' : '' }}"
                            href="{{ route('model.index') }}">
                            <span><img src="{{ asset('images/model-icon.svg') }}"
                                    alt="icon"></span>{{ __('Model') }}
                        </a>
                        <a class="nav-link {{ Request::is('back/messages*') ? 'tusform-link-active' : '' }}"
                            href="{{ route('messages.index') }}">
                            <span><img src="{{ asset('images/dashboard-icon.svg') }}"
                                    alt="icon"></span>{{ __('Messages') }}
                        </a>
                    </div>
                @endauth

            </div>
        </div>
        <div class="tusform-inner-right-bar">

            @yield('content')
            <!--Create Form Screen -->
            {{-- <div class="create-form-outer">
                <div class="create-form-left"><img src="images/form-pic.png" alt="Form Icon"></div>
                <div class="create-form-right">
                    <h2>Create Form <span><img src="images/create-form-icon.png" alt="arrow"></span></h2>
                </div>
            </div>


            <div style="height: 80px;"></div>

            <!--Create Form Screen 02 -->
            <div class="craete-form-outer-panel">
                <div class="col-12 pade-none create-heading-con">
                    <h2>Forms</h2>
                    <div class="create-form-CTA"><a href="#"><img src="images/plus-icon.png" alt="Plus">
                            Create Form</a></div>
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
                            <div class="form-heading-con">
                                <div class="home-icon"><img src="images/home-icon.png" alt="Home icon"></div>
                                <div class="form-left-con form-content-con">

                                    <div class="form-content">Form1</div>
                                    <div class="form-content">Published</div>
                                    <div class="form-content">25th Apr 2025</div>
                                    <div class="form-content">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-content">
                                        <a href="#" class="action-icons"><img src="images/view-icon.svg"
                                                alt="View"></a>
                                        <a href="#" class="action-icons"><img src="images/edit-icon.svg"
                                                alt="Edit"></a>
                                        <a href="#" class="action-icons"><img src="images/trash-icon.svg"
                                                alt="Trash"></a>
                                        <a href="#" class="action-icons"><img src="images/copy.svg"
                                                alt="Copy"></a>
                                    </div>
                                    <div class="form-content form-condition-con"><a href="#"
                                            class="form-condition-link">Form Conditions</a></div>
                                </div>
                                <div class="form-right-con"><a href="#"
                                        class="check-entries-cta"><span>10</span> Check Entries</a></div>
                            </div>

                            <div class="form-heading-con">
                                <div class="form-left-con form-content-con">
                                    <div class="form-content">Form2</div>
                                    <div class="form-content">Draft</div>
                                    <div class="form-content">25th Apr 2025</div>
                                    <div class="form-content">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-content">
                                        <a href="#" class="action-icons"><img src="images/view-icon.svg"
                                                alt="View"></a>
                                        <a href="#" class="action-icons"><img src="images/edit-icon.svg"
                                                alt="Edit"></a>
                                        <a href="#" class="action-icons"><img src="images/trash-icon.svg"
                                                alt="Trash"></a>
                                        <a href="#" class="action-icons"><img src="images/copy.svg"
                                                alt="Copy"></a>
                                    </div>
                                    <div class="form-content form-condition-con"><a href="#"
                                            class="form-condition-link">Form Conditions</a> <span
                                            class="set-home-con">Set as Home</span></div>
                                </div>
                                <div class="form-right-con"><a href="#"
                                        class="check-entries-cta"><span>03</span> Check Entries</a></div>
                            </div>

                        </div>

                    </div>

                </div>
            </div> --}}

            <!--Create Form Screen 03 -->


        </div>
    </section>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script  src="{{ asset('js') }}/slick.min.js"></script>
    <script src="{{ asset('js') }}/custom.js?v={{ time() }}" ></script>
    @yield('customScript') <!-- Custom scripts will be placed here -->
    <script>
        $(document).ready(function() {
            // Function to show SweetAlert with a 2-second timer
            function showAlert(type, title, message) {
                Swal.fire({
                    icon: type,
                    title: title,
                    text: message,
                    timer: 1100, // Auto-close after 2 seconds
                    timerProgressBar: true, // Show timer progress bar
                    confirmButtonText: "OK"
                });
            }

            // Check for Laravel session messages and show appropriate alert
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

            $('#togglePassword').on('click', function() {
                let input = $('#password');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).text(type === 'password' ? 'Show' : 'Hide');
            });

            // Toggle visibility for "Confirm Password"
            $('#toggleConfirmPassword').on('click', function() {
                let input = $('#confirmPassword');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).text(type === 'password' ? 'Show' : 'Hide');
            });

        });
    </script>
</body>

</html>
