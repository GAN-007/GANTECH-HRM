@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{{__('Add Training Type')}}</h3></div>
                <div class="card-body">
                    <form method="post" id="training_type_form" class="form-horizontal" >
                        @csrf
                        <div class="input-group">
                            <input type="text" name="type" id="type"  required class="form-control required"
                                   placeholder="{{__('Training Type')}}">
                            <input type="submit" name="training_type_submit" id="training_type_submit" class="btn btn-success" value={{trans("file.Save")}}>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <span class="training_result"></span>
        <div class="table-responsive">
            <table id="training_type-table" class="table ">
                <thead>
                <tr>
                    <th>{{__('Training Name')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>


        <div id="TrainingEditModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="TrainingModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                        <button type="button" data-dismiss="modal" id="training_close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>
                    <span class="training_result_edit"></span>

                    <div class="modal-body">
                        <form method="post" id="training_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                            @csrf
                            <div class="col-md-4 form-group">
                                <label>{{__('Training Type')}} *</label>
                                <input type="text" name="type_edit" id="type_edit" required class="form-control"
                                       placeholder="{{__('Training Type')}}">
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="hidden" name="hidden_training_id" id="hidden_training_id" />
                                <input type="submit" name="training_type_edit_submit" id="training_type_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                            </div>
                        </form>
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
        $(document).ready(function() {
            @include('training.training_type.training_type_js')
        });
    })(jQuery);
</script>
@endpush
