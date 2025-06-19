@php
    $general_settings = \App\Models\GeneralSetting::latest()->first();
@endphp

<html lang="en">
<head>
    @include('frontend.Layout.header')
</head>
<body class="d-flex flex-column h-100">
	@include('frontend.Layout.navigation')

	<div class="frontend">
	    @yield('content')
	</div>
	<footer class="footer mt-auto py-3 bg-dark text-center">
		<div class="container">
			<p class="mb-0 text-light">&copy; {{$general_settings->footer}} {{ date('Y')}}</p>
		</div>
	</footer>
</body>
</html>
