<footer class="main-footer">
    <div class="container-fluid">
        <p>&copy; {{$general_settings->site_title ?? "no title"}} || {{ __('Developed by')}}
            <a href={{$general_settings->footer_link}} class="external">{{$general_settings->footer}}</a> || Version - {{env('VERSION')}}
    </div>
</footer>
