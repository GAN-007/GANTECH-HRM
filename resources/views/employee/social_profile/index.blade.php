@if(auth()->user()->can('store-details-employee') || auth()->user()->id == $employee->id)

    <div class="modal-body">
        <span id="social_form_result"></span>
        <form method="post" id="social_sample_form" class="form-horizontal"
              action="{{route('social_profile.store',$employee->id)}}">

            @csrf
            <div class="row">

                <div class="col-md-6 form-group">
                    <label>{{__('Facebook Profile')}}</label>
                    <input type="text" name="fb_id" id="fb_id" placeholder="{{__('Facebook Profile')}}"
                            class="form-control" value="{{ $employee->fb_id }}">
                </div>

                <div class="col-md-6 form-group">
                    <label>{{__('Skype Profile')}}</label>
                    <input type="text" name="skype_id" id="skype_id" placeholder="{{__('Skype Profile')}}"
                            class="form-control" value="{{ $employee->skype_id }}">
                </div>


                <div class="col-md-6 form-group">
                    <label>{{__('LinkedIn Profile')}}</label>
                    <input type="text" name="linkedIn_id" id="linkedIn_id" placeholder="{{__('Linkedin Profile')}}"

                           class="form-control" value="{{$employee->linkedIn_id}}">
                </div>

                <div class="col-md-6 form-group">
                    <label>{{__('Twitter Profile')}}</label>
                    <input type="text" name="twitter_id" id="twitter_id" placeholder="{{__('Twitter Profile')}}"
                            class="form-control" value="{{ $employee->twitter_id }}">
                </div>

                {{-- <div class="col-md-12 form-group">
                    <label>{{__('Blogger Profile')}}</label>
                    <input type="text" name="blogger_id" id="blogger_id" placeholder="{{__('Blogger Profile')}}"
                            class="form-control" value="{{ $employee->blogger_id }}">
                </div> --}}
                <div class="col-md-12 form-group">
                    <label>{{__('Whats App Profile')}}</label>
                    <input type="text" name="whatsapp_id" id="whatsapp_id" placeholder="{{__('Whats App Profile')}}"
                            class="form-control" value="{{ $employee->whatsapp_id }}">
                </div>

                <div class="form-group row">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{trans('file.Save')}}
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </form>
    </div>
@endif

<script type="text/javascript">

    $(document).ready(function () {
        $(".alert").slideDown(300).delay(5000).slideUp(300);
    });

    var form = $('#social_sample_form');


    form.submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                var html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                }
                $('#social_form_result').html(html);

            }
        });
    });

</script>