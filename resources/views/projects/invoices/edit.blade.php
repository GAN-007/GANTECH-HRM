@extends('layout.main')
@section('content')

    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <span id="form_result"></span>
                    <h3 class="card-title">{{__('Edit Invoice')}}</h3>
                </div>
                <div class="card-body">
                    <form name="edit_invoice" id="edit_invoice" autocomplete="off" method="post" class="form"
                          accept-charset="utf-8">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_number">{{__('Invoice Number')}}</label>
                                    <input class="form-control" placeholder="{{__('Invoice Number')}}" name="invoice_number"
                                           type="text" value="{{$invoice->invoice_number}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="project">{{trans('file.Project')}}</label>
                                    <select name="project_id" id="project_id" class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Selecting',['key'=>trans('file.Project')])}}...'>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" {{ ($invoice->project_id == $project->id) ? "selected" : '' }}>{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_date">{{__('Invoice Date')}}</label>
                                    <input class="form-control date" required placeholder="Invoice Date" name="invoice_date"
                                           type="text" value="{{$invoice->invoice_date}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_due_date">{{__('Due Date')}}</label>
                                    <input class="form-control date" required placeholder="Due Date" name="invoice_due_date"
                                           type="text" value="{{$invoice->invoice_due_date}}">
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div id="item-list">
                            @foreach($invoice_items as $invoice_item)
                                <div id="{{$invoice_item->id}}" class="item">
                                    <input type="hidden" class="invoice_item_id" name="invoice_item_id[]"
                                           value="{{$invoice_item->id}}"/>

                                    <div class="row">
                                        <div class="form-group mb-1 col-sm-12 col-md-3">
                                            <label for="item_name">{{trans('file.Item')}}</label>
                                            <br>
                                            <input type="text" required class="form-control item_name"
                                                   name="item_name[]" placeholder="{{trans('file.Item')}}"
                                                   value="{{$invoice_item->item_name}}">
                                        </div>
                                        <div class="form-group mb-1 col-sm-12 col-md-1">
                                            <label for="qty_hrs" class="cursor-pointer">{{trans('file.Qty')}}</label>
                                            <br>
                                            <input type="number" required class="form-control qty_hrs calc"
                                                   name="qty_hrs[]" value="{{$invoice_item->item_qty}}" min="1">
                                        </div>

                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                            <label for="unit_price">{{__('Unit Price')}}</label>
                                            <br>
                                            <input required class="form-control unit_price calc"
                                                   name="unit_price[]" value="{{$invoice_item->item_unit_price}}"/>
                                        </div>


                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                            <label for="tax_type">{{__('Tax Type')}}</label>
                                            <br>
                                            <select name="tax_type_id[]" required class="form-control tax_type"
                                                    data-live-search="true" data-live-search-style="contains"
                                                    title='{{__('Tax Type')}}'>
                                                <option value="">{{__('Tax Type')}}</option>
                                                @foreach($tax_types as $tax_type)
                                                    @if($tax_type->type == 'fixed')
                                                        <option value="${{$tax_type->rate}}" {{ ($invoice_item->item_tax_type == '$'.$tax_type->rate) ? "selected" : '' }}>{{$tax_type->name}}
                                                            (${{$tax_type->rate}})
                                                        </option>
                                                    @else
                                                        <option value="{{$tax_type->rate}}" {{ ($invoice_item->item_tax_type == $tax_type->rate) ? "selected" : '' }}>{{$tax_type->name}}
                                                            ({{$tax_type->rate}}%)
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-1 col-sm-12 col-md-1">
                                            <label for="tax_type">{{trans('file.Tax')}}</label>
                                            <br>
                                            <input type="text" class="form-control tax_amount" name="tax_amount[]"
                                                   value="{{$invoice_item->item_tax_rate}}" readonly="readonly"/>
                                        </div>
                                        <div class="form-group mb-1 col-sm-12 col-md-2">
                                            <label for="profession">{{__('Sub Total')}}</label>
                                            <input type="text" class="form-control sub-total-item" readonly="readonly"
                                                   name="sub_total_item[]" value="{{$invoice_item->item_sub_total}}"/>
                                            <!-- <br>-->
                                            <p class="form-control-static d-none"><span
                                                        class="amount-html">0</span></p>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="form-group overflow-hidden1">
                            <div class="col-xs-12">
                                <button type="button" data-repeater-edit="" class="btn btn-primary"
                                        id="add-invoice-item"><i class="fa fa-plus"></i> {{__('Add Item')}}
                                </button>
                            </div>
                        </div>
                        <input type="hidden" class="items-sub-total" name="items_sub_total" value="0"/>
                        <input type="hidden" class="items-tax-total" name="items_tax_total" value="0"/>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-xs-center text-md-left">&nbsp;</div>
                            <div class="col-md-5 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>{{__('Sub Total')}}</td>
                                            <td class="text-xs-right">$ <span id="sub_total"
                                                                              class="sub_total">{{$invoice->sub_total}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{trans('file.TAX')}}</td>
                                            <td class="text-xs-right">$ <span id="total_tax"
                                                                              class="total_tax">{{$invoice->total_tax}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <strong>{{__('Discount Type')}}</strong></td>
                                                        <td>
                                                            <strong>{{trans('file.Discount')}}</strong></td>
                                                        <td>
                                                            <strong>{{__('Discount Amount')}}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="hidden" name="discount_type_hidden"
                                                                       value="{{ $invoice->discount_type }}"/>
                                                                <select name="discount_type"
                                                                        class="form-control discount_type">
                                                                    <option value="0"> {{trans('file.Flat')}}</option>
                                                                    <option value="1"> {{trans('file.Percent')}}</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text"
                                                                       name="discount_figure"
                                                                       class="form-control discount_figure text-right"
                                                                       value="{{ $invoice->discount_figure }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" readonly=""
                                                                       name="discount_amount"
                                                                       value="{{ $invoice->total_discount }}"
                                                                       class="discount_amount form-control text-right">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <input type="hidden" class="grand_total" id="grand_total_form"
                                               name="grand_total" value="0"/>
                                        <tr>
                                            <td>{{__('Grand Total')}}</td>
                                            <td class="text-xs-right">$ <span id="grand_total"
                                                                              class="grand_total">{{ $invoice->grand_total }}</span>
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 mb-2 file-repeaters"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="invoice_note">{{__('Invoice Note')}}</label>
                                <textarea name="invoice_note"
                                          class="form-control">{{ $invoice->invoice_note }}</textarea>
                            </div>
                        </div>

                        <div id="invoice-footer">
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
                                    <p>&nbsp;</p>
                                </div>
                                <div class="col-md-5 col-sm-12 text-xs-center">
                                    <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1 mr-3"><i
                                                class="fa fa fa-check-square-o"></i>{{__('Submit Invoice')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";
        let date = $('.date');
        date.datepicker({
            format: '{{ env('Date_Format_JS')}}',
            autoclose: true,
            todayHighlight: true
        });

        $('select[name="discount_type"]').val($('input[name="discount_type_hidden"]').val());


        $(document).on('click', '#add-invoice-item', function () {

            var item_id = parseInt($('#item-list .item:last').attr('id')) + 99999;

            $('#item-list').append('<div id="' + item_id + '" class="item"> <input type="hidden" class="invoice_item_id" name="invoice_item_id[]" value="' + item_id + '"><div class="row"><div class="form-group mb-1 col-sm-12 col-md-3"><label for="item_name">{{trans('file.Item')}}</label><br><input type="text" required class="form-control item_name" name="item_name[]" id="item_name" placeholder="{{trans('Item')}}"></div><div class="form-group mb-1 col-sm-12 col-md-1"><label for="qty_hrs" required class="cursor-pointer">{{trans('file.Qty')}}</label><br><input type="number" required class="form-control qty_hrs calc" name="qty_hrs[]" value="1"></div><div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2"><label for="unit_price">{{__('Unit Price')}}</label><br><input required class="form-control unit_price calc" type="number" name="unit_price[]" value="0" /></div><div  class="form-group mb-1 col-sm-12 col-md-2"><label for="tax_type">{{__('Tax Type')}}</label><br><select name="tax_type_id[]" required class="tax-types form-control tax_type" data-live-search="true" data-live-search-style="contains" title="{{__('Tax Type')}}"><option value="">{{__('Tax Type')}}</option> </select></div><div class="form-group mb-1 col-sm-12 col-md-1"><label for="tax_type">{{trans('file.Tax')}}</label><br><input type="text" class="form-control tax_amount" name="tax_amount[]" value="0"  readonly="readonly" /></div><div class="form-group mb-1 col-sm-12 col-md-2"><label for="profession">{{__('Sub Total')}}</label><input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" /><p class="form-control-static d-none"><span class="amount-html">0</span></p></div><div class="form-group col-sm-12 col-md-1 text-xs-center mt-2"><label for="profession">&nbsp;</label><br><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button></div></div></div>');

            var tax_type = <?php echo json_encode($tax_types) ?>;


            tax_type.forEach(function (v) {
                if (v.type == 'fixed') {
                    $('#item-list #' + item_id + ' .tax-types').append("<option value='$" + v.rate + "'>" + v.name + " ($" + v.rate + ")</option>");

                } else {
                    $('#item-list #' + item_id + ' .tax-types').append("<option value='" + v.rate + "'>" + v.name + " (" + v.rate + "%)</option>");
                }
            });
        });


        $(document).on('click', '.remove-invoice-item', function () {
            let item_id = $(this).parent().parent().parent().attr('id');
            let rmv_sub_total = Number($('#' + item_id + ' .sub-total-item').val());
            let all_total = Number($('#sub_total').text());
            let new_sub_total = all_total - rmv_sub_total;
            let all_tax = Number($('#total_tax').text());
            let rmv_tax = Number($('#' + item_id + ' .tax_amount').val());
            let new_tax = all_tax - rmv_tax;
            $('#sub_total').html(new_sub_total);
            $('#total_tax').html(new_tax);
            $('#grand_total').html(new_sub_total);
            calc_discount();
            $('#' + item_id).remove();
        });

        $(document).on('keyup', '.calc', function () {

            var k = $(this).parent().parent().parent().attr('id');
            var qty = $('#' + k + ' .qty_hrs').val();
            var unit_price = $('#' + k + ' .unit_price').val();
            var tax_rate = $('#' + k + ' .tax_type').val();
            if ($(this).val() !== '') {
                if (tax_rate !== '') {
                    if (tax_rate.indexOf("$") >= 0) {
                        tax_rate = Number(tax_rate.substr(1));

                        var sub_total = ((qty * unit_price) + tax_rate);

                        $('#' + k + ' .sub-total-item').val(sub_total);

                        var tax_amount = tax_rate;

                        $('#' + k + ' .tax_amount').val(tax_amount);
                    } else {
                        var sub_total = ((qty * unit_price) + (((qty * unit_price) * tax_rate) / 100));

                        $('#' + k + ' .sub-total-item').val(sub_total);

                        var tax_amount = (((qty * unit_price) * tax_rate) / 100);

                        $('#' + k + ' .tax_amount').val(tax_amount);
                    }
                } else {
                    var sub_total = (qty * unit_price);

                    $('#' + k + ' .sub-total-item').val(sub_total);
                }
            }

            var sum = 0;
            $('.sub-total-item').each(function () {
                sum += Number($(this).val());
            });

            $('#sub_total').html(sum);

            var total_tax = 0;
            $('.tax_amount').each(function () {
                total_tax += Number($(this).val());
            });

            $('#total_tax').html(total_tax);
        });

        $(document).on('change', '.tax_type', function () {
            var k = $(this).parent().parent().parent().attr('id');
            var qty = $('#' + k + ' .qty_hrs').val();
            var unit_price = $('#' + k + ' .unit_price').val();
            var tax_rate = $('#' + k + ' .tax_type').val();

            if ($(this).val() !== '') {
                if (tax_rate.indexOf("$") >= 0) {
                    tax_rate = Number(tax_rate.substr(1));

                    var sub_total = ((qty * unit_price) + tax_rate);

                    $('#' + k + ' .sub-total-item').val(sub_total);

                    var tax_amount = tax_rate;

                    $('#' + k + ' .tax_amount').val(tax_amount);

                } else {
                    var sub_total = ((qty * unit_price) + (((qty * unit_price) * tax_rate) / 100));

                    $('#' + k + ' .sub-total-item').val(sub_total);

                    var tax_amount = (((qty * unit_price) * tax_rate) / 100);

                    $('#' + k + ' .tax_amount').val(tax_amount);
                }
            }

            var sum = 0;
            $('.sub-total-item').each(function () {
                sum += Number($(this).val());
            });

            $('#sub_total').html(sum);

            var total_tax = 0;
            $('.tax_amount').each(function () {
                total_tax += Number($(this).val());
            });

            $('#total_tax').html(total_tax);
        });

        $(document).on('keyup', '.discount_figure', function () {
            calc_discount();
        });

        function calc_discount() {
            var discount_type = $('.discount_type').val();
            var discount_figure = $('.discount_figure').val();

            if (discount_type == '0') {
                $('.discount_amount').val(discount_figure);
            } else {
                var total = Number($('#sub_total').text());

                discount_figure = ((total * discount_figure) / 100);
                $('.discount_amount').val(discount_figure);
            }
        }

        $(document).on('change', '.discount_type', function () {
            var total = Number($('#sub_total').text());
            $('.discount_figure').val(0);
            $('.discount_amount').val(0);
            $('#grand_total').html(total);
        });

        //Calculate Grand Total
        $(document).on('change keyup', function () {
            var total = Number($('#sub_total').text());
            var discount_figure = $('.discount_figure').val();
            if ($('.discount_amount').val() == 0) {
                $('#grand_total').html(total);
            } else {
                if ($('.discount_type').val() == '0') {
                    var grand_total = (total - discount_figure);
                    $('#grand_total').html(grand_total);
                } else {
                    var grand_total = (total - ((total * discount_figure) / 100));
                    $('#grand_total').html(grand_total);
                }
            }
            calc_discount();
        });

        $('#edit_invoice').on('submit', function (event) {
            event.preventDefault();
            let sub_total = Number($('#sub_total').text());
            let total_tax = Number($('#total_tax').text());
            let grand_total = Number($('#grand_total').text());

            $('.items-sub-total').val(sub_total);
            $('.items-tax-total').val(total_tax);
            $('#grand_total_form').val(grand_total);

            $.ajax({
                url: "{{route('invoices.update',$invoice->id)}}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                        }, 2000);
                    }
                    $('#form_result').html(html).slideDown(100).delay(3000).slideUp(100);

                }
            });
        });

    })(jQuery);
</script>
@endpush
