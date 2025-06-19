<!doctype html>
<!--[if IE 6 ]><html lang="en-us" class="ie6"> <![endif]-->
<!--[if IE 7 ]><html lang="en-us" class="ie7"> <![endif]-->
<!--[if IE 8 ]><html lang="en-us" class="ie8"> <![endif]-->
<!--[if (gt IE 7)|!(IE)]><!-->
<!--<![endif]-->

<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title>
        {{ $general_settings->site_title ?? null}}
    </title>

    <meta name="description" content="PeoplePro offers a comprehensive HR & payroll solution to manage all of your business HR needs which can also be customized according to your requirements." />
    <meta name="author" content="LionCoders">
    <meta name="copyright" content="LionCoders">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700">
    <link rel="stylesheet" href="{{ asset('docs/assets/css/documenter_style.css')}}" media="all">
    <link rel="stylesheet" href="{{ asset('docs/assets/css/jquery.mCustomScrollbar.css')}}" media="all">

    <script src="{{ asset('docs/assets/js/jquery.js')}}"></script>
    <script src="{{ asset('docs/assets/js/jquery.mCustomScrollbar.js')}}"></script>
    <script src="{{ asset('docs/assets/js/smooth-scroll.min.js')}}"></script>
    <script src="{{ asset('docs/assets/js/typeAhead.js')}}"></script>
    <script src="{{ asset('docs/assets/js/script.js')}}"></script>
</head>

<body>
<div id="documenter_sidebar">
    @if($general_settings->site_logo)
        <img src="{{asset('/images/logo/'.$general_settings->site_logo)}}" style="border: none;margin: 0 0 0 0; " >
        &nbsp; &nbsp;
    @endif
    {{-- <h1 style="display: inline;margin-top: -10px"> {{ $general_settings->site_title }} </h1> --}}

    <ul id="documenter_nav">
        <li><a class="current" href="#documenter_cover">Start</a></li>
        <li><a href="#server_requirement" title="SERVER REQUIREMENTS">Server Requirements</a></li>
        <li><a href="#install" title="INSTALL">Install</a></li>
        <li><a href="#common_error" title="Common Error">Common Error</a></li>
        <li><a href="#software_update" title="SOFTWARE UPDATE">Software Update</a></li>
        <li><a href="#log_in" title="Log In">Log In</a></li>
        <li><a href="#admin_dashboard" title="Admin DASHBOARD">Admin Dashboard</a></li>
        <li><a href="#empty_database" title="Empty Database">Empty Database</a></li>
        <li><a href="#datatable_options" title="Datatable Options">Datatable Options</a></li>
        <li><a href="#location" title="Location">Location</a></li>
        <li><a href="#company" title="Company">Company</a></li>
        <li><a href="#department" title="Department">Department</a></li>
        <li><a href="#designation" title="Designation">Designation</a></li>
        <li><a href="#office_shift" title="Office Shift">Office Shift</a></li>
        <li><a href="#account_list" title="Account List">Account List</a></li>
        <li><a href="#roles_access" title="Role & Access">Role & Access</a></li>
        <li><a href="#designation" title="Designation">Designation</a></li>
        <li><a href="#general_setting" title="General Setting">General Setting</a></li>
        <li><a href="#mail_server" title="SETUP MAIL SERVER">Setup Mail Server</a></li>
        <li><a href="#language_setting" title="Language Setting">Language Setting</a></li>
        <li><a href="#variable_type" title="Variable Type">Variable Type</a></li>
        <li><a href="#variable_method" title="Variable Method">Variable Method</a></li>
        <li><a href="#ip_setting" title="IP Settings">IP Settings</a></li> <!-- New-->
        <li><a href="#employee_list" title="Employee List">Employee List</a></li>
        <li><a href="#import_employee" title="Import Employee">Import Employee</a></li>
        <li><a href="#user_list" title="User List">User List</a></li>
        <li><a href="#assign_role" title="User Role and Access">User Role and Access</a></li>
        <li><a href="#user_last_login" title="User Last Login">User Last Login</a></li>
        <li><a href="#promotion" title="Location">Location</a></li>
        <li><a href="#award" title="Award">Award</a></li>
        <li><a href="#travel" title="Travel">Travel</a></li>
        <li><a href="#transfer" title="Transfer">Transfer</a></li>
        <li><a href="#resignation" title="Resignation">Resignation</a></li>
        <li><a href="#complaint" title="Complaint">Complaint</a></li>
        <li><a href="#warning" title="Warning">Warning</a></li>
        <li><a href="#termination" title="Termination">Termination</a></li>
        <li><a href="#announcement" title="Announcement">Announcement</a></li>
        <li><a href="#policy" title="Company Policy">Company Policy</a></li>
        <li><a href="#attendance" title="Attendance">Attendance</a></li>
        <li><a href="#datewise_attendance" title="Datewise Attendance">Datewise Attendance</a></li>
        <li><a href="#monthly_attendance" title="Monthly Attendance">Monthly Attendance</a></li>
        <li><a href="#update_attendance" title="Update Attendance">Update Attendance</a></li>
        <li><a href="#import_attendance" title="Import Attendance">Import Attendance</a></li>
        <li><a href="#manage_holiday" title="Manage Holiday">Manage Holiday</a></li>
        <li><a href="#manage_leave" title="Manage Leave">Manage Leave</a></li>
        <li><a href="#payslip_report" title="Payslip Report">Payslip Report</a></li>
        <li><a href="#attendance_report" title="Attendance Report">Attendance Report</a></li>
        <li><a href="#training_report" title="Training Report">Training Report</a></li>
        <li><a href="#project_report" title="Project Report">Project Report</a></li>
        <li><a href="#task_report" title="Task Report">Task Report</a></li>
        <li><a href="#employee_report" title="Employee Report">Employee Report</a></li>
        <li><a href="#account_report" title="Account Report">Account Report</a></li>
        <li><a href="#expense_report" title="Expense Report">Expense Report</a></li>
        <li><a href="#deposit_report" title="Deposit Report">Deposit Report</a></li>
        <li><a href="#transaction_report" title="Transaction Report">Transaction Report</a></li>
        <li><a href="#job_post" title="Job Post">Job Post</a></li>
        <li><a href="#job_candidate" title="Job Candidate">Job Candidate</a></li>
        <li><a href="#job_interview" title="Job Interview">Job Interview</a></li>
        <li><a href="#cms" title="CMS">CMS</a></li>
        <li><a href="#new_payment" title="New Payment">New Payment</a></li>
        <li><a href="#payment_history" title="payslip History">Payslip History</a></li>

        <!-- Performance -->
        <li><a href="#goal_type" title="Goal Type">Goal Type</a></li>
        <li><a href="#goal_tracking" title="Goal Tracking">Goal Tracking</a></li>
        <li><a href="#indicator" title="Indicator">Indicator</a></li>
        <li><a href="#appraisal" title="Appraisal">Appraisal</a></li>
        <!--/ Performance -->



        <li><a href="#hr_calendar" title="HR Calendar">HR Calendar</a></li>
        <li><a href="#event" title="Event">Event</a></li>
        <li><a href="#meeting" title="Meeting">Meeting</a></li>
        <li><a href="#client" title="Client">Client</a></li>

        <li><a href="#tax_type" title="Tax Type">Tax Type</a></li>
        <li><a href="#project" title="Project">Project</a></li>
        <li><a href="#task" title="Task">Task</a></li>
        <li><a href="#invoice" title="Invoice">Invoice</a></li>
        <li><a href="#support_ticket" title="Support Ticket">Support Ticket</a></li>
        <li><a href="#account_balance" title="Account Balance">Account Balance</a></li>
        <li><a href="#payee" title="payee">Payee</a></li>
        <li><a href="#payer" title="payer">Payer</a></li>
        <li><a href="#deposit" title="Deposit">Deposit</a></li>
        <li><a href="#Expense" title="expense">Expense</a></li>
        <li><a href="#transaction" title="Transaction">Transaction</a></li>
        <li><a href="#transfer" title="Transfer">Transfer</a></li>
        <li><a href="#asset_category" title="Asset Category">Asset Category</a></li>
        <li><a href="#asset" title="Asset">Asset</a></li>

        <li><a href="#file_configuration" title="File Configuration">File Configuration</a></li>
        <li><a href="#file_manager" title="File Manage">File Manager</a></li>
        <li><a href="#official_document" title="Official Document">Official Document</a></li>

        <li><a href="#client_dashboard" title="Client Dashboard">Client Dashboard</a></li>
        <li><a href="#client_project" title="Client Project">Client Project</a></li>
        <li><a href="#client_task" title="Client Task">Client Task</a></li>
        <li><a href="#client_invoice" title="Client Invoice">Client Invoice</a></li>
        <li><a href="#client_invoice_paid" title="Client Invoice Paid">Client Invoice Paid</a></li>
        <li><a href="#employee_dashboard" title="Employee Dashboard">Employee Dashboard</a></li>
        <li><a href="#general_error" title="General Error">General Error</a></li>
        <li><a href="#video_tutorial" title="Video Tutorial">Video Tutorial</a></li>
        <li><a id="attendanceDeviceAddon" title="Attendance Device Addon">Attendance Device Addon</a></li>
        <li><a href="#autoUpdateFeature" title="Auto Update Feature">Auto Update Feature</a></li>
        <li><a href="#support" title="SUPPORT">Support</a></li>
    </ul>
