$('#warning_type-table').DataTable().clear().destroy();

var table_table = $('#warning_type-table').DataTable({
initComplete: function () {
    this.api().columns([1]).every(function () {
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
url: "{{ route('warning_type.index') }}",

},


columns: [
{
data: 'warning_title',
name: 'warning_title',
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

$('#warning_type_submit').on('click', function(event) {
event.preventDefault();
let warning_title = $('input[name="warning_title"]').val();

$.ajax({
url: "{{ route('warning_type.store') }}",
method: "POST",
data: { warning_title:warning_title},
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
$('#warning_type_form')[0].reset();
$('#warning_type-table').DataTable().ajax.reload();
}
$('.warning_result').html(html).slideDown(300).delay(5000).slideUp(300);
}
});

});

$(document).on('click', '.warning_edit', function(){
var id = $(this).attr('id');
$('.warning_result').html('');

var target = "{{ route('warning_type.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#warning_title_edit').val(html.data.warning_title);

$('#hidden_warning_id').val(html.data.id);
$('#WarningEditModal').modal('show');
}
})

});

$('#warning_type_edit_submit').on('click', function(event) {
event.preventDefault();
let warning_title_edit = $('input[name="warning_title_edit"]').val();
let hidden_warning_id= $('#hidden_warning_id').val();

$.ajax({
url: "{{ route('warning_type.update') }}",
method: "POST",
data: { warning_title_edit:warning_title_edit,hidden_warning_id:hidden_warning_id},
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
$('#warning_type_form_edit')[0].reset();
$('#warning_type-table').DataTable().ajax.reload();
}
$('.warning_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#WarningEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.warning_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('warning_type.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#warning_type-table').DataTable().ajax.reload();
}, 2000);
$('.warning_result').html(html).slideDown(300).delay(3000).slideUp(300);
}
})
}
});

$('#warning_close').on('click', function() {
$('#warning_type_form')[0].reset();
$('#warning_type-table').DataTable().ajax.reload();
});