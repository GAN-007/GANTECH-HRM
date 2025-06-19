@extends('layout.main')

@section('content')

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3>{{__('Edit Office Shift')}}</h3>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{__('The field labels marked with * are required input fields')}}.
                                </small>
                            </p>
                            <form method="post" id="sample_form" class="form-horizontal">

                                @csrf
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.Company')}} *</label>
                                            <select name="company_id" id="company_id" class="form-control selectpicker"
                                                    data-live-search="true" data-live-search-style="contains"
                                                    title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" @if($office_shift->company_id==$company->id) selected @endif >{{$company->company_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>{{trans('file.Shift')}} *</label>
                                        <input type="text" name="shift_name" id="shift_name" class="form-control"
                                               placeholder="shift name" value="{{$office_shift->shift_name}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{trans('file.Monday')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="monday_in" id="monday_in" class="form-control time mb-3"
                                                       value="{{$office_shift->monday_in}}" placeholder="{{__('In Time')}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="monday_out" id="monday_out"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->monday_out}}" placeholder="{{__('Out Time')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{trans('file.Tuesday')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="tuesday_in" id="tuesday_in"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->tuesday_in}}" placeholder="{{__('In Time')}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="tuesday_out" id="tuesday_out"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->tuesday_out}}" placeholder="{{__('Out Time')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{trans('file.Wednesday')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="wednesday_in" id="wednesday_in"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->wednesday_in}}" placeholder="{{__('In Time')}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="wednesday_out" id="wednesday_out"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->wednesday_out}}" placeholder="{{__('Out Time')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{trans('file.Thursday')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="thursday_in" id="thursday_in"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->thursday_in}}" placeholder="{{__('In Time')}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="thursday_out" id="thursday_out"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->thursday_out}}" placeholder="{{__('Out Time')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{trans('file.Friday')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="friday_in" id="friday_in" class="form-control time mb-3"
                                                       value="{{$office_shift->friday_in}}" placeholder="{{__('In Time')}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="friday_out" id="friday_out"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->friday_out}}" placeholder="{{__('Out Time')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{trans('file.Saturday')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="saturday_in" id="saturday_in"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->saturday_in}}" placeholder="{{__('In Time')}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="saturday_out" id="saturday_out"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->saturday_out}}" placeholder="{{__('Out Time')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{trans('file.Sunday')}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="sunday_in" id="sunday_in" class="form-control time mb-3"
                                                       value="{{$office_shift->sunday_in}}" placeholder="{{__('In Time')}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="sunday_out" id="sunday_out"
                                                       class="form-control time mb-3"
                                                       value="{{$office_shift->sunday_out}}" placeholder="{{__('Out Time')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <span id="form_result"></span>


                                    <div class="col-md-6 offset-md-3 mt-3">
                                        <div class="form-group" align="center">
                                            <input type="hidden" name="hidden_id" id="hidden_id" value="{{$office_shift->id}}"/>
                                            <input type="submit" name="action_button" id="action_button"
                                                   class="btn btn-warning btn-block"
                                                   value={{trans('file.Update')}} />
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


@endsection

@push('scripts')
<script>
    (function($) {
        "use strict";

        $('.time').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'done',
            twelvehour: true,
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('office_shift.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
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
                        setTimeout(function () {
                            $('#formModal').modal('hide');
                            $('#office_shift-table').DataTable().ajax.reload();
                            $('#sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });

    })(jQuery);
</script>
@endpush