</div>

<div id="documenter_content">
    <div id="the-basics">
        <input class="typeahead form-control" type="text" placeholder="Search">
    </div>

    <section id="documenter_cover">
        <h1>PeoplePro- HR Management System with payroll, finance, attendance, project management and many more
        </h1>
        <div id="documenter_buttons">
        </div>
        <hr>
        <ul>
            <li>by : LionCoders</li>
            <li>Support : <a href="https://lion-coders.com/support">lion-coders.com/support</a></li>
        </ul>
        <p> PeoplePro is a software that will you to manage the people in your company or organization in a
            effective way that can assure a competitieve advantage in your buisness. The system is designed in such
            a
            way that can maximize employee performnace . We believe that this software is suitable for managing the
            people within a workplace to achieve the organization’s mission and reinforce the culture.This user
            friendly
            software is fully responsive and has many features. Hopefully this software will be ul to manage
            your
            workplace to functionate to it's full potential.</p>
        <p>
            The docs is written in a chronological order . There are some dependencies that need to be
            maintained
            properly in a sequential order . Please try to follow that . You can also seach using the search bar for
            a specific
            query.
        </p>
    </section>

    <section id="server_requirement">
        <div class="page-header">
            <h3>SERVER REQUIREMENT</h3>
            <hr class="notop">
        </div>
        <p>
            The software is built on most popular PHP framework Laravel (Version-10). The minimum
            requirements for running the software is listed below .Please do check if your server matches those
            requirements</p>
        <ul>
            <li>PHP = 8.1.0</li>
            <li>BCMath PHP Extension</li>
            <li>Ctype PHP Extension</li>
            <li>Fileinfo PHP Extension</li>
            <li>JSON PHP Extension</li>
            <li>Mbstring PHP Extension</li>
            <li>OpenSSL PHP Extension</li>
            <li>PDO PHP Extension</li>
            <li>Tokenizer PHP Extension</li>
            <li>XML PHP Extension</li>
        </ul>
        <p>
            &nbsp;</p>
        <p>
            <strong>Please note if you try to install the application on any other server say LiteSpeed or IIS, you
                may get undesirable result. We do not recommend you to use other server than Apache or Nginx. Also
                we do not provide support for installation in server other than Apache. Please follow the installation process,
            below. Do not use php artisan serve command. And lastly we don't provide support in the localhost (except online server).
            If you need local machine support, you have to pay extra $50.</strong></p>
    </section>

    <section id="install">
        <div class="page-header">
            <h3>INSTALL</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Localhost</strong><br>
            If you are installing on localhost, please keep in mind that you’ll need Internet for installation. After installation, you can use PeoplePro without Internet.
            We suggest you use XAMPP for localhost. You can use other solutions like WAMP, MAMP etc. as well and installation process for all of them are same. Create a folder inside htdocs folder inside your XAMPP installation. Now copy the zip folder you downloaded from Codecanyon to htdocs folder and unzip it there. Rename it to whatever you want. Say, you have named it- ‘my-folder’.
            Now start your XAMPP (or whatever you are using) and go to your browser and access PeoplePro from your browser like- localhost/my-folder/.
        </p>
        <p>
            <strong>Online Hosting</strong><br>
        Upload the zip folder you downloaded from Codecanyon to your hosting and unzip it. Please make sure you configure your web hosting’s settings, so that it shows hidden files and folders. This is to ensure that if you copy/move the contents from the unzipped folder to any other location, you copy all the files including ‘.htaccess’, ‘.env’ files which are necessary for the proper functioning of the software.
        Now you can access the folder where you have PeoplePro from your browser.
        </p>
        <p>
            Now follow the installation process below.
        </p>


        <h2><strong>Step 1</strong></h2>
        <ul>
            <li>
                Please read the license arrangement before proceeding.
            </li>

            <li> You need to accept and continue for going to
                the next step.
            </li>
            <img alt="" src="{{ asset('docs/assets/images/step1.png')}}">
        </ul>
        <h2><strong>Step 2</strong></h2>
        <ul>
            <li>
                The system will automatically check for the server requirements. If all the requirements are
                fulfilled,
                You can proceed for further action.
            </li>
            <img alt="" src="{{ asset('docs/assets/images/step2.png')}}">
        </ul>
        <h2><strong>Step 3</strong></h2>
        <ul>
            <li>
                You have to fill up the form with correct information.
            </li>
            <li>Please input the purchase code.
            </li>
            <li>
                Input your database host e.g(localhost).
            </li>
            <li>
                Your database username e.g(root).
            </li>
            <li>your
                database password (if any).
            </li>
            <li>
                The database name that you have already created.
            </li>
            <li>
                Click on submit.
            </li>
            The system wil automatically import the database. This is a
            batch process,please wait patiently while the action is processing.
            </li>
            <img alt="" src="{{ asset('docs/assets/images/step3.png')}}">
            <img alt="" src="{{ asset('docs/assets/images/step3_1.png')}}">
        </ul>
        <h2><strong>Step 4</strong></h2>
        <ul>
            <li>
                Congratulations! You have successfully installed PeoplePro.<br>
                <strong>Note :</strong> your project folder contains 'install' folder, then please delete
                the folder.
            </li>
            <img alt="" src="{{ asset('docs/assets/images/step4.png')}}">
        </ul>

        <h2><strong>Help with installation</strong></h2>
        <p>
            We can help you install on any cpanel based hosting for as little as $15. You can send the money via paypal to tarik_17@yahoo.co.uk. Contact us at support@lion-coders.com with you hosting details and payment proof and we'll take care of the rest.
        </p>
        <p>
            <b>Please note -</b> If you are installing on localhost, we'll charge $50 for anydesk/teamviewer support(installation).
        </p>

        <br><br>

        <h2><strong>Error</strong></h2>
        <ul>
            <li>
                If you face a "Fatal error: Maximum execution time of ** seconds exceeded",
                Do not worry, the software is installed properly.<br>
                <strong>Note :</strong> After installtion, please go to asset folder from root directory and then check a 'install' folder still exits or not, if exists then delete it.
            </li>
        </ul>

        <p>After successful installation you can login with <br>
            username:<strong>admin</strong><br>
            password:<strong>admin</strong></p>
        <br>
    </section>

    <section id="common_error">
        <div class="page-header">
            <h3>Common Errors</h3>
            <hr class="notop">
        </div>
        <p>
            If you face 500 server error after installing the software please update your php version to 7.4 or later. If you still get 500 error after updating php version, please open your '.env' file and change the value of 'APP_DEBUG' to true. You'll find '.env' file in the root folder (salepro) And then go to the page again where you were getting 500 server error. You should see description of actual error now. Please take a screenshot and send it over along with your cpanel access details, so that we can look into it.
        </p>
        <img alt="" src="{{ asset('docs/assets/images/env.png')}}">
        <img alt="" src="{{ asset('docs/assets/images/app_debug_true.png')}}">
    </section>

    <section id="software_update">
        <div class="page-header">
            <h3>SOFTWARE UPDATE</h3>
            <hr class="notop">
        </div>
        <h2><strong>UPDATE with Existing Data</strong></h2>
        <p>You can update the software very easily by following 4 steps:</p>
        <ul>
            <li>Rename your previous database like peoplepro-backup.sql.</li>
            <li>Delete the project folder and reinstall it</li>
            <li>Merge your present database with previous one with
                <a href="https://www.red-gate.com/products/mysql/mysql-compare/index">MySQL Compare</a>. If you are
                // a linux user you can use <a href="https://www.navicat.com/en/">Navicat</a> to merge database.
            </li>
            <li>After that delete the new database and rename the previous one with present database name like
                peoplepro-backup.sql to peoplepro.sql.
            </li>
        </ul>
        <p><strong>Please follow the following spanshots carefully to merge database:</strong></p>
        <p>Open the software.</p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update1.png')}}">
        </p>
        <p>Select your source and target database and click compare now.</p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update2.png')}}">
        </p>
        <p>After comparing successfully two database click ok.</p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update3.png')}}">
        </p>
        <p>Then select the checkbox and click Deployment Wizard.</p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update4.png')}}">
        </p>
        <p>Uncheck the Recompare after deployment checkbox and click next.</p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update5.png')}}">
        </p>
        <p>Click Deploy now.</p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update6.png')}}">
        </p>
        <p>Click Ok.</p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update7.png')}}">
        </p>
        <p>Thats all! You have just updated the database. Now follow step 4 as we described earlier.</p>
        <h2><strong>UPDATE without Existing Data</strong></h2>
        <p>You can update the software very easily by following 2 steps:</p>
        <ul>
            <li>Delete your previous database.</li>
            <li>Delete the project folder and reinstall it</li>
        </ul>
        <p><strong>Still facing problem? Don't worry! We can update your software for USD 15. Please contact us at
            <a href="mailto:support@lion-coders.com">support@lion-coders.com</a>.</strong></p>
    </section>

    <section id="log_in">
        <div class="page-header">
            <h3>Log In</h3>
            <hr class="notop">
        </div>
        <p>
            After installation go to the project/root url.Then you will be prompt to login.
            The login credentials provided below are for initial usage only - do not forget
            to update your password after first successful login.

        <ul>
            <li>Username ::: admin</li>
            <li>Password ::: admin</li>
        </ul>

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/login.png')}}">
        </p>
        <p>
            After successful login you will be redirected to the admin dashboard.
        </p>
    </section>

    <section id="admin_dashboard">
        <div class="page-header">
            <h3>Admin DASHBOARD</h3>
            <hr class="notop">
        </div>
        <p>
            The system offers an informative,interactive and user friendly admin dashboard.
            The dashboard shows summarized information about the organization in a nutshell.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/dashboard1.png')}}">
        </p>

        <ol>
            <li>This is the logo of your site.You can update/change it from <strong>General Settings</strong> under
                <strong>Customize Settings</strong></li>
            <li>This is the name of your organization.You can update/change it from <strong>General
                Settings</strong> under <strong>Customize Settings</strong></li>
            <li>View the software in full screen mode</li>
            <li>Notifications</li>
        </ol>

        <ul>
            <li><strong>Lanuage :</strong>Change Locale/Language</li>
            <li><strong>Employees :</strong>Total Active employees in your company/organization</li>
            <li><strong>Attendance :</strong>Number of present and ansent employee</li>
            <li><strong>Total Leave :</strong>Total active Leave</li>
            <li><strong>Total Expense :</strong>Total Expense till date of the organization</li>
            <li><strong>Total Deposit :</strong>Total Deposit till date of the organization</li>
            <li><strong>Total Salaries Paid :</strong>Total salaries paid till date</li>
        </ul>


        <p><strong>Payment-last six month</strong><br>
            This is graph will show you the amount of money that has been spent as a payment to the employees for
            the last
            six month.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payslip_last_six.png')}}">
        </p>
        <p>
            <strong>Employee Department</strong><br>
            The doughnut chart will give you a visual information about the employee and their departments.
            You can hover over the doughnut chart for more details.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_department.png')}}">
        </p>
        <p>
            <strong>Employee Designation</strong><br>
            This pie chart will give you a visual information about the employee and their designations.
            You can hover over the pie chart for more details.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_designation.png')}}">
        </p>
        <p>
            <strong>Expense Vs Deposit</strong><br>
            This is the expense vs deposit pie chart. You can have a quick idea about the total expense vs total
            deposit at a glance.
            For more information hover over the pie chart.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/expense_deposit.png')}}">
        </p>
        <p>
            <strong>Project Status</strong><br>
            The doughnut chart will give you a visual information about the project status of your organization.
            You can hover over the doughnut chart for more details.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/project_status.png')}}">
        </p>

        <p>
            <strong>Announcement</strong><br>
            This section will show the latest published announcements.
        </p>
        <p>
            <strong>Open Ticket</strong><br>
            This section will show information about the tickets that are open.
        </p>

        <p>
            <strong>Completed Project</strong><br>
            The projects that has been Completed will be shown here.
        </p>
        <p>
            All of them are clickable.
            <img alt="" src="{{ asset('docs/assets/images/announcement_ticket_project.png')}}">
        </p>

        <p>
            <strong>Calendar</strong><br>
            The Calendar will display all the events in a calendar view. Admin can also add a new event from the
            options (1). <br>
            The events are clickable . You can click on a event to view details.
            If you set your meeting status <b>Ongoing</b>, then it will display in Calender.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/calendar.png')}}">
        </p>

    </section>

    <section id="empty_database">
        <div class="page-header">
            <h3>Empty Database</h3>
            <hr class="notop">
        </div>
        <p>
            After first time login you may want to delete the preloaded data. For that, click on (1), then click on
            empty database. All the
            preloaded data will be deleted from the database except few mandatory record that is essential for
            running the software properly.<br>
            <strong>Note:</strong> This is a batch process, so the action will take some time. Please wait
            patiently.
            <strong>***</strong> This action is irreversible, if you have your own data/record in the database, this
            action will delete all of them.
            This action is recommended only for the first time, unless you are sure about what you are doing.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/empty_database1.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/empty_database2.png')}}">
        </p>
    </section>

    <section id="datatable_options">
        <div class="page-header">
            <h3>Datatable Options</h3>
            <hr class="notop">
        </div>
        <p>
            DataTables is a table enhancing plug-in that offers sorting, paging and filtering
            abilities . In this software, datatable is used as a toll for showing data. <br>
            Here are some of the features and usage for datatable :::
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/datatable1.png')}}">
        </p>
        <ol>
            <li>you can select how many records to be shown in a single page (10,25 or all).Default is 10</li>
            <li><strong>Selector:</strong> You can select all the records/rows and perform action like print to
                pdf/csv/print or delete multiple rows
            </li>
            <li><strong>Search:</strong> Search the records/rows using keywords</li>
            <li><strong>Sorting:</strong> Sort columns</li>
        </ol>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/datatable2.png')}}">
        </p>
        <ol>
            <li>You can export the records to a pdf using this button</li>
            <li>You can export the records to a csv using this button</li>
            <li>You can print the records using this button</li>
            <li>You can hide/show specific columns using this button</li>
            <li>View details of a specific record</li>
            <li>Edit/Update a specific record</li>
            <li>Delete a specific record</li>
        </ol>
    </section>

    <section id="location">
        <div class="page-header">
            <h3>Location</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Organization</strong> -> <strong>Location</strong>.<br>
            PeoplePro provides an easy to use location module system, where administrator can add multiple
            locations, and
            under one location administrator can add companies.Later on, Administrator can edit /
            update or delete any location information.

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/location1.png')}}">
        </p>
    </section>

    <section id="company">
        <div class="page-header">
            <h3>Company</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Organization</strong> -> <strong>Company</strong>.<br>
            Administrator can add multiple companies, and under a company different departments can be
            added.Administrator can edit /
            update or delete any company information.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/company1.png')}}">
        </p>
    </section>

    <section id="department">
        <div class="page-header">
            <h3>Department</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Organization</strong> -> <strong>Department</strong>.<br>
            Multiple departments can be added under a company.Administrator can edit /
            update or delete any department information.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/department1.png')}}">
        </p>
    </section>

    <section id="designation">
        <div class="page-header">
            <h3>Designation</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Organization</strong> -> <strong>Designation</strong>.<br>
            Multiple designation can be added under a company's department.Administrator can edit /
            update or delete any designation information.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/designation1.png')}}">
        </p>
    </section>

    <section id="office_shift">
        <div class="page-header">
            <h3>Office Shift</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Timesheets</strong> -> <strong>Office Shift</strong>.<br>
            The list of office shift/shifts of a company.You can assign one or multiple office shifts and
            office timing under this module.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/office_shift.png')}}">
        </p>
        <p>
            <strong>Add Office Shift</strong><br>
            <img alt="" src="{{ asset('docs/assets/images/office_shift_add.png')}}">
        </p>
    </section>

    <section id="account_list">
        <div class="page-header">
            <h3>Account List</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Account List</strong>.<br>
            You can view/add/edit/delete account details using this module .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/account_list.png')}}">
        </p>
        <p>
            <strong>Add Account</strong><br>
            You can add account details using this module .
            <strong>This is mandatory for using payroll and finance module.</strong>
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/add_account.png')}}">
        </p>
    </section>

    <section id="roles_access">
        <div class="page-header">
            <h3>Roles & Access</h3>
            <hr class="notop">
        </div>
        <p>
            To add/manage role and their associate permissions you have to go to <strong>Roles and Access</strong>
            under <strong>Customize Setting</strong> module.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/roles_access.png')}}">
        </p>
        <p>
            <strong>Add Role(1)</strong><br>
            To add a new role for example like manager,editor etc. Then under this role you can set specific
            permissions that the role can access .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/add_role.png')}}">
        </p>
        <p>
            <strong>Permission(2)</strong><br>
            Set up permissions for the selected role.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/permission.png')}}">
        </p>
        <p>
            <strong>Assign Role</strong><br>
            Assigning role to a user .By default, admin can access everything.If you want to limit specific user
            some
            resources or permissions you can add new role and assign that role to that particular user.<br>
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/assign_role1.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/assign_role2.png')}}">
        </p>

        <ol>
            <li><strong>Role :</strong>Go Back To Role Page</li>
            <li><strong>Assign Role :</strong>Assign Role to a user</li>
        </ol>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/assign_role.png')}}">
        </p>

        <p>
            Select multiple user using checkbox and then assign a role to them.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/multi_assign.png')}}">
        </p>


    </section>

    <section id="general_setting">
        <div class="page-header">
            <h3>General Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Customize Setting</strong> -> <strong>General Setting</strong>.<br>
            You can set App site title, site logo, currency, currency Format, timezone , date format and default
            Bank
            that will be used thoroughout the app.The changes will reflect immediately.<br>
            <strong>Selecting a default bank is mandatory.You can add bank from <strong>Finance </strong> ->
                <strong>Account List</strong>
            </strong>
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/general_setting.png')}}">
        </p>
    </section>

    <section id="mail_server">
        <div class="page-header">
            <h3>SETUP MAIL SERVER</h3>
            <hr class="notop">
        </div>
        <p>
            To add mail functionality you have to setup mail server first. To do this go to
            <strong>Mail Setting</strong> under <strong>Setting</strong> module. You have to fill up the following
            information.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/mail1.png')}}">
        </p>

        <h3>SETUP cron job </h3>
        <hr class="notop">
        <p>
            You must set up a cron job setting on your server in order to get certain mail notification
            like document expiry remainder and many more. Please follow the below steps to do so :
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/cron_job1.jpg')}}">
        </p>
        <p>On your hosting c-panel go to the advance section and click on the cron jobs.
        </p>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/cron_job2.jpg')}}">
        </p>
        <p>
            Then under common settings section select the option of- Once Per Minute
            then on command field set the path. It should be something like this : <br>
            /usr/local/bin/php /home/your_project_folder/html/artisan schedule:run <br>
            Then click on add new cron job. <br>
            That's all.
        </p>
        <strong>Note :</strong>If you face any issues while setting up cron jobs,please contact support.

    </section>

    <section id="language_setting">
        <div class="page-header">
            <h3>Language Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Customize Setting</strong> -> <strong>Language Setting</strong>.<br>
            Our system offers an extensive way of customizing your app with language or locale setting.You can
            easily
            customize/change any word or phrase the way you want your user to see . Moreover you can add a new
            language
            and then can create word or phrase of that language .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/language_setting.png')}}">
        </p>
        <ul>
            <li><strong>Add (2)::</strong>You can add a new language<br>
                You have to fill the language name and language short key to add the new language.
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/language_add.png')}}">
                </p>
            </li>
            <li><strong>Language Selector (3)::</strong>You can select the language that you want to change/update
                from the dropdown<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/language_select.png')}}">
                </p>
            </li>

        </ul>
    </section>

    <section id="variable_type">
        <div class="page-header">
            <h3>Variable Type</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Customize Setting</strong> -> <strong>Variable Type</strong>.<br>
            Here you have to add different variable type that will be needed when adding new records.For example,In
            order to
            add leave record for an employee leave type is needed.You have to create the leave type first.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/variable_type.png')}}">
        </p>
        <ul>
            <li><strong>Leave Type :</strong>You can add/update new leave type<br>
                You have to fill the leave name and allocated day/s for that leave per year.
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/leave_type.png')}}">
                </p>
            </li>
            <li><strong>Award Type :</strong>You can add/update award type for rewarding an employee.<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/award_type.png')}}">
                </p>
            </li>
            <li><strong>Warning Type :</strong>You can add/update warning type.<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/warning_type.png')}}">
                </p>
            </li>
            <li><strong>Termination Type :</strong>You can add/update termination type here.<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/termination_type.png')}}">
                </p>
            </li>
            <li><strong>Termination Type :</strong>You can add/update termination type here.<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/termination_type.png')}}">
                </p>
            </li>
            <li><strong>Expense Type :</strong>You can add/update expense type here that will be needed for
                <strong>Finance</strong>-><strong>Expense</strong><br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/expense_type.png')}}">
                </p>
            </li>
            <li><strong>Emplyee Status :</strong>You can add/update employee status here<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/employee_status.png')}}">
                </p>
            </li>
            <li><strong>Document Type :</strong>Different types of document can be added/updated here . This is
                necessary for adding/updating document record<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/document_type.png')}}">
                </p>
            </li>
        </ul>
    </section>

    <section id="variable_method">
        <div class="page-header">
            <h3>Variable Method</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Customize Setting</strong> -> <strong>Variable Method</strong>.<br>
            Here you have to add different variable that will be needed when adding new records for some module.For
            example,In order to
            add job post record job category is needed.You have to create the job category first before adding a job
            post record.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/variable_method.png')}}">
        </p>
        <ul>
            <li><strong>Arrangement Method :</strong>You can add/update new arrangement method. In order to add
                travel record arrangement record is required<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/arrangement_method.png')}}">
                </p>
            </li>
            <li><strong>Payment Type :</strong>You can add/update payment method with their associated payment
                percentage and account number here.<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/payment_type.png')}}">
                </p>
            </li>
            <li><strong>Qualification :</strong>You can add/update different types qualification of an employee,e.g.
                education levels, language skills, other skills <br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/qualification.png')}}">
                </p>
            </li>
            <li><strong>Job Category :</strong>Different types of job category for job post record can added/updated
                here.<br>
                <p>
                    <img alt="" src="{{ asset('docs/assets/images/job_category.png')}}">
                </p>
            </li>

        </ul>
    </section>

    <!-- New  -->
    <section id="ip_setting">
        <div class="page-header">
            <h3>IP Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Customize Setting</strong> -> <strong>IP Setting</strong>.<br>
            Here you can set your IP address so that employee's attendance (Clock-IN and Clock Out) can control by IP based. At first you have to conncet with internet.
            Then search the word "What is my IP" in Google. You will see the IP address for the internet network you're currently connected to. Copy that and store in your software.
            Multiple Ip address of multiple router/Wi-Fi network can be stored.
            If any employee is connect with these IP, then he can give the attendance by Clock-IN and Clock Out.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/what_is_my_ip.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/ip_setting.png')}}">
        </p>
    </section>

    <section id="employee_list">
        <div class="page-header">
            <h3>Employee List</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Employees</strong> -> <strong>Employee List(1)</strong>.<br>
            You can view all the employees(active/inactive) and their related information here . You can also view
            their detailed information
            on the details page and update if needed.
        </p>
        <p>
            <!-- <img alt="" src="{{ asset('docs/assets/images/employee_list1.png')}}"> -->
            <img alt="" src="{{ asset('docs/assets/images/employee_list.png')}}">
        </p>

        <p>
            <strong>Add Employee(2)</strong>.<br>
            If you add an employee,he/she is automatically be added as an user and can log in using
            the username and password.Role can be selected while adding an employee.If an employee is selected
            as an admin s/he is given the permission to access all the resources of the software.If set otherwise,
            permissions can be manually set on Customize Setting -> Roles and Access Page
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_add.png')}}">
        </p>

        <p>
            <strong>Details(3)</strong>.<br>
            You can filter employess .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_filter.png')}}">
        </p>
        <p>
            <strong>Details(4)</strong>.<br>
            Employee Details can be seen using this button .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_details1.png')}}">
        </p>
        <p>
            <strong>Basic</strong>.<br>
            Administrator can see and manage Basic info of an employee.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_basic1.png')}}">
        </p>
        <p>
            <strong>Immigration</strong>.<br>
            Administrator can see and manage Immigration info of an employee. If you need to use corn job, please check <b>SETUP Mail Server --> SETUP corn Job</b>.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_immigration1.png')}}">
        </p>
        <p>
            <strong>Emergency contact</strong>.<br>
            Emergency Contact of an employee can be added here .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_emergency1.png')}}">
        </p>
        <p>
            <strong>Socail Profile</strong>.<br>
            Social Profile details of an employee .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_social1.png')}}">
        </p>
        <p>
            <strong>Document</strong>.<br>
            Employee related documents can be added or updated here.
            A notification will be sent to the employee three days before the document expires.If you need to use corn job, please check <b>SETUP Mail Server --> SETUP corn Job</b>.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_document1.png')}}">
        </p>
        <p>
            <strong>Qualification</strong>.<br>
            Qualification details of an employee.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_qualification1.png')}}">
        </p>
        <p>
            <strong>Work Experience</strong>.<br>
            Previous work Experience of the employee can be added here.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_work1.png')}}">
        </p>
        <p>
            <strong>Bank Account</strong>.<br>
            Bank account details of an employee.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_bank1.png')}}">
        </p>
        <p>
            <strong>Profile</strong>.<br>
            Add/Update profile image of an employee.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_profile1.png')}}">
        </p>

        <p>
            <strong>Set Salary</strong>.<br>
            Salary of an employee can be set under this module.You can set the basic
            salary,allowances,commissions,loans etc.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_salary1.png')}}">
        </p>

        <p>
            <strong>Allowances</strong>.<br>
            Multiple allowances of an employee can be set under this module .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_allowance1.png')}}">
        </p>

        <p>
            <strong>Commissions</strong>.<br>
            Multiple commissions of an employee can be set under this module .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_commision1.png')}}">
        </p>

        <p>
            <strong>Loan</strong>.<br>
            Loan records of an employee can be set under this module .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_loan1.png')}}">
        </p>

        <p>
            <strong>Deductions</strong>.<br>
            You can find the Deductions records of an employee here.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_deduction1.png')}}">
        </p>

        <p>
            <strong>Other payment</strong>.<br>
            Other payment related information can be added here.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_other_payment1.png')}}">
        </p>

        <p>
            <strong>Overtime</strong>.<br>
            Employee Overtime info.
            You can set total number of Overtime hour and per hour rate here which will be added up to that specific
            employee.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_overtime1.png')}}">
        </p>

        <p>
            <strong>Leave</strong>.<br>
            Detailed leave information of an employee till date.

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_leave1.png')}}">
        </p>

        <p>
            <strong>Core HR</strong>.<br>
            Detailed information about award, travel, training, ticket, transfer, promotion , complaint, warning of
            an employee till date
            can be viewed here.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_core_hr1.png')}}">
        </p>

        <p>
            <strong>Project & Task</strong>.<br>
            Detailed information about the projects and tasks that have been assigned to the employee
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_project.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_task.png')}}">
        </p>

        <p>
            <strong>Payslips</strong>.<br>
            Detailed information about the Payslips of an employee. You can view(1) or download(2) the payslip
        </p>
        <p>
            Payslip
            <img alt="" src="{{ asset('docs/assets/images/employee_payslip1.png')}}">
        </p>

        <strong>View</strong>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/payslip_view.png')}}">
        </p>


    </section>

    <section id="import_employee">
        <div class="page-header">
            <h3>Import Employee</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Employees</strong>-><strong>Import Employee</strong>
            You can import employee information using a csv file . The imported employee information will be added
            in the user and
            employee record .
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/import_employee.png')}}">
        </p>
        <ul>
            <li><strong>Note :</strong>Before uploading a csv you must download the sample file(1) . Do not alter or
                change the header row or first line
                of the sample file, Keep it as it is and input your data starting from second row.
            </li>
            <li>Then upload the csv file (2).
            </li>
            <li>
                Then click save (3)
            </li>

        </ul>
        <p>
            <strong>Note :</strong> If there is any error, the page will show you the error line, please fix that
            error and try to upload again.<br>
            <strong>Note :</strong> This is a batch process, so the action will need some time, please wait
            patiently.<br>
            <img alt="" src="{{ asset('docs/assets/images/import_employee1.png')}}">
        </p>
    </section>

    <section id="user_list">
        <div class="page-header">
            <h3>User List</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>User</strong>-><strong>User List</strong><br>
            Here you can view the record of all the users. You can also add users using <strong>Add User(2)</strong>
            and also can redirect to Employee's and Client's add form. The purpose of this is to add user that can manage/edit the resources
            of the system. The user will have default access to all the resources.But you can change/limit the
            access using
            <strong>Roles and Access</strong> under <strong>Customize Setting</strong>
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/user_list2.png')}}">
        </p>

    </section>

    <section id="assign_role">
        <div class="page-header">
            <h3>User role and access</h3>
            <hr class="notop">
        </div>

        <p>
            <strong>Assign Role</strong><br>
            Assigning role to a user .By default, admin can access everything.If you want to limit specific user
            some
            resources or permissions you can add new role and assign that role to that particular user.<br>
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/assign_role1.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/assign_role2.png')}}">
        </p>

        <ol>
            <li><strong>Role :</strong>Go Back To Role Page</li>
            <li><strong>Assign Role :</strong>Assign Role to a user</li>
        </ol>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/assign_role.png')}}">
        </p>

        <p>
            Select multiple user using checkbox and then assign a role to them.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/multi_assign.png')}}">
        </p>

    </section>

    <section id="user_last_login">
        <div class="page-header">
            <h3>User Last Login</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>User</strong> -> <strong>User Last Login</strong>.<br>
            You can view the last log in ip and log in date-time of a user.<br>

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/user_last_login.png')}}">
        </p>
    </section>

    <section id="promotion">
        <div class="page-header">
            <h3>Promotion</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Promotion</strong>.<br>
            You can add/edit promotion record for an employee. The promoted employee will be notified through in app
            notification

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/promotion.png')}}">
        </p>
    </section>

    <section id="award">
        <div class="page-header">
            <h3>Award</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Award</strong>.<br>
            You can add/edit award record of an employee. The awarded employee will be notified through in app
            notification

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/award.png')}}">
        </p>
    </section>

    <section id="travel">
        <div class="page-header">
            <h3>Travel</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Travel</strong>.<br>
            Admin can add/edit travel record of an employee. Moreover, admin can approve/reject travel request of an
            employee.
            The approved travel request record will send an in app notification to the respected employee

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/travel.png')}}">
        </p>
    </section>

    <section id="transfer">
        <div class="page-header">
            <h3>Transfer</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Transfer</strong>.<br>
            Admin can transfer an employee from one department to another department.
            The transferred employee will be notified through in app notification

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/transfer.png')}}">
        </p>
    </section>

    <section id="resignation">
        <div class="page-header">
            <h3>Resignation</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Resignation</strong>.<br>
            Resignation records of employees. Admin can add and edit resignation information.
            The resignated employee will be notified through in app notification

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/resignation.png')}}">
        </p>
    </section>

    <section id="complaint">
        <div class="page-header">
            <h3>Complaint</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Complaint</strong>.<br>
            Complain from an employee and against an employee can be seen and added here.
            Both of the employees will be notified .

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/complaint.png')}}">
        </p>
    </section>

    <section id="warning">
        <div class="page-header">
            <h3>Warning</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Warning</strong>.<br>
            Admin can give warning to an employee.
            The warned employee will be notified through in app notification

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/warning.png')}}">
        </p>
    </section>

    <section id="termination">
        <div class="page-header">
            <h3>Termination</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Core HR</strong> -> <strong>Termination</strong>.<br>
            Admin can terminate an emoloyee.
            The terminated employee will be notified through in app notification

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/termination.png')}}">
        </p>
    </section>

    <section id="announcement">
        <div class="page-header">
            <h3>Announcement</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Organization</strong> -> <strong>Announcement</strong>.<br>
            Admin can publish an announcement here . The announcement will be displayed on the dashboard from start
            time
            to end time.
            All the users will be notified.

        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/announcement.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/announcement1.png')}}">
        </p>
    </section>

    <section id="policy">
        <div class="page-header">
            <h3>Policy</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Organization</strong> -> <strong>Company Police</strong>.<br>
            Admin can add/update company policy here .
            adding or updating company policy will notify all the user.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/policy.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/policy1.png')}}">
        </p>
    </section>

    <section id="attendance">
        <div class="page-header">
            <h3>Attendance</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Report</strong> -> <strong>Attendance</strong>.<br>
            Admin can view attendance info of all the employees here. Admin can select a specific date(1) and
            search(2) for
            attendance of all the employees on that particular date.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/attendance.png')}}">
        </p>
        <p>
            Detailed attendance info of the employee. The employee can clock in from their respective employee
            dashboard.
            If the clock in time is equal or before the employee shift in time then the clock in value will be the
            shift in time and
            the employee will be remarked to be present on time . If the clock in time is later then the shift in
            time, then it
            will be counted and calculated as late arrival. On the other hand, if the clock out time is before the
            employee shift out time
            then it will be counted and calculated as early leaving. If the clock out time is greater then the shift
            out time then it
            will be counted and calculated as overtime .
            If an employee clock in then clock out during shift time then the time s/he will remain clocked out will
            be counted as rest.
            Similarly, the total amount of time the employee remain clocked in will be counted as total work.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/attendance_info.png')}}">
        </p>
    </section>

    <section id="datewise_attendance">
        <div class="page-header">
            <h3>Datewise Attendance</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Report</strong> -> <strong>Date wise Attendance</strong>.<br>
            Admin can view datewise attendance info of a selected employee here. Admin can select start-end date(1)
            and search(2) for
            attendances of the employees on that date range.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/datewise_attendance.png')}}">
        </p>
        <p>
            Datewise attendance table
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/datewise_attendance_table.png')}}">
        </p>
    </section>

    <section id="monthly_attendance">
        <div class="page-header">
            <h3>Monthly Attendance</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Report</strong> -> <strong>Monthly Attendance</strong>.<br>
            Admin can view Monthly attendance info of all the employees here. I will show the attendance info of the
            current month by default.
            There is also search/filter option.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/monthly_attendance_table.png')}}">
        </p>
        <p>
            Admin can select month,company or employee to filter out for the desired result.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/monthly_attendance.png')}}">
        </p>
    </section>


    <section id="update_attendance">
        <div class="page-header">
            <h3>Update Attendance</h3>
            <hr class="notop">
        </div>
        <p>
            Admin can update attendance of a certain employee. For that the admin will first search(1) for the
            specific date and employee
            that the attendance needs to be updated. Then admin can edit/update(2) that specific attendance or
            add(3) attendance on that date.
        </p>
        <p>
            Search or Get (1)
            <img alt="" src="{{ asset('docs/assets/images/update_attendance_get.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/update_attendance_get_add.png')}}">
        </p>
        <p>
            Add (2)
            <img alt="" src="{{ asset('docs/assets/images/update_attendance_add.png')}}">
        </p>
        <p>
            Edit (3)
            <img alt="" src="{{ asset('docs/assets/images/update_attendance_edit.png')}}">
        </p>

    </section>


    <section id="import_attendance">
        <div class="page-header">
            <h3>Import Attendance</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Timesheets</strong>-><strong>Import Attendance</strong><br>
            You can import Attendance information using a csv file . The imported employee information will be added
            in the attendance
            table .
        </p>
        <ul>
            <li><strong>Note :</strong>Before uploading a csv you must download the sample file . Do not alter or
                change the header row or first line
                of the sample file, Keep it as it is and input your data starting from second row.
            </li>
            <li>Then upload the csv file.
            </li>
            <li>
                Then click save.
            </li>

        </ul>
        <p>
            <strong>Note :</strong> If there is any error,the page will show you the error line, please fix that
            error and try to upload again.
            <img alt="" src="{{ asset('docs/assets/images/import_attendance.png')}}">
        </p>
    </section>


    <section id="manage_holiday">
        <div class="page-header">
            <h3>Manage Holidays</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Timesheets</strong>-><strong>Manage Holidays</strong><br>
            Admin can add/update holiday information here . The employees will see the information of the published
            holidays
            on their dashboard.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/holiday.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/holiday_add.png')}}">
        </p>
    </section>

    <section id="manage_leave">
        <div class="page-header">
            <h3>Manage Leaves</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Timesheets</strong>-><strong>Manage Leaves</strong><br>
            Admin can add/update leave information here . Besides, admin can approve or reject leave request
            submitted by
            an employee . Employee will get a notification upon admin approval or rejection.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/leave.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/leave_add.png')}}">
        </p>
    </section>


    <section id="payslip_report">
        <div class="page-header">
            <h3>Payslip Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Payslip Report</strong><br>
            Admin can view the payslip report here . By default,It will show the current month payment info.
            But admin can filter result using the search button.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payslip_report_table.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payslip_report.png')}}">
        </p>
    </section>


    <section id="attendance_report">
        <div class="page-header">
            <h3>Attendance Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Attendance Report</strong><br>
            Admin can view the attendance report here . Admin can select a start and end date to find out the
            attendance info
            of that date range.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/datewise_attendance_table.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/datewise_attendance.png')}}">
        </p>
    </section>


    <section id="training_report">
        <div class="page-header">
            <h3>Training Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Training Report</strong><br>
            Admin can view the training report here . Admin can select a start and end date to find out the
            attendance info
            of that date range.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/training_report.png')}}">
        </p>
    </section>

    <section id="project_report">
        <div class="page-header">
            <h3>Project Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Project Report</strong><br>
            Admin can view the project report here . Admin can select a project or status and search for the result.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/project_report_search.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/project_report.png')}}">
        </p>
    </section>


    <section id="task_report">
        <div class="page-header">
            <h3>Task Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Task Report</strong><br>
            Admin can view the task report here . Admin can select a task or status and search for the result.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/task_report_search.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/task_report.png')}}">
        </p>
    </section>

    <section id="employee_report">
        <div class="page-header">
            <h3>Employee Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Employee Report</strong><br>
            All of the employees information can be found on this table. Admin can also search employee using
            search button.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_report.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_report_search.png')}}">
        </p>
    </section>


    <section id="account_report">
        <div class="page-header">
            <h3>Account Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Account Report</strong><br>
            Detailed account report and financial details. Admin can select a bank and get their financial report or
            select a
            start and end date to get detailed account information on that date range.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/account_report.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/account_report_search.png')}}">
        </p>
    </section>

    <section id="expense_report">
        <div class="page-header">
            <h3>Expense Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Expense Report</strong><br>
            Detailed expense report . Admin can select a category expense and then select a
            start and end date to get detailed expense information on that date range.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/expense_report_search.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/expense_report.png')}}">
        </p>
    </section>

    <section id="deposit_report">
        <div class="page-header">
            <h3>Deposit Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Deposit Report</strong><br>
            Detailed expense report . Admin can select a category deposit and then select a
            start and end date to get detailed deposit information on that date range.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/deposit_report_search.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/deposit_report.png')}}">
        </p>
    </section>

    <section id="transaction_report">
        <div class="page-header">
            <h3>Transaction Report</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>HR Reports</strong>-><strong>Transaction Report</strong><br>
            Detailed transaction report . Admin can select a
            start and end date to get detailed transaction information on that date range.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/transaction_report_search.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/transaction_report.png')}}">
        </p>
    </section>


    <section id="job_post">
        <div class="page-header">
            <h3>Job Post</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Recruitment</strong>-><strong>Job Post</strong><br>
            Admin can add(1)/update(2) job post here. If a job post status is published then only it will be shown
            on the front job
            page . You can view the front job page by clicking on the details(3) button.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/job_post.png')}}">
        </p>
        <p>
            (1)
            <img alt="" src="{{ asset('docs/assets/images/job_post_add.png')}}">
        </p>
        <p>
            (3)
            <img alt="" src="{{ asset('docs/assets/images/job_post_details1.png')}}">
            <img alt="" src="{{ asset('docs/assets/images/job_post_details2.png')}}">
        </p>
    </section>

    <section id="job_post">
        <div class="page-header">
            <h3>Job Canidate</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Recruitment</strong>-><strong>Job Candidate</strong><br>
            Admin can view the details of the applied Candidates here.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/job_candidate.png')}}">
        </p>
        <strong>Details</strong>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/job_candidate_details.png')}}">
        </p>

    </section>


    <section id="job_interview">
        <div class="page-header">
            <h3>Job Interview</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Recruitment</strong>-><strong>Job Interview</strong><br>
            Admin can select from the applied candidates and call them for Interview using this module.
            The selected candidates will be notified through an email.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/job_interview.png')}}">
        </p>

    </section>


    <section id="cms">
        <div class="page-header">
            <h3>CMS</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Recruitment</strong>-><strong>CMS</strong><br>
            Admin can create html template for the front end of the website. They can create home,about and contact
            page using this module.
            These pages can be viewed on the url your_url/home, your_url/about and your_url/contact responsively.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/cms.png')}}">
        </p>

    </section>


    <section id="training_type">
        <div class="page-header">
            <h3>Training Type</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Training</strong>-><strong>Training Type</strong><br>
            Admin can add/update/delete training type. This is necessary before adding training record
            as training information depends on training type.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/training_type.png')}}">
        </p>

    </section>

    <section id="trainer">
        <div class="page-header">
            <h3>Trainer</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Training</strong>-><strong>Trainer</strong><br>
            Admin can add/update/delete trainer that will conduct the training. This is necessary before adding
            training record
            as training information depends on trainer.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/trainer.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/trainer_add.png')}}">
        </p>

    </section>

    <section id="training_list">
        <div class="page-header">
            <h3>Training List</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Training</strong>-><strong>Training List</strong><br>
            Admin can add/update/delete training information. Admin can select multiple employees to a particular
            training program.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/training_list.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/training_list_add.png')}}">
        </p>

    </section>


    <section id="new_payment">
        <div class="page-header">
            <h3>New Payment</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Payment</strong> -> <strong>New Payment</strong>.<br>
            Employee payroll information and payment can be managed here.
            Authorized user can view and pay employee.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/new_payment.png')}}">
        </p>
        <p>
            The search filter can be used to search to get payroll information of the selected employees.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/new_payment_search.png')}}">
        </p>

        <p>
            <strong>Payroll Table</strong><br>
            You can pay employee or view their payment details.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payroll_table.png')}}">
        </p>
        <p>
            <strong>View(1)</strong><br>
            the detailed information of the payslip of an employee . The net salary along with
            the details can be seen here . Admin can update the salary from the employee module by going to the
            details page
            of that employee.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payslip_view.png')}}">
        </p>

        <p>
            <strong>Paid Info(2)</strong><br>
            Paid info of an employee can be seen here.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/paid_payslip.png')}}">
        </p>


        <p>
            <strong>Download(3)</strong><br>
            You can download the payslip using this button.
        </p>


        <p>
            <strong>Pay(4)</strong><br>
            Admin can pay an employee using this button.
            The net salary is calculated as follows: <br>
            <strong>Net Salary =</strong> net salary + (total allowances + commissions + total overtime + other
            payment) - (statutory deductions + monthly payable) <br>

            <strong>Note: </strong> The payment form fileds are not editable.If you want to change the payment, you
            have to go to the
            employee profile.<br>
            The paid amount will be deducted from the main account balance.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/pay_payslip.png')}}">
        </p>

        <p>
            <strong>Bulk Payment</strong><br>
            Admin can pay all employees or select a company or department to pay employees of that company or
            department .
            You can search for the employees that you want to pay to confirm before your desired action and then
            click on bulk payment to pay or just select the filter and click
            on bulk payment to pay as one go.
            <strong>Note: </strong> This is a batch process that will need some time. please wait patiently.
            The paid amounts will be deducted from the main account balance.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/new_payment_bulk.png')}}">
        </p>

    </section>


    <section id="payment_history">
        <div class="page-header">
            <h3>Payment History</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Payroll</strong>-><strong>Payment History</strong><br>
            History of the successful payment to the employees till date. You can view(1) or download(2) the payslip
            form
            here.s
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payment_history.png')}}">
        </p>
    </section>

    <section id="goal_type">
        <div class="page-header">
            <h3>Goal Type</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Performance</strong>-><strong>Goal Type</strong><br>
            You can see performance goal type list for the employees.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/goal_type_list.png')}}">
        </p>

        <p>
            <strong>Add New Type</strong><br>
            You can add new goal type.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/add_goal_type.png')}}">
        </p>
    </section>


    <section id="goal_tracking">
        <div class="page-header">
            <h3>Goal Tracking</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Performance</strong>-><strong>Goal Tracking</strong><br>
            You can see performance goal tracking list for the employees.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/goal_tracking_list.png')}}">
        </p>

        <p>
            <strong>Add New Goal Tracking (1)</strong><br>
            You can add new goal tracking.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/add_new_goal_tracking.png')}}">
        </p>

        <p>
            <strong>Edit Goal Tracking (2)</strong><br>
            You can edit goal tracking.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/edit_goal_tracking.png')}}">
        </p>
    </section>


    <section id="indicator">
        <div class="page-header">
            <h3>Indicator</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Performance</strong>-><strong>Indicator</strong><br>
            You can see indicator list of peroformance.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/indicator_list.png')}}">
        </p>

        <p>
            <strong>Add New Indicator (1)</strong><br>
            You can add new indicator info.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/add_indicator.png')}}">
        </p>
    </section>


    <section id="appraisal">
        <div class="page-header">
            <h3>Appraisal</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Performance</strong>-><strong>Appraisal</strong><br>
            You can see apprisal list of peroformance.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/appraisal_list.png')}}">
        </p>

        <p>
            <strong>Add New Indicator (1)</strong><br>
            You can add new appraisal info of employee performance.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/add_appraisal.png')}}">
        </p>
    </section>


    <section id="hr_calendar">
        <div class="page-header">
            <h3>HR Calendar</h3>
            <hr class="notop">
        </div>
        <p>
            You can view all the events/occurance/deadline in a calendar(1) view in this module.
            Admin can also add events/occurance here using the option(2) section.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/calendar.png')}}">
        </p>

    </section>


    <section id="event">
        <div class="page-header">
            <h3>Event</h3>
            <hr class="notop">
        </div>
        <p>
            Admin can view/add/edit events here. The event can be for a specific company or a specific department.
            The related employees will get a notification for the approved event.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/event.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/event_add.png')}}">
        </p>

    </section>


    <section id="meeting">
        <div class="page-header">
            <h3>Meeting</h3>
            <hr class="notop">
        </div>
        <p>
            Admin can view/add/edit meeting here. Admin can select specific employees for a meeting and can notify
            them about the meeting. <br>
            If you set your meeting status <b>Ongoing</b>, then it will display in Calender.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/meeting.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/meeting_add.png')}}">
        </p>

    </section>


    <section id="client">
        <div class="page-header">
            <h3>Client</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Project Management</strong> -> <strong>Client</strong>.<br>
            Admin can view the current clients or add/update a client. Client can login with the credentials set by
            the admin and later can
            uodate the credentials. Client can request for new project or task. Client will be notified about the
            project update.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client.png')}}">
        </p>
        <strong>Add Client</strong>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_add.png')}}">
        </p>
    </section>


    <section id="tax_type">
        <div class="page-header">
            <h3>Tax Type</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Project Management</strong> -> <strong>Tax Type</strong>.<br>
            Admin can add/update tax type and tax rate here. This is important before creating an invoice as
            invoice total is dependent on tax rate.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/tax_type.png')}}">
        </p>
        <strong>Add tax Type</strong>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/tax_type_add.png')}}">
        </p>
    </section>


    <section id="project">
        <div class="page-header">
            <h3>Project</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Project Management</strong> -> <strong>Project</strong>.<br>
            Admin can view/add/update a project and project details here. The requested projects of the client can
            also be seen here.
            Admin will be notified when a client creates a project. Admin can assign a project to certain employees.
            The assigned employees
            will be notified about the assigned projects.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/project.png')}}">
        </p>
        <strong>Add Project</strong>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/project_add.png')}}">
        </p>
        <strong>Project Details</strong>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/project_details1.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/project_details2.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/project_details3.png')}}">
        </p>


    </section>


    <section id="task">
        <div class="page-header">
            <h3>Task</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Project Management</strong> -> <strong>Task</strong>.<br>
            Admin can view/add/update a task and task details here. Admin can add a task under a project or task can
            be added independently.
            Client can request for a task under a certain project, admin will be notified about the requested task.
            Admin can assign certain employees
            to a specific task,the employees will be notified about the assigned task.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/task.png')}}">
        </p>
        <strong>Add Task</strong>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/task_add.png')}}">
        </p>
        <p>
            <strong>Task Details</strong>
            <img alt="" src="{{ asset('docs/assets/images/task_details.png')}}">
        </p>


    </section>


    <section id="invoice">
        <div class="page-header">
            <h3>Invoice</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Project Management</strong> -> <strong>Invoice</strong>.<br>
            Admin can create(1) an inovice for a project . The invoice will contain detailed(2) information about
            project cost.
            After successfully creating an invoice the status will be unpaid by default. But the admin can change
            the staus(3) to
            paid or send the invoice to the client. When the invoice status is unpaid it will not notify the client.
            If the invoice is
            ready then the admin can send it to the client. The client will be notified through both email and in
            app notification.
            When the client payment is receievd, the admin can change the status to paid. The client will be
            notified through both email and in app notification
            that the payment has been receievd.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/invoice.png')}}">
        </p>
        <strong>Add Invoice</strong><br>

        <p>
            Admin can add items and their price dynamically. The sub total for an item will be calculated as
            follows: <br>
            <strong>Sub Total=</strong> (Qty * Unit price)- tax rate <br>
            Discount can also be added here if there is any. The grand total will be calculated as follows: <br>
            <strong>Grand Total=</strong>Total sub total - discount amount <br>
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/invoice_add.png')}}">
        </p>
        <p>
            <strong>Details of Invoice</strong><br>
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/invoice_details.png')}}">
        </p>


    </section>


    <section id="support_ticket">
        <div class="page-header">
            <h3>Support Ticket</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Support Ticket</strong>
            Admin or Employee can open(1) a support a ticket for an issue. If a emoloyee request for a support
            ticket, the admin
            can approve and assign employee to resolve the issue. Details(2) page will show the detailed info of the
            ticket.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/support_ticket.png')}}">
        </p>
        <strong>Add Ticket</strong>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/support_ticket_add.png')}}">
        </p>
        <p>
            <strong>Ticket Details</strong>
            <img alt="" src="{{ asset('docs/assets/images/support_ticket_details.png')}}">
        </p>

    </section>


    <section id="account_balance">
        <div class="page-header">
            <h3>Account Balance</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Available Balance</strong>.<br>
            The current available balance of the bank. For each deposit or expense the available balance of the
            respected bank will update.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/available_balance.png')}}">
        </p>

    </section>

    <section id="payee">
        <div class="page-header">
            <h3>Payee</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Payee</strong>.<br>
            You can view/add payee information . Basically a payee is a person to whom money is paid or is to be
            paid.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payee.png')}}">
        </p>

    </section>

    <section id="payer">
        <div class="page-header">
            <h3>Payer</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Payer</strong>.<br>
            You can view/add payer information . Basically a payer is a person who pays money.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/payer.png')}}">
        </p>

    </section>

    <section id="deposit">
        <div class="page-header">
            <h3>Deposit</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Deposit</strong>.<br>
            You can view/add deposit information . You can deposit money to the selected bank account.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/deposit.png')}}">
        </p>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/deposit_add.png')}}">
        </p>

    </section>

    <section id="expense">
        <div class="page-header">
            <h3>Expense</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Expense</strong>.<br>
            All of the finance expenses can be seen here . Employee payment expenses will also appear here.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/expense.png')}}">
        </p>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/expense_add.png')}}">
        </p>

    </section>

    <section id="transaction">
        <div class="page-header">
            <h3>Transaction</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Transaction</strong>.<br>
            Detailed transaction history till date is shown here.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/transaction.png')}}">
        </p>


    </section>

    <section id="transfer">
        <div class="page-header">
            <h3>Transfer</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Finance</strong> -> <strong>Transfer</strong>.<br>
            You can transfer balance from one account to another.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/finance_transfer.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/add_transfer.png')}}">
        </p>


    </section>

    <section id="asset_category">
        <div class="page-header">
            <h3>Asset Category</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Assets</strong> -> <strong>Category</strong>.<br>
            Asset Category can be added/updated here.<br>
            <strong>Note :</strong> This is mandatory before adding asset record.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/asset_category.png')}}">
        </p>


    </section>

    <section id="asset">
        <div class="page-header">
            <h3>Asset</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Assets</strong> -> <strong>Assets</strong>.<br>
            Asset info can be added/updated here and that asset can be assigned to an employee.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/asset.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/asset_add.png')}}">
        </p>


    </section>


    <section id="file_configuration">
        <div class="page-header">
            <h3>File Configuration</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>File Manager</strong> -> <strong>File Configuration</strong>.<br>
            Allowed file types/extensions can be added here. Moreover, the maximum file size can also be defined
            here.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/file_configuration.png')}}">
        </p>

    </section>


    <section id="file_manager">
        <div class="page-header">
            <h3>File Manager</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>File Manager</strong> -> <strong>File Manager</strong>.<br>

            You can add/update file for a certain department. You can also add external link e.g google drive,imagur
            etc.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/file_manager.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/file_manager_add.png')}}">
        </p>


    </section>


    <section id="official_document">
        <div class="page-header">
            <h3>Official Document</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>File Manager</strong> -> <strong>Official Document</strong>.<br>

            You can add/update Official Documents here. You can also select the date when to send mail notification
            before the document expires. If you need to use corn job, please check <b>SETUP Mail Server --> SETUP corn Job</b>.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/official_document.png')}}">
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/official_document_add.png')}}">
        </p>


    </section>


    <section id="client_dashboard">
        <div class="page-header">
            <h3>Client DASHBOARD</h3>
            <hr class="notop">
        </div>
        <p>
            The system offers an informative,interactive and simple client dashboard.
            client can view all the project and invoice related information at a glance in the dashboard.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_dashboard.png')}}">
        </p>

        <ul>
            <li><strong>Profile:</strong> Client can go the profile page and update profile info if needed</li>
            <li><strong>Paid Invoice:</strong> Total number of invoices that has been paid, clicking the link will
                show detailed information
            </li>
            <li><strong>Unpaid Invoice:</strong> Due invoices, clicking the link will show detailed information</li>
            <li><strong>Completed Projects:</strong> Total number of projects that has been Completed, clicking the
                link will show detailed information
            </li>
            <li><strong>In Progress Projects:</strong>The projects that are still being worked on, clicking the link
                will show detailed information
            </li>
            <li><strong>Paid amount:</strong>Total paid amount till date</li>
            <li><strong>Due amount:</strong>Due Amount</li>
        </ul>

    </section>


    <section id="client_project">
        <div class="page-header">
            <h3>Client Project</h3>
            <hr class="notop">
        </div>
        <p>
            Client can view and track prject details and add new project request with project details. The admin
            will be notified about the project
            request.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_project.png')}}">
        </p>

        <strong>Add Project</strong>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_project_add.png')}}">
        </p>


    </section>

    <section id="client_task">
        <div class="page-header">
            <h3>Client Task</h3>
            <hr class="notop">
        </div>
        <p>
            Client can view and track task details and add new task under a project. S/he can edit/update task
            details.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_task.png')}}">
        </p>

        <strong>Add Task</strong>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_task_add.png')}}">
        </p>


    </section>


    <section id="client_invoice">
        <div class="page-header">
            <h3>Client Invoice</h3>
            <hr class="notop">
        </div>
        <p>
            The due/unpaid invoices can be seen here. Click(1) to see details.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_invoice.png')}}">
        </p>

        <strong>Details</strong>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_invoice_details.png')}}">
        </p>
    </section>


    <section id="client_invoice_paid">
        <div class="page-header">
            <h3>Client Paid Invoice</h3>
            <hr class="notop">
        </div>
        <p>
            Paid invoice and their details(1).
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_invoice_paid.png')}}">
        </p>

        <strong>Details</strong>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/client_invoice_paid_details.png')}}">
        </p>
    </section>


    <section id="employee_dashboard">
        <div class="page-header">
            <h3>Employee DASHBOARD</h3>
            <hr class="notop">
        </div>
        <p>
            The system offers an interactive, easy to use employee dashboard.
            employee can view all of their relevant information at a glance in the dashboard.
            The sidebar will only show the module that the employee is permitted to access or us by the admin.
        </p>
        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_dashboard.png')}}">
        </p>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_dashboard1.png')}}">
        </p>
        <ol>
            <li><strong>Profile:</strong> Employee can go the profile page and update profile info if needed</li>
            <p>
            <p>
                <img alt="" src="{{ asset('docs/assets/images/employee_profile_self.png')}}">
            </p>
            </p>
            <li><strong>Clock In: </strong> Employee can clock in to mark his/her attendance. As soon as s/he
                clocked in their will be a
                clock out button to clock out. The system will record both the clock in and clock out time
            </li>
        </ol>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_dashboard2.png')}}">
        </p>
        <p>
            Employee can view their payslips, awards and if their is any recent announcements or holidays.
            All of them are clickable and will show detailed information.
        </p>


        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_dashboard3.png')}}">
        </p>
        <p>
            Employee can view their leave info, travel info and ticket info till date by clicking on the link. They
            can also request for
            new leave, travel or open a ticket if there is any issue.
        </p>

        <p>
            <img alt="" src="{{ asset('docs/assets/images/employee_dashboard4.png')}}">
        </p>
        <p>
            Assigned projects, tasks and tickets of to the employee will be listed here.
            Employee can click on them for more details.
        </p>

    </section>


    <section id="general_error">
        <div class="page-header">
            <h3>General Error</h3>
            <hr class="notop">
        </div>
        <p>
            If You face any error like- 500 server error or 403 server error, please first go to your project root folder and open the .env file and set APP_DEBUG=true. Then go to the page where you faced the error and reload the page.
            Now you should  take a screenshot and send it to us at Support : <a href="mailto:support@lion-coders.com">support@lion-coders.com</a>, It will us to quickly resolve the error.
        <p>
            <img alt="" src="{{ asset('docs/assets/images/general_error.png')}}">
        </p>
    </section>


    <section id="video_tutorial">
        <div class="page-header">
            <h3>VIDEO TUTORIAL</h3>
            <hr class="notop">
        </div>
        <p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/SL2AqRj1KiI" title="Video Tutorial" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </section>


    <section id="autoUpdateFeature">
        <div class="page-header">
            <h3>Auto Update Feature</h3>
            <hr class="notop">
        </div>

        <h4><b>1.New version release</b></h4>
        <h5><b>Notification -</b></h5>
        <p>When a new version is prepared for releasing, a notification message in dashboard will be shown.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/1.Notification-Version-Upgrade.png')}}"></p>


        <h5><b>Procedure -</b></h5>

        <p>After clicking, it'll redirect to this page you will see the change log details & update button. Click the Upgrade button.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/3.Version-Upgrade-Page.png')}}"></p>

        <p>After upgrading, it'll redirect to you here.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/4.success-version-upgrade.png')}}"></p>

        <h5><b>Error -</b></h5>
        <p>If you see this notification during upgrade, please contact at <a href="lion-coders.com/support">Support Panel</a>.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/8.Error.png')}}"></p>



        <h4><b>2.Bug Update</b></h4>
        <h5><b>Notification -</b></h5>
        <p>If any bug found, a notification message in dashboard will be shown.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/2.Notification-Bug-Update.png')}}"></p>

        <h5><b>Procedure -</b></h5>

        <p>After clicking, it'll redirect to this page you will see the change log details & update button. Click the Update button.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/5.Bug-Update-page.png')}}"></p>

        <p>After updating, it'll redirect to you here.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/6.success-bug-update.png')}}"></p>


        <h5><b>Error -</b></h5>
        <p>If you see this notification during update, please contact at <a href="lion-coders.com/support">Support Panel</a>.</p>
        <p><img src="{{ asset('docs/assets/images/auto_update/7.Error.png')}}"></p>
    </section>

    <section id="support">
        <div class="page-header">
            <h3>SUPPORT</h3>
            <hr class="notop">
        </div>
        <p> We are happy to provide support for any issues within our software. We also provide customization service for as little as $15/hour. So if you have any features in mind or suugestions, please feel free to knock us at <a href="https://lion-coders.com/support">lion-coders.com/support</a>. Please note that we don't provide support though any other means (example- whatsapp, remote platform, comments etc). And if any client modify/add any code of our script and then face problem, we don't provide the support on that specific feature where he/she face problem. We only fix the bugs/issues if it's exists from previous. So, please refrain from commenting your queries on codecanyon or kocking us elsewhere.</p>
        <p>Also, in case of any errors/bugs/issues on your installation, please contact us with your hosting details (url, username, password), software admin access (url, username, password) and purchase code. If your support period has expired, please renew support on codecanyon before contacting us for support.</p>
        <p>Thank you and with best wishes - <a href="http://lion-coders.com">LionCoders</a></p>
    </section>

