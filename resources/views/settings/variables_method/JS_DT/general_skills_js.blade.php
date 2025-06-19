$('#general_skill-table').DataTable().clear().destroy();

var table_table = $('#general_skill-table').DataTable({
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
url: "{{ route('general_skill.index') }}",

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

$('#general_skill_submit').on('click', function(event) {
event.preventDefault();
let general_skill_name = $('input[name="general_skill_name"]').val();

$.ajax({
url: "{{ route('general_skill.store') }}",
method: "POST",
data: { general_skill_name:general_skill_name},
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
$('#general_skill_form')[0].reset();
$('#general_skill-table').DataTable().ajax.reload();
}
$('.general_skill_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.general_skill_edit', function(){
var id = $(this).attr('id');
$('.general_skill_result').html('');

var target = "{{ route('general_skill.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#general_skill_name_edit').val(html.data.name);

$('#hidden_general_skill_id').val(html.data.id);
$('#GeneralSkillEditModal').modal('show');
}
})

});

$('#general_skill_edit_submit').on('click', function(event) {
event.preventDefault();
let general_skill_name_edit = $('input[name="general_skill_name_edit"]').val();
let hidden_general_skill_id= $('#hidden_general_skill_id').val();

$.ajax({
url: "{{ route('general_skill.update') }}",
method: "POST",
data: { general_skill_name_edit:general_skill_name_edit,hidden_general_skill_id:hidden_general_skill_id},
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
$('#general_skill_form_edit')[0].reset();
$('#general_skill-table').DataTable().ajax.reload();
}
$('.general_skill_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#GeneralSkillEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.general_skill_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('general_skill.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#general_skill-table').DataTable().ajax.reload();
}, 2000);
$('.general_skill_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#general_skill_close').on('click', function() {
$('#general_skill_form')[0].reset();
$('#general_skill-table').DataTable().ajax.reload();
});