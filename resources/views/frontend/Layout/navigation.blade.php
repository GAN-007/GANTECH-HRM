
<nav class="bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center pt-2 pb-2">
            <div>
                <div class="navbar-brand">@if($general_settings->site_logo ?? "no")<img src="{{asset('/images/logo/'.$general_settings->site_logo)}}" width="50">&nbsp; &nbsp;@endif{{$general_settings->site_title ?? "PeoplePro"}}</div>
            </div>

            <div class="collapse navbar-collapse show" id="navbarTogglerDemo03">
                <nav class="my-2 my-md-0 mr-md-3 text-right">
                    <a class="p-2 text-dark" href="{{route('home.front')}}">{{trans('file.Home')}}</a>
                    <a class="p-2 text-dark" href="{{route('jobs')}}">{{trans('file.Jobs')}}</a>
                    <a class="p-2 text-dark" href="{{route('about.front')}}">{{trans('file.About')}}</a>
                    <a class="p-2 text-dark" href="{{route('contact.front')}}">{{trans('file.Contact')}}</a>
                </nav>
            </div>
        </div>
    </div>
</nav>

