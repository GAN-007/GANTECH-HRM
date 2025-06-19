<!DOCTYPE html>
<html lang="en">
<head>
    <title>PeoplePro Installer | Step-1</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('install-assets/images/favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('install-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('install-assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('install-assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="col-md-6 offset-md-3">
		<div class="wrapper">
	        <header>
	            <img src="{{ asset('install-assets/images/logo.png') }}" alt="Logo"/>
	            <h1 class="text-center">PeoplePro Biometric Attendance Auto Installer</h1>
	        </header>
            <hr>
            <div class="content text-center">
                <h6>Please <a href="http://codecanyon.net/licenses/standard" target="_blank">Click Here</a> to read the license agreement before installation:</h6>


                <a href="{{ route('biometric-install-step-2') }}" class="btn btn-primary">Accept & Continue</a>
                <hr class="mt-lg-5">
                <h6>If you need any help with installation, Please contact
                     <a href="mailto:support@lion-coders.com">support@lion-coders.com</a></h6>
                <p class="text-center"><strong>$15 charge applicable</strong></p>
            </div>
            <hr>
            <footer>Copyright &copy; lionCoders. All Rights Reserved.</footer>
		</div>
	</div>
</body>
</html>
