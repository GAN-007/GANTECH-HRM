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
	            <h1 class="text-center">PeoplePro SaaS  Auto Installer</h1>
	        </header>
            <hr>
            <div class="content text-center">
                <h6>Please <a href="http://codecanyon.net/licenses/standard" target="_blank">Click Here</a> to read the license agreement before installation:</h6>




                <br><br>
                <div class="text-left">
                    <p><strong>N.B: </strong>
                        We always recommend to our clients that they use a new database for running the SaaS application.
                        <br>
                        But if you want to run the SaaS application in your existing database then you have to remove all tables first of your current database otherwise you will get error.
                    </p>
                    <p> <strong>N.B: </strong> If you want to use your peoplepro existing database as a tenant after install then you have to follow the points given below -</p>
                    <ul>
                        <li>You have to backup your existing database according the instruction. Please read the <a href="https://peopleprohrmsaas.com/central-documentation#integratePeopleproDB" target="__blank">documentation</a> first.</li>
                        <li>You have to reassign the role-permissin for the employees</li>
                        <li>You have to backup your root <b>public</b> directory's data</li>
                    </ul>
                </div>
                <br>

                <a href="{{ route('saas-install-step-2') }}" class="btn btn-primary">Accept & Continue</a>
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
