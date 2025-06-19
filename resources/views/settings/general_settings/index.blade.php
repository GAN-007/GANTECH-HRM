@extends('layout.main')

@section('content')


    <span id="form_result"></span>

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{__('General Setting')}}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic"><small>{{__('The field labels marked with * are required input fields')}}.</small></p>
                            <form method="POST"  id="general_settings_form" action="{{route('general_settings.update',1)}}" enctype="multipart/form-data">
                                @csrf


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{__('Site Title')}} *</strong></label>
                                            <input type="text" name="site_title" class="form-control" value="{{$general_settings_data->site_title ?? ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{__('Site Logo')}}</strong></label>
                                            <input type="file" name="site_logo" class="form-control" value=""/>
                                        </div>
                                        @if($errors->has('site_logo'))
                                            <span>
                                       <strong>{{ $errors->first('site_logo') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Currency')}} *</strong></label>
                                            <input type="text" name="currency" class="form-control" value="{{$general_settings_data->currency ?? ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{__('Currency Format')}} *</strong></label><br>

                                            @if($general_settings_data->currency_format == 'prefix')
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="prefix" checked> {{trans('file.Prefix')}}
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="suffix"> {{trans('file.Suffix')}}
                                                </label>
                                            @else
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="prefix"> {{trans('file.Prefix')}}
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="suffix" checked> {{trans('file.Suffix')}}
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{__('Time Zone')}}</strong></label>

                                            <select name="timezone" class="selectpicker form-control" data-live-search="true" title="{{__('Time Zone')}}...">
                                                @foreach($zones_array as $zone)
                                                    <option value="{{$zone['zone']}}" {{($general_settings_data->time_zone == $zone['zone']) ? "selected" : ''}} >{{$zone['diff_from_GMT'] . ' - ' . $zone['zone']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{__('Default Bank')}} *</strong></label>
                                            <select name="account_id" id="account_id"  class="form-control selectpicker" required
                                                    data-live-search="true" data-live-search-style="contains"
                                                    title='{{__('Selecting',['key'=>trans('file.Account')])}}...'>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->id}}" {{($account->id == $general_settings_data->default_payment_bank) ? 'selected':''}}>{{$account->account_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{__('Date Format')}} *</strong></label>
                                            @if($general_settings_data)
                                                <input type="hidden" id="date_format_hidden"  name="date_format_hidden" value="{{$general_settings_data->date_format}}">
                                            @endif
                                            <select name="date_format" class="selectpicker form-control">
                                                <option value="d-m-Y">dd-mm-yyyy(23-05-2020)</option>
                                                <option value="Y-m-d">yyyy-mm-dd(2020-05-23)</option>

                                                <option value="m/d/Y">mm/dd/yyyy(05/23/2020)</option>
                                                <option value="Y/m/d">yyyy/mm/dd(2020/05/23)</option>

                                                <option value="Y-M-d">yyyy-MM-dd(2020-May-23)</option>
                                                <option value="M-d-Y">MM-dd-yyyy(May-23-2020)</option>
                                                <option value="d-M-Y">dd-MM-yyyy(23-May-2020)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Footer')}} </strong></label>
                                            <input type="text" name="footer" class="form-control" value="{{$general_settings_data->footer ?? ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Footer_Link')}} </strong></label>
                                            <input type="text" name="footer_link" placeholder="https://www.lion-coders.com" class="form-control" value="{{$general_settings_data->footer_link ?? ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-4 form-check">
                                            <input type="checkbox" name="rtl_layout" class="form-check-input" value="1" {{env('RTL_LAYOUT')!=NULL ? 'checked':''}} />
                                            <label class="mr-4 form-check-label"><strong>{{trans('file.RTL Layout')}} </strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-4 form-check">
                                            <input type="checkbox" name="enable_clockin_clockout" class="form-check-input" value="1" {{env('ENABLE_CLOCKIN_CLOCKOUT')!=NULL ? 'checked':''}}/>
                                            <label class="mr-4 form-check-label"><strong>{{trans('file.Enable Clock In and Clock Out')}} </strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-4 form-check">
                                            <input type="checkbox" name="enable_early_clockin" class="form-check-input" value="1" {{env('ENABLE_EARLY_CLOCKIN')!=NULL ? 'checked':''}}/>
                                            <label class="mr-4 form-check-label"><strong>{{trans('file.Enable Early Clock In (Added to Worktime)')}} </strong></label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group mt-4">
                                            <label><strong>{{__('file.Attendance Device Date Format')}}</strong></label>
                                            <select name="Attendance_Device_date_format" class="selectpicker form-control">
                                                <option {{env('ATTENDANCE_DEVICE_DATE_FORMAT') =='d/m/Y' ? 'selected':''}} value="d/m/Y">dd/mm/yyyy(23/05/2022)</option>
                                                <option {{env('ATTENDANCE_DEVICE_DATE_FORMAT') =='m/d/Y' ? 'selected':''}} value="m/d/Y">mm/dd/yyyy(05/23/2022)</option>
                                                <option {{env('ATTENDANCE_DEVICE_DATE_FORMAT') =='Y/m/d' ? 'selected':''}} value="Y/m/d">yyyy/mm/dd(2022/05/23)</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                                <br><br>
                                <div class="d-flex justify-content-center">
                                    <input type="submit" id="submit" value="{{trans('file.submit')}}" class="btn btn-primary btn-lg btn-block">
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
    <script type="text/javascript">
        (function($) {
            "use strict";

            $("ul#setting").siblings('a').attr('aria-expanded','true');
            $("ul#setting").addClass("show");
            $("ul#setting #general-setting-menu").addClass("active");

            $('select[name=date_format]').val(($('#date_format_hidden')).val());

            if($("input[name='timezone_hidden']").val()){
                $('select[name=timezone]').val($("input[name='timezone_hidden']").val());
                $('.selectpicker').selectpicker('refresh');
            }

            $('.selectpicker').selectpicker({
                style: 'btn-link',
            });
        })(jQuery);
    </script>
@endpush
