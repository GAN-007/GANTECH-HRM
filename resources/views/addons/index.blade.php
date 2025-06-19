@extends('layout.main')
@section('content')

<section class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <img class="card-img-top" src="https://codecanyon.img.customer.envatousercontent.com/files/410696268/preview.png?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=c5052325aa34961ecd247838382b7a98" style="height:250px" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Biometric Attendance Addon for PeoplePro HRM, Payroll, Project Management </h5>
                    <p class="card-text">This addon works in unison with ‘PeoplePro – HRM, Payroll & Project Management’. When installed with PeoplePro, it takes employee/staff attendance data exported from biometric attendance/fingerprint reader devices at your office/factory. This data is then used to calculate employee attendance, salary (payroll) etc.</p>
                    <a href="https://peopleprohrm.com/demo/" target="_blank" class="btn btn-danger p-2">Demo</a>
                    <a href="https://codecanyon.net/item/peoplepro-hrm-payroll-project-management/29169229" target="_blank" class="btn btn-info p-2">Buy Now</a>
                    <a href="https://peopleprohrm.com/demo/documentation" target="_blank" class="btn btn-warning p-2">Documentation</a>
                    @if (env('PRODUCT_MODE')!=='DEMO')
                        <a href="{{ route('biometric-install-step-1') }}" class="btn btn-primary p-2">Go to Install</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <img class="card-img-top" src="{{ asset('logo/peopleprosaas.png') }}" style="height:250px" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Peplepro SaaS</h5>
                    <p class="card-text">Take care of all your products, sales, purchases, stores related tasks from an easy-to-use platform, from anywhere you want, anytime you want.
                        <ul>
                            <li>Multi-tenancy</li>
                            <li>Multi-database. separate database for each subscribers</li>
                            <li>Personalized subdomain for each subscriber</li>
                            <li>Custom domain support</li>
                            <li>Unlimited subscribers</li>
                            <li>Flexible package creation</li>
                            <li>Free customizable landing page with light/dark mode design</li>
                            <li>Stripe, PayPal, Razorpay & Paystack payment gateways</li>
                        </ul>
                    </p>
                    <a href="https://peopleprohrmsaas.com/" class="btn btn-danger p-2" target="_blank">Demo</a>
                    <a href="https://codecanyon.net/item/peoplepro-saas-hrm-payroll-project-management/48966937" class="btn btn-info p-2" target="_blank">Buy Now</a>
                    <a href="https://peopleprohrmsaas.com/central-documentation" class="btn btn-warning p-2" target="_blank">Documentation</a>
                    @if (env('PRODUCT_MODE')!=='DEMO')
                        <a href="{{ route('saas-install-step-1') }}" class="btn btn-primary p-2">Go to Install</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
