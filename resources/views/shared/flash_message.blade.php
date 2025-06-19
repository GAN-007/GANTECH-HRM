@if(session()->has('msg'))
    <div class="alert alert-{{session('type')}} alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>{!! session('msg') !!}</div>
@endif

