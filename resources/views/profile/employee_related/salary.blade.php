<section>
    <div class="row">
        <div class="col-md-6">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{__('Month-Year')}}</th>
                        <th>{{__('Payslip Type')}}</th>
                        <th>{{__('Basic Salary')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salary_basics as $item)
                        <tr>
                            <td>{{$item->month_year}}</td>
                            <td>{{$item->payslip_type}}</td>
                            <td>{{$item->basic_salary}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td>{{__('No Data Found')}}</td>
                            <td></td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</section>
