@extends('frontend.Layout.master')

@section('title_front','Job-Details')

@section('content')

<section class="jumbotron">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1 class="mb-0">{{$job_post->job_title}}</h1>
            <button class="btn btn-primary" id="apply_job">
                {{trans('file.Apply')}} <i class="dripicons-arrow-thin-right"></i>
            </button>
        </div>
    </div>
</section>
<div class="container">

    <!-- Recent Jobs -->
    <div class="row">
        <div class="col-md-7 mt-4">
            <div class="padding-right">
                <!-- Company Info -->
                <div class="job-info mt-4">
                    <p class="">{{$job_post->short_description}}</p>
                    <hr>
                    <h3>{{trans('file.Details')}}</h3>
                    {!! html_entity_decode($job_post->long_description) !!}
                </div>
            </div>
        </div>
        <!-- Widgets -->


        <!-- Widgets / End -->
        <div class="col-md-4 offset-md-1 mt-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">{{trans('file.Overview')}}</h3>
                    <h6 class="card-subtitle mt-2 text-muted">{{__('Job Title')}}</h6>
                    <p class="card-text">{{$job_post->job_title}}</p>
                    @if(!empty($job_post->Company->company_name))
                    <h6 class="card-subtitle mt-2 text-muted">{{__('Company')}}</h6>
                    <p class="card-text">{{$job_post->Company->company_name}}</p>
                    @endif
                    <h6 class="card-subtitle mt-2 text-muted">{{trans('file.Experience')}}</h6>
                    <p class="card-text">{{$job_post->min_experience}}</p>
                    <h6 class="card-subtitle mt-2 text-muted">{{trans('file.Vacancy')}}</h6>
                    <p class="card-text">{{$job_post->no_of_vacancy}}</p>
                    <h6 class="card-subtitle mt-2 text-muted">{{__('Apply Before')}}</h6>
                    <p class="card-text">{{$job_post->closing_date}}</p>
                    <h6 class="card-subtitle mt-2 text-muted">{{__('Posted')}}</h6>
                    <p class="card-text">{{$job_post->updated_at->diffForHumans()}}</p>
                </div>
            </div>
        </div>
    </div>

</div>


    <div id="applyModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Apply For This Job')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>

                <span id="form_result"></span>

                <form autocomplete="off" method="post" id="apply_form" class="form-horizontal mb-0" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 form-group">
                                    <label for="full_name">{{__('Full Name')}} *</label>
                                    <input type="text" name="full_name" id="full_name"  placeholder="{{__('Full Name')}}" required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="email">{{trans('file.Email')}} *</label>
                                <input type="email" name="email" id="email"  placeholder="{{trans('file.Email')}}" required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="email">{{trans('file.Phone')}} *</label>
                                <input type="text" name="phone" id="phone" placeholder="{{trans('file.Phone')}}" required class="form-control">
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="email">{{trans('file.Address')}} </label>
                                <textarea name="address" id="address" placeholder="{{trans('file.Address')}}" class="form-control" cols="30" rows="3"></textarea>
                                {{-- <input type="text" name="address" id="address" placeholder="{{trans('file.Address')}}" class="form-control"> --}}
                            </div>


                            <div class="col-md-12 form-group">

                                <label for="cover_letter">{{__('Cover Letter/Message')}}</label>
                                <textarea class="form-control" required id="cover_letter" name="cover_letter"
                                          rows="3"></textarea>

                            </div>



                            <div class="col-md-6 form-group">

                                <label for="fb_id">{{__('Facebook Profile')}} ({{trans('file.Optional')}})</label>
                                <input type="text" name="fb_id" id="fb_id"  placeholder="{{__('Facebook Profile')}}"
                                         class="form-control">

                            </div>

                            <div class="col-md-6 form-group">

                                <label for="linkedin_id">{{__('Linkedin Profile')}} ({{trans('file.Optional')}})</label>
                                <input type="type" name="linkedin_id" id="linkedin_id"  placeholder="{{__('Linkedin Profile')}}"
                                         class="form-control">

                            </div>

                            <div class="col-md-12 form-group">

                                <label for="cv">{{__('Upload your cv')}} </label>
                                <input type="file" name="cv" id="cv" class="form-control" accept="image/*,.pdf,.doc,.docs">

                            </div>

                        </div>

                    </div>
                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning btn-block btn-lg" value="{{trans('file.Apply')}}"/>
                </form>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        (function($) {
            "use strict";

            $(document).ready(function () {

                $('#apply_job').on('click', function () {

                    $('#applyModal').modal('show');
                });

                $('#apply_form').on('submit', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: "{{ route('jobs.apply',$job_post->id )}}",
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
                                $('#apply_form')[0].reset();

                            }
                            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    });

                });

            });


            tinymce.init({
                selector: '#cover_letter',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                },
                height: 130,

                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                /*
                  URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                  images_upload_url: 'postAcceptor.php',
                  here we add custom filepicker only to Image dialog
                */
                file_picker_types: 'image',
                /* and here's our custom image picker*/
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    /*
                      Note: In modern browsers input[type="file"] is functional without
                      even adding it to the DOM, but that might not be the case in some older
                      or quirky browsers like IE, so you might want to add it to the DOM
                      just in case, and visually hide it. And do not forget do remove it
                      once you do not need it anymore.
                    */

                    input.onchange = function () {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function () {
                            /*
                              Note: Now we need to register the blob in TinyMCEs image blob
                              registry. In the next release this part hopefully won't be
                              necessary, as we are looking to handle it internally.
                            */
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code wordcount'
                ],
                toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
                branding: false
            });
        })(jQuery);

    </script>

@endsection
