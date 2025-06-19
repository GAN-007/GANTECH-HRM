$('#expense_type-table').DataTable().clear().destroy();

var table_table = $('#expense_type-table').DataTable({
initComplete: function () {
    this.api().columns([2]).every(function () {
        var column = this;
        var select = $('<select><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                column
                    .search(val ? '^' + val + '$' : '', true, false)
                    .draw();
            });

        column.data().unique().sort().each(function (d, j) {
            select.append('<option value="' + d + '">' + d + '</option>');
            $('select').selectpicker('refresh');
        });
    });
},
responsive: true,
fixedHeader: {
header: true,
footer: true
},
processing: true,
serverSide: true,
ajax: {
url: "{{ route('expense_type.index') }}",

},


columns: [

{
data: 'company',
name: 'company',
},
{
data: 'type',
name: 'type',
},
{
data: 'action',
name: 'action',
orderable: false
}
],


"order": [],
'language': {
'lengthMenu': '_MENU_ {{__("records per page")}}',
"info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
"search": '{{trans("file.Search")}}',
'paginate': {
'previous': '{{trans("file.Previous")}}',
'next': '{{trans("file.Next")}}'
}
},
'columnDefs': [
{
"orderable": false,
'targets': [0, 1],
},

],


'select': {style: 'multi', selector: 'td:first-child'},
'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],

});
new $.fn.dataTable.FixedHeader(table_table);

$('#expense_type_submit').on('click', function(event) {
event.preventDefault();
let expense_type = $('input[name="expense_type"]').val();
let company_id = $('#company_id').val();

$.ajax({
url: "{{ route('expense_type.store') }}",
method: "POST",
data: { expense_type:expense_type,company_id:company_id},
success: function (data) {
var html = '';
if (data.errors) {
html = '<div class="alert alert-danger">';
    for (var count = 0; count < data.errors.length; count++) {
    html += '<p>' + data.errors[count] + '</p>';
    }
    html += '</div>';
}
if (data.success) {
html = '<div class="alert alert-success">' + data.success + '</div>';
$('#expense_type_form')[0].reset();
$('#expense_type-table').DataTable().ajax.reload();
}
$('.expense_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.expense_edit', function(){
var id = $(this).attr('id');
$('.expense_result').html('');

var target = "{{ route('expense_type.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#expense_type_edit').val(html.data.type);
$('#company_id_edit').parent().find('.filter-option').html(html.company_name);

$('#hidden_expense_id').val(html.data.id);
$('#ExpenseEditModal').modal('show');
}
})

});

$('#expense_type_edit_submit').on('click', function(event) {
event.preventDefault();
let expense_type_edit = $('input[name="expense_type_edit"]').val();
let company_id_edit = $('#company_id_edit').val();
let hidden_expense_id= $('#hidden_expense_id').val();

$.ajax({
url: "{{ route('expense_type.update') }}",
method: "POST",
data: { expense_type_edit:expense_type_edit,company_id_edit:company_id_edit,hidden_expense_id:hidden_expense_id},
success: function (data) {
var html = '';
if (data.errors) {
html = '<div class="alert alert-danger">';
    for (var count = 0; count < data.errors.length; count++) {
    html += '<p>' + data.errors[count] + '</p>';
    }
    html += '</div>';
}
if (data.success) {
html = '<div class="alert alert-success">' + data.success + '</div>';
$('#expense_type_form_edit')[0].reset();
$('#expense_type-table').DataTable().ajax.reload();
}
$('.expense_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#ExpenseEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.expense_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('expense_type.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#expense_type-table').DataTable().ajax.reload();
}, 2000);
$('.expense_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#expense_close').on('click', function() {
$('#expense_type_form')[0].reset();
$('#expense_type-table').DataTable().ajax.reload();
});