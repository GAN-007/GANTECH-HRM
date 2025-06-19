<?php $general_setting = DB::table('general_settings')->latest()->first(); ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('css/style.default.css') ?>" id="theme-stylesheet"
          type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('css/custom-' . $general_setting->theme) ?>" type="text/css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- Font Awesome CSS-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}"></noscript>

</head>
<body>
<div class="page login-page">
    <div class="container">
        <div class="form-outer text-center d-flex align-items-center">
            <div class="form-inner">
                <div class="logo"><span>{{$general_setting->site_title}}</span></div>

                @include('shared.errors')

                <form method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf
                    <div class="form-group-material">


                        <input id="username" type="text" class="input-material @error('username') is-invalid @enderror"
                               name="username" value="{{ old('username') }}" required autofocus>
                        <label for="username" class="label-material">{{ __('Username') }}</label>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group-material">


                        <input id="password" type="password"
                               class="input-material @error('password') is-invalid @enderror" name="password" required
                               autocomplete="current-password">
                        <label for="password" class="label-material">{{ __('Password') }}</label>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                    </div> --}}
                    <br>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
                <!-- This three buttons for demo only-->

                @if (env('PRODUCT_MODE')==="DEMO" || env('PRODUCT_MODE')==="DEVELOPER")
                    <button type="submit" class="btn btn-success btn-sm default admin-btn">LogIn as Admin</button>
                    <button type="submit" class="btn btn-info btn-sm default staff-btn">LogIn as Staff</button>
                    <button type="submit" class="btn btn-warning btn-sm default client-btn">LogIn as Client</button>
                    {{-- <p class="text-center mt-4 text-danger font-weight-bold font-italic">[For attendance device related features, Need to purchase attendance device addon.]</p> --}}
                @endif
                <br><br>
                {{-- <p>Or,</p>

                <a href="{{ route('auth.redirect.google') }}" class="mt-2 btn btn-dark "><b><i class="fa fa-google" aria-hidden="true"></i><span class="ml-2"></b>Login with Google</span></a> --}}

                <br><br>
                @if (Route::has('password.request'))
                    <a class="forgot-pass" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif

                @if (env('PRODUCT_MODE')==="DEMO" || env('PRODUCT_MODE')==="DEVELOPER")
                    <p class="text-center mt-4 text-danger font-weight-bold font-italic">[For attendance device related features, Need to purchase attendance device addon.]</p>
                @endif
            </div>
            @php
                $general_settings = \App\Models\GeneralSetting::latest()->first();
            @endphp
            <div class="copyrights text-center">
                <p>{{ __('Developed by')}} <a href={{$general_settings->footer_link}} class="external">{{$general_settings->footer}}</a></p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
</body>
</html>

<script type="text/javascript">
    (function($) {

        "use strict";

        $('.admin-btn').on('click', function () {
            $("input[name='username']").focus().val('admin');
            $("input[name='password']").focus().val('admin');
        });

        $('.staff-btn').on('click', function () {
            $("input[name='username']").focus().val('staff');
            $("input[name='password']").focus().val('staff');
        });
        $('.client-btn').on('click', function () {
            $("input[name='username']").focus().val('client');
            $("input[name='password']").focus().val('client');
        });

        // ------------------------------------------------------- //
        // Material Inputs
        // ------------------------------------------------------ //

        let materialInputs = $('input.input-material');

        // activate labels for prefilled values
        materialInputs.filter(function () {
            return $(this).val() !== "";
        }).siblings('.label-material').addClass('active');

        // move label on focus
        materialInputs.on('focus', function () {
            $(this).siblings('.label-material').addClass('active');
        });

        // remove/keep label on blur
        materialInputs.on('blur', function () {
            $(this).siblings('.label-material').removeClass('active');

            if ($(this).val() !== '') {
                $(this).siblings('.label-material').addClass('active');
            } else {
                $(this).siblings('.label-material').removeClass('active');
            }
        });
    })(jQuery);
</script>
