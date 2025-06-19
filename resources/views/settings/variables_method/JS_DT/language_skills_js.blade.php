$('#language_skill-table').DataTable().clear().destroy();

var table_table = $('#language_skill-table').DataTable({
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
url: "{{ route('language_skill.index') }}",

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

$('#language_skill_submit').on('click', function(event) {
event.preventDefault();
let language_skill_name = $('input[name="language_skill_name"]').val();

$.ajax({
url: "{{ route('language_skill.store') }}",
method: "POST",
data: { language_skill_name:language_skill_name},
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
$('#language_skill_form')[0].reset();
$('#language_skill-table').DataTable().ajax.reload();
}
$('.language_skill_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.language_skill_edit', function(){
var id = $(this).attr('id');
$('.language_skill_result').html('');

var target = "{{ route('language_skill.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#language_skill_name_edit').val(html.data.name);

$('#hidden_language_skill_id').val(html.data.id);
$('#LanguageSkillEditModal').modal('show');
}
})

});

$('#language_skill_edit_submit').on('click', function(event) {
event.preventDefault();
let language_skill_name_edit = $('input[name="language_skill_name_edit"]').val();
let hidden_language_skill_id= $('#hidden_language_skill_id').val();

$.ajax({
url: "{{ route('language_skill.update') }}",
method: "POST",
data: { language_skill_name_edit:language_skill_name_edit,hidden_language_skill_id:hidden_language_skill_id},
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
$('#language_skill_form_edit')[0].reset();
$('#language_skill-table').DataTable().ajax.reload();
}
$('.language_skill_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#LanguageSkillEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.language_skill_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('language_skill.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#language_skill-table').DataTable().ajax.reload();
}, 2000);
$('.language_skill_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#language_skill_close').on('click', function() {
$('#language_skill_form')[0].reset();
$('#language_skill-table').DataTable().ajax.reload();
});