$('#education_level-table').DataTable().clear().destroy();

var table_table = $('#education_level-table').DataTable({
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
url: "{{ route('education_level.index') }}",

},


columns: [
{
data: 'name',
name: 'name',
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

$('#education_level_submit').on('click', function(event) {
event.preventDefault();
let education_level_name = $('input[name="education_level_name"]').val();

$.ajax({
url: "{{ route('education_level.store') }}",
method: "POST",
data: { education_level_name:education_level_name},
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
$('#education_level_form')[0].reset();
$('#education_level-table').DataTable().ajax.reload();
}
$('.education_level_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.education_level_edit', function(){
var id = $(this).attr('id');
$('.education_level_result').html('');

var target = "{{ route('education_level.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#education_level_name_edit').val(html.data.name);

$('#hidden_education_level_id').val(html.data.id);
$('#EducationLevelEditModal').modal('show');
}
})

});

$('#education_level_edit_submit').on('click', function(event) {
event.preventDefault();
let education_level_name_edit = $('input[name="education_level_name_edit"]').val();
let hidden_education_level_id= $('#hidden_education_level_id').val();

$.ajax({
url: "{{ route('education_level.update') }}",
method: "POST",
data: { education_level_name_edit:education_level_name_edit,hidden_education_level_id:hidden_education_level_id},
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
$('#education_level_form_edit')[0].reset();
$('#education_level-table').DataTable().ajax.reload();
}
$('.education_level_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#EducationLevelEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.education_level_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('education_level.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#education_level-table').DataTable().ajax.reload();
}, 2000);
$('.education_level_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#education_level_close').on('click', function() {
$('#education_level_form')[0].reset();
$('#education_level-table').DataTable().ajax.reload();
});