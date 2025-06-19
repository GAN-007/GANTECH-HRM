@extends('layout.main')

@section('content')
    <div class="col-md-12 p-3">

        <div class="col-md-3 p-3">
            <button id="print-btn" type="button" class="btn btn-default btn-sm d-print-none"><i
                        class="fa fa-print"></i> {{trans('file.Print')}}</button>
        </div>

        <div class="card invoice_details">
            <div class="card-body" id="invoice_details">
                <h2>{{$company->company_name}}
                    <small class="pull-right">{{trans('file.Date')}}-{{ date('d-m-Y') }}</small>
                </h2>
                <hr>

                <div class="row">
                    <div class="col-sm-4 company-col"> {{trans('file.From')}}
                        <address>
                            <strong>{{$company->company_name}}</strong><br>
                            {{$location->address1}}<br>
                            {{$location->city}}, {{$location->zip}}<br>
                            {{$location->country}}<br/>
                            Phone: {{$company->contact_no}}      </address>
                    </div>

                    <div class="col-sm-4 client-col"> {{trans('file.To')}}
                        <address>
                            <strong>{{$client->name}}</strong><br>
                            {{$client->company_name}}<br>
                            {{$client->address1 ?? ''}} {{$client->address2 ?? ''}}<br>
                            Phone: {{$client->contact_no}}<br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col"><b>{{trans('file.Invoice')}}
                            # {{$invoice->invoice_number}}</b><br>
                        <br>
                        <b>{{trans('file.Date')}}: </b>{{$invoice->invoice_date}} <br>
                        <b>{{__('Payment Due')}}: </b> {{$invoice->invoice_due_date}}<br/>
                        <span class="label label-danger">
                        @if($invoice->status == 1)
                                {{trans('file.Paid')}}

                            @else
                                {{trans('file.UnPaid')}}
                            @endif
                    </span>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th class="py-3"> #</th>
                                <th class="py-3"> {{__('Item')}} </th>
                                <th class="py-3"> {{__('Qty')}} </th>
                                <th class="py-3"> {{__('Unit Price')}} </th>
                                <th class="py-3"> {{__('Tax Rate')}} </th>
                                <th class="py-3"> {{__('Sub Total')}} </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice_items as $key=>$invoice_item)
                                <tr>

                                    <td class="py-3">
                                        <div class="font-weight-semibold">{{$key+1}}</div>
                                    </td>
                                    <td class="py-3">
                                        <div class="font-weight-semibold">{{$invoice_item->item_name}}</div>
                                    </td>
                                    <td class="py-3"><strong>{{$invoice_item->item_qty}}</strong></td>
                                    <td class="py-3"><strong>{{$invoice_item->item_unit_price}}</strong></td>
                                    <td class="py-3"><strong>{{$invoice_item->item_tax_rate}}</strong></td>
                                    <td class="py-3"><strong>{{$invoice_item->item_sub_total}}</strong></td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row float-right mr-5">
                    <!-- /.col -->
                    <div class="col-xs-6">
                        &nbsp;
                    </div>
                    <div class="col-lg">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th class="w-50">{{__('Sub Total')}}:</th>
                                    <td>{{$invoice->sub_total}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('file.Tax')}}</th>
                                    <td> {{$invoice->total_tax}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('file.Discount')}}:</th>
                                    <td>{{$invoice->total_discount}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('file.Total')}}:</th>
                                    <td>{{$invoice->grand_total}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- /.row (main row) -->
            </div>
        </div>
    </div>



@endsection

@push('scripts')
<script>
    (function($) {
        "use strict";
        $("#print-btn").on("click", function () {
            var divToPrint = document.getElementById('invoice_details');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.invoice_details { max-width:100%;} }</style><body onload="window.print()">' + divToPrint.innerHTML + '</body>');
            newWin.document.close();
            setTimeout(function () {
                newWin.close();
            }, 10);
        });


    })(jQuery);
</script>
@endpush