</div>


<script type="text/javascript">

    $("#documenter_sidebar").mCustomScrollbar({
        theme: "light",
        scrollInertia: 200
    });


    $(document).ready(function() {
        const currentUrl = window.location.href;
        const baseUrl = currentUrl.split("/").slice(0, -1).join("/");
        const attendanceDeviceURL = baseUrl + '/documentation-attendance-device-addon'
        console.log('attendanceDeviceURL -',attendanceDeviceURL);
        $("#attendanceDeviceAddon").attr({
            href: attendanceDeviceURL,
            target: "_blank"
        });
    });





    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    var states = ['Start',
        'Server Requirements',
        'Install',
        'Software Update',
        'Log In',
        'Admin Dashboard',
        'Empty Database',
        'Datatable Options',
        'Location',
        'Company',
        'Department',
        'Designation',
        'Office Shift',
        'Account List',
        'Roles Access',
        'General Setting',
        'Mail Server',
        'Language Setting',
        'Variable Type',
        'Variable Method',
        'Employee List',
        'Import Employee',
        'User List',
        'Assign Role',
        'User Last Login',
        'Location',
        'Award',
        'Travel',
        'Transfer',
        'Resignation',
        'Complaint',
        'Warning',
        'Termination',
        'Announcement',
        'Company Policy',
        'Attendance',
        'Datewise Attendance',
        'Monthly Attendance',
        'Update Attendance',
        'Import Attendance',
        'Manage Holiday',
        'Manage Leave',
        'Payslip Report',
        'Attendance Report',
        'Training Report',
        'Project Report',
        'Task Report',
        'Employee Report',
        'Account Report',
        'Expense Report',
        'Deposit Report',
        'Transaction Report',
        'Job Post',
        'Job Candidate',
        'Job Interview',
        'CMS',
        'New Payment',
        'Payslip History',
        'HR Calendar',
        'Event',
        'Meeting',
        'Client',
        'Tax Type',
        'Project',
        'Task',
        'Invoice',
        'Support Ticket',
        'Account Balance',
        'Payee',
        'Payer',
        'Deposit',
        'Expense',
        'Transaction',
        'Transfer',
        'Asset Category',
        'Asset',
        'File Configuration',
        'File Manager',
        'Official Document',
        'Client Dashboard',
        'Client Project',
        'Client Task',
        'Client Invoice',
        'Client Invoice Paid',
        'Employee Dashboard',
        'Support',
        'General Error'
    ];

    $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'states',
            source: substringMatcher(states)
        });

    $('.typeahead').bind('typeahead:select', function (ev, suggestion) {
        let a = suggestion.toLowerCase();
        a = a.replace(/\s+/g, "_");

        let site_url = window.location.href;

        site_url = site_url.split("#")[0];

        window.location.href = site_url + '#' + a;
    });


</script>
</body>

</html>


