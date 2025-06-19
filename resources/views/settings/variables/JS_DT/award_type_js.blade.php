$('#award_type-table').DataTable().clear().destroy();

var table_table = $('#award_type-table').DataTable({
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
url: "{{ route('award_type.index') }}",

},


columns: [
{
data: 'award_name',
name: 'award_name',
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

$('#award_type_submit').on('click', function(event) {
event.preventDefault();
let award_name = $('input[name="award_name"]').val();

$.ajax({
url: "{{ route('award_type.store') }}",
method: "POST",
data: { award_name:award_name},
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
$('#award_type_form')[0].reset();
$('#award_type-table').DataTable().ajax.reload();
}
$('.award_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.award_edit', function(){
var id = $(this).attr('id');
$('.award_result').html('');

var target = "{{ route('award_type.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#award_name_edit').val(html.data.award_name);

$('#hidden_award_id').val(html.data.id);
$('#AwardEditModal').modal('show');
}
})

});

$('#award_type_edit_submit').on('click', function(event) {
event.preventDefault();
let award_name_edit = $('input[name="award_name_edit"]').val();
let hidden_award_id= $('#hidden_award_id').val();

$.ajax({
url: "{{ route('award_type.update') }}",
method: "POST",
data: { award_name_edit:award_name_edit,hidden_award_id:hidden_award_id},
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
$('#award_type_form_edit')[0].reset();
$('#award_type-table').DataTable().ajax.reload();
}
$('.award_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#AwardEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.award_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('award_type.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#award_type-table').DataTable().ajax.reload();
}, 2000);
$('.award_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#award_close').on('click', function() {
$('#award_type_form')[0].reset();
$('#award_type-table').DataTable().ajax.reload();
});