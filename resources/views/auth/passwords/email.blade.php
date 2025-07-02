@extends('layouts.applogin')

@section('content')


<div class="login-main-outer">
    <div class="login-inner-grid">
        <div class="col-12 pade-none login-logo"><span><img src="{{ asset("images/site-logo.png") }}" alt="Logo"  width="250" height="100" style="margin-bottom: 10px; border-radius: 20px;"></span></div>
           <h1>{{ __('Reset Password') }}</h1>

           @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif


           <form method="POST" action="{{ route('password.email') }}">
            @csrf

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              
                <button type="submit" class="login-btn mt-4">
                    {{ __('Send Password Reset Link') }}
                </button>

                @if (Route::has('login'))
                    <div class="col-12 pade-none  login-forgot-pass">
                        <a class="btn btn-link" href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                    </div>
                @endif
           </form>
    </div>
</div>



@endsection
