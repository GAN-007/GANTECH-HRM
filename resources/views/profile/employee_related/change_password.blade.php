@include('shared.errors')
@include('shared.flash_message')
<section>
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>{{__('Change Password')}}</h4>
                </div>

                <div class="card-body">
                    <p class="italic">
                        <small>{{__('The field labels marked with * are required input fields')}}.</small>
                    </p>
                    <form method="POST" action="{{ route('change_password',$employee->id)}}">
                        @csrf


                        <div class="card-header d-flex align-items-center">

                            <div class="row">

                                <div class="form-group">
                                    <label>{{__('New Password')}} *</label>
                                    <input type="password" name="password" required class="form-control"
                                           placeholder="{{__('min:4 characters')}}">
                                </div>

                                <div class="form-group">
                                    <label>{{__('Confirm Password')}} *</label>
                                    <input type="password" name="password_confirmation" id="confirm_pass" required
                                           class="form-control"
                                           placeholder="{{trans('file.Re-Type')}} {{trans('file.Password')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</section>


