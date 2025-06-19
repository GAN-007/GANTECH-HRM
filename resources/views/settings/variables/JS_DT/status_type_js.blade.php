$('#status_type-table').DataTable().clear().destroy();


var table_table = $('#status_type-table').DataTable({
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
url: "{{ route('status_type.index') }}",

},


columns: [
{
data: 'status_title',
name: 'status_title',
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

$('#status_type_submit').on('click', function(event) {
event.preventDefault();
let status_title = $('input[name="status_title"]').val();

$.ajax({
url: "{{ route('status_type.store') }}",
method: "POST",
data: { status_title:status_title},
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
$('#status_type_form')[0].reset();
$('#status_type-table').DataTable().ajax.reload();
}
$('.status_result').html(html).slideDown(300).delay(5000).slideUp(300);
}
});

});

$(document).on('click', '.status_edit', function(){
var id = $(this).attr('id');
$('.status_result').html('');

var target = "{{ route('status_type.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#status_title_edit').val(html.data.status_title);

$('#hidden_status_id').val(html.data.id);
$('#StatusEditModal').modal('show');
}
})

});

$('#status_type_edit_submit').on('click', function(event) {
event.preventDefault();
let status_title_edit = $('input[name="status_title_edit"]').val();
let hidden_status_id= $('#hidden_status_id').val();

$.ajax({
url: "{{ route('status_type.update') }}",
method: "POST",
data: { status_title_edit:status_title_edit,hidden_status_id:hidden_status_id},
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
$('#status_type_form_edit')[0].reset();
$('#status_type-table').DataTable().ajax.reload();
}
$('.status_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#StatusEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.status_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('status_type.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#status_type-table').DataTable().ajax.reload();
}, 2000);
$('.status_result').html(html).slideDown(300).delay(3000).slideUp(300);
}
})
}

});

$('#status_close').on('click', function() {
$('#status_type_form')[0].reset();
$('#status_type-table').DataTable().ajax.reload();
});