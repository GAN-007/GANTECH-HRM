
$('#document_type-table').DataTable().clear().destroy();

var table_table = $('#document_type-table').DataTable({
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
url: "{{ route('document_type.index') }}",

},


columns: [
{
data: 'document_type',
name: 'document_type',
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

$('#document_type_submit').on('click', function(event) {
event.preventDefault();
let document_type = $('input[name="document_type"]').val();

$.ajax({
url: "{{ route('document_type.store') }}",
method: "POST",
data: { document_type:document_type},
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
$('#document_type_form')[0].reset();
$('#document_type-table').DataTable().ajax.reload();
}
$('.document_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.document_edit', function(){
var id = $(this).attr('id');
$('.document_result').html('');

var target = "{{ route('document_type.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#document_type_edit').val(html.data.document_type);

$('#hidden_document_id').val(html.data.id);
$('#DocumentEditModal').modal('show');
}
})

});

$('#document_type_edit_submit').on('click', function(event) {
event.preventDefault();
let document_type_edit = $('input[name="document_type_edit"]').val();
let hidden_document_id= $('#hidden_document_id').val();

$.ajax({
url: "{{ route('document_type.update') }}",
method: "POST",
data: { document_type_edit:document_type_edit,hidden_document_id:hidden_document_id},
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
$('#document_type_form_edit')[0].reset();
$('#document_type-table').DataTable().ajax.reload();
}
$('.document_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#DocumentEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.document_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('document_type.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#document_type-table').DataTable().ajax.reload();
}, 2000);
$('.document_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#document_close').on('click', function() {
$('#document_type_form')[0].reset();
$('#document_type-table').DataTable().ajax.reload();
});
