@extends('layout.main')
@section('content')
    <section>
        <div class="container-fluid">

            <!-- Import CSV File (Device) -->
            {{-- <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Import CSV file (Device)')}}</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">Please take a note of the date format you get in the CSV file downloaded/exported from your attendance device(CSV). Now from within PeoplePro, go to- customize settings > general Settings and select the same date format from dropdown for the option named- 'Attendance device date format'</p>
                    <p class="card-text">The first line in downloaded file should remain as it is. Please do not change
                        the order of columns in file.</p>
                    <form action="{{ route('attendances.importDeviceCsv') }}" autocomplete="off" enctype="multipart/form-data"
                          method="post" accept-charset="utf-8">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <fieldset class="form-group">
                                        <label for="logo">{{trans('file.Upload')}} {{trans('file.File')}}</label>
                                        <input type="file" class="form-control-file" name="file"
                                               accept=".xlsx, .xls, .csv">
                                        <small>{{__('Please select csv/excel')}} file (allowed file size 2MB)</small>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1">
                            <div class="form-actions box-footer">
                                <button name="import_form" type="submit" class="btn btn-primary"><i
                                            class="fa fa fa-check-square-o"></i> {{trans('file.Save')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}


            <!-- Import EXCEL/CSV file (Manual) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Import EXCEL/CSV file (Manual)')}}</h3>
                </div>
                <div class="card-body">
                    <h6><a href="{{url('sample_file/sample_attendance.xlsx')}}" class="btn btn-primary"> <i
                        class="fa fa-download"></i> {{__('Download Sample File')}} </a></h6>
                    <p class="card-text">The first line in downloaded sample file should remain as it is. Please do not change
                        the order of columns in file.</p>
                    <p class="card-text">The correct column order is (Staff Id, Attendance Date, Clock In, Clock Out).</p>
                    <ul>
                        <li>Date format should be (According to general settings)</li>
                        <li>You must follow the file, otherwise you will get an error while importing the file.</li>
                    </ul>

                    <form action="{{ route('attendances.importPost') }}" autocomplete="off" enctype="multipart/form-data"
                          method="post" accept-charset="utf-8">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <fieldset class="form-group">
                                        <label for="logo">{{trans('file.Upload')}} {{trans('file.File')}}</label>
                                        <input type="file" class="form-control-file" id="file" name="file"
                                               accept=".xlsx, .xls, .csv">
                                        <small>{{__('Please select excel/csv')}} file (allowed file size 2MB)</small>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1">
                            <div class="form-actions box-footer">
                                <button name="import_form" type="submit" class="btn btn-primary"><i
                                            class="fa fa fa-check-square-o"></i> {{trans('file.Save')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>


@endsection
