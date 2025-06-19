$('#travel_method-table').DataTable().clear().destroy();

var table_table = $('#travel_method-table').DataTable({
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
url: "{{ route('travel_method.index') }}",

},


columns: [
{
data: 'arrangement_type',
name: 'arrangement_type',
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

$('#travel_method_submit').on('click', function(event) {
event.preventDefault();
let arrangement_type = $('input[name="arrangement_type"]').val();

$.ajax({
url: "{{ route('travel_method.store') }}",
method: "POST",
data: { arrangement_type:arrangement_type},
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
$('#travel_method_form')[0].reset();
$('#travel_method-table').DataTable().ajax.reload();
}
$('.travel_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.travel_edit', function(){
var id = $(this).attr('id');
$('.travel_result').html('');

var target = "{{ route('travel_method.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#arrangement_type_edit').val(html.data.arrangement_type);

$('#hidden_travel_id').val(html.data.id);
$('#TravelEditModal').modal('show');
}
})

});

$('#travel_method_edit_submit').on('click', function(event) {
event.preventDefault();
let arrangement_type_edit = $('input[name="arrangement_type_edit"]').val();
let hidden_travel_id= $('#hidden_travel_id').val();

$.ajax({
url: "{{ route('travel_method.update') }}",
method: "POST",
data: { arrangement_type_edit:arrangement_type_edit,hidden_travel_id:hidden_travel_id},
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
$('#travel_method_form_edit')[0].reset();
$('#travel_method-table').DataTable().ajax.reload();
}
$('.travel_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#TravelEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.travel_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('travel_method.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#travel_method-table').DataTable().ajax.reload();
}, 2000);
$('.travel_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#travel_close').on('click', function() {
$('#travel_method_form')[0].reset();
$('#travel_method-table').DataTable().ajax.reload();
});