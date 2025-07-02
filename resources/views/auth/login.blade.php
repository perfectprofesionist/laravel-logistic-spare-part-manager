@extends('layouts.applogin')

@section('content')

<div class="login-main-outer">
    <div class="login-inner-grid">
        <div class="col-12 pade-none login-logo"><span><img src="{{ asset('images/site-logo.png') }}" alt="Logo" width="250" height="100" style="margin-bottom: 10px; border-radius: 20px;"></span></div>
           <h1>Login</h1>
           <form method="POST" action="{{ route('login') }}">
            @csrf
               
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
               @error('email')
                    @if( $message != "These credentials do not match our records.")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @endif
                @enderror

                <div class="password-outer">

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                    <span class="position-absolute top-50 translate-middle-y me-3 mx-3" style="cursor: pointer; right: 5px;  font-size: 17px; opacity: 0.6;" id="togglePassword">
                                        <img id="passwordIcon" src="{{ asset('images') }}/eye-icon.png" alt="eye" width="20" height="20">
                                    </span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                

                
              
               <div class="reminder-con">
                    <label class="custom-checkbox">
                        <input class="form-check-input " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span> <span class="remember-text">{{ __('Remember Me') }}</span>
                    </label>
                </div>
             
                @error('email')
                    @if( $message == "These credentials do not match our records.")
                        <span class="invalid-feedback mb-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @endif
                @enderror
               <button type="submit" class="login-btn">
                    {{ __('Login') }}
                </button>

               @if (Route::has('password.request'))
                    <div class="col-12 pade-none  login-forgot-pass">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif
              
           </form>
    </div>
</div>

@endsection

@section('customScript')
<script>
    $(document).ready(function(){
        $("#togglePassword").click(function(){
            let passwordField = $("#password");
            let passwordIcon = $("#passwordIcon");
            let type = passwordField.attr("type") === "password" ? "text" : "password";
            passwordField.attr("type", type);
            passwordIcon.toggleClass("bi-eye-fill bi-eye-slash-fill");
        });
    });
</script>
@endsection
