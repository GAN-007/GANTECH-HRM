$('#termination_type-table').DataTable().clear().destroy();


var table_table = $('#termination_type-table').DataTable({
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
url: "{{ route('termination_type.index') }}",

},


columns: [
{
data: 'termination_title',
name: 'termination_title',
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

$('#termination_type_submit').on('click', function(event) {
event.preventDefault();
let termination_title = $('input[name="termination_title"]').val();

$.ajax({
url: "{{ route('termination_type.store') }}",
method: "POST",
data: { termination_title:termination_title},
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
$('#termination_type_form')[0].reset();
$('#termination_type-table').DataTable().ajax.reload();
}
$('.termination_result').html(html).slideDown(300).delay(5000).slideUp(300);
}
});

});

$(document).on('click', '.termination_edit', function(){
var id = $(this).attr('id');
$('.termination_result').html('');

var target = "{{ route('termination_type.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#termination_title_edit').val(html.data.termination_title);

$('#hidden_termination_id').val(html.data.id);
$('#TerminationEditModal').modal('show');
}
})

});

$('#termination_type_edit_submit').on('click', function(event) {
event.preventDefault();
let termination_title_edit = $('input[name="termination_title_edit"]').val();
let hidden_termination_id= $('#hidden_termination_id').val();

$.ajax({
url: "{{ route('termination_type.update') }}",
method: "POST",
data: { termination_title_edit:termination_title_edit,hidden_termination_id:hidden_termination_id},
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
$('#termination_type_form_edit')[0].reset();
$('#termination_type-table').DataTable().ajax.reload();
}
$('.termination_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#TerminationEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.termination_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('termination_type.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#termination_type-table').DataTable().ajax.reload();
}, 2000);
$('.termination_result').html(html).slideDown(300).delay(3000).slideUp(300);
}
})
}

});

$('#termination_close').on('click', function() {
$('#termination_type_form')[0].reset();
$('#termination_type-table').DataTable().ajax.reload();
});