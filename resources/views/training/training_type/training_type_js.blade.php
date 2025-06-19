$('#training_type-table').DataTable().clear().destroy();

var table_table = $('#training_type-table').DataTable({
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
url: "{{ route('training_type.index') }}",

},


columns: [
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

$('#training_type_submit').on('click', function(event) {
event.preventDefault();
let type = $('input[name="type"]').val();

$.ajax({
url: "{{ route('training_type.store') }}",
method: "POST",
data: { type:type},
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
$('#training_type_form')[0].reset();
$('#training_type-table').DataTable().ajax.reload();
}
$('.training_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.training_edit', function(){
var id = $(this).attr('id');
$('.training_result').html('');

var target = "{{ route('training_type.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#type_edit').val(html.data.type);

$('#hidden_training_id').val(html.data.id);
$('#TrainingEditModal').modal('show');
}
})

});

$('#training_type_edit_submit').on('click', function(event) {
event.preventDefault();
let type_edit = $('input[name="type_edit"]').val();
let hidden_training_id= $('#hidden_training_id').val();

$.ajax({
url: "{{ route('training_type.update') }}",
method: "POST",
data: { type_edit:type_edit,hidden_training_id:hidden_training_id},
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
$('#training_type_form_edit')[0].reset();
$('#training_type-table').DataTable().ajax.reload();
}
$('.training_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#TrainingEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.training_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('training_type.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#training_type-table').DataTable().ajax.reload();
}, 2000);
$('.training_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#training_close').on('click', function() {
$('#training_type_form')[0].reset();
$('#training_type-table').DataTable().ajax.reload();
});
