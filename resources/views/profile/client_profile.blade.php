@extends('layout.client')
@section('content')
    @include('shared.errors')
    @include('shared.flash_message')

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ __('Update User Profile') }}</h4>
                        </div>

                        <div class="container">
                            @if ($user->profile_photo)
                                <td> <img src="{{ url('uploads/profile_photos', $user->profile_photo) }}" height="120"
                                        width="120">
                                </td>
                            @else
                                <td> <img src="{{ url('logo/avatar.jpg') }}" height="120" width="120">
                                </td>
                            @endif
                        </div>

                        <div class="card-body">
                            <p class="italic">
                                <small>{{ __('The field labels marked with * are required input fields') }}.</small></p>
                            <form method="POST" action="{{ route('profile_update', $user->id) }}"
                                enctype="multipart/form-data">
                                {{ method_field('PUT') }}
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('First Name') }}</label>
                                            <input type="text" name="first_name" value="{{ $user->first_name }}"
                                                required class="form-control" />
                                            @if ($errors->has('first_name'))
                                                <span>
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Last Name') }}</label>
                                            <input type="text" name="last_name" value="{{ $user->last_name }}"
                                                required class="form-control" />
                                            @if ($errors->has('last_name'))
                                                <span>
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('file.Username') }}</label>
                                            <input readonly type="text" name="username" value="{{ $user->username }}"
                                                required class="form-control" />
                                            @if ($errors->has('username'))
                                                <span>
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('file.Email') }} *</label>
                                            <input type="email" name="email" value="{{ $user->email }}" required
                                                class="form-control">
                                            @if ($errors->has('email'))
                                                <span>
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('file.Phone') }} *</label>
                                            <input type="text" name="contact_no" value="{{ $user->contact_no }}"
                                                required class="form-control" />
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>{{ __('Image') }}</label>
                                            <input type="file" name="profile_photo" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" value="{{ trans('file.submit') }}"
                                                class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ __('Change Password') }} ({{ trans('file.Optional') }})</h4>
                        </div>

                        <div class="card-body">
                            <p class="italic">
                                <small>{{ __('The field labels marked with * are required input fields') }}.</small></p>
                            <form method="POST" action="{{ route('change_password', $user->id) }}">
                                @csrf

                                <div class="col-md-6">

                                    <div class="card-header d-flex align-items-center">

                                        <div class="row">
                                            <div class="col-md-12">


                                                <div class="form-group">
                                                    <label>{{ __('New Password') }} *</label>
                                                    <input type="password" name="password" required class="form-control"
                                                        placeholder="{{ __('min:4 characters') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('Confirm Password') }} *</label>
                                                    <input type="password" name="password_confirmation" id="confirm_pass"
                                                        required class="form-control"
                                                        placeholder="{{ trans('file.Re-Type') }} {{ trans('file.Password') }}">
                                                </div>
                                                <div class="form-group">
                                                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" value="{{ trans('file.submit') }}"
                                                        class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        (function($) {

            "use strict";

            $("ul#setting").siblings('a').attr('aria-expanded', 'true');
            $("ul#setting").addClass("show");
            $("ul#setting #user-menu").addClass("active");


            $(document).ready(function() {
                $(".alert").slideDown(300).delay(5000).slideUp(300);
            });

            $('.selectpicker').selectpicker({
                style: 'btn-link',
            });

            $('#confirm_pass').on('input', function() {

                if ($('input[name="password"]').val() != $('input[name="password_confirmation"]').val())
                    $("#divCheckPasswordMatch").html('{{ __('Password does not match! Please type again') }}');
                else
                    $("#divCheckPasswordMatch").html('{{ __('Password matches') }}');

            });
        })(jQuery);
    </script>
@endsection
