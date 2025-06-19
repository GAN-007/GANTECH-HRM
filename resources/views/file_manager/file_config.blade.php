@extends('layout.main')
@section('content')

    @can('store-file_manager')
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="card-header"><h3 class="card-title">{{__('File Manager Configuration')}}</h3></div>

                        <span id="form_result"></span>

                        <form method="post" id="file_config_form" class="form-horizontal" >
                            @csrf
                            <div class="col-md-4 form-group">
                                <label>{{__('Allowed Extensions')}} *</label>
                                <input type="text" name="allowed_extensions" id="allowed_extensions"  data-role="tagsinput" required class="form-control required"
                                     value="{{$file_config->allowed_extensions ?? 'allowed extensions'}}" >
                            </div>

                            <div class="col-md-4 form-group">
                                <label>{{__('Max file Size')}} (mb) *</label>
                                <input type="number" name="max_file_size" id="max_file_size"  max="20" min="1" required class="form-control required"
                                       value="{{$file_config->max_file_size ?? ''}}"
                                       placeholder="">
                            </div>


                            <div class="col-md-4 form-group">
                                <input type="submit" name="file_config_submit" id="file_config_submit" class="btn btn-success" value={{trans("file.Save")}}>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @endcan



    <script type="text/javascript" >

        $(document).ready(function() {



            $('#file_config_form').on('submit', function (event) {
                event.preventDefault();

                    $.ajax({
                        url: "{{ route('file_config.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                            }
                            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    })

            });
        });
    </script>




@endsection