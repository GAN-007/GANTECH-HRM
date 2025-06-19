$('#job_category-table').DataTable().clear().destroy();

var table_table = $('#job_category-table').DataTable({
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
url: "{{ route('job_categories.index') }}",

},


columns: [
{
data: 'job_category',
name: 'job_category',
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

$('#job_category_submit').on('click', function(event) {
event.preventDefault();
let job_category = $('input[name="job_category"]').val();

$.ajax({
url: "{{ route('job_categories.store') }}",
method: "POST",
data: { job_category:job_category},
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
$('#job_category_form')[0].reset();
$('#job_category-table').DataTable().ajax.reload();
}
$('.job_category_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.job_category_edit', function(){
var id = $(this).attr('id');
$('.job_category_result').html('');

var target = "{{ route('job_categories.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){

$('#job_category_edit').val(html.data.job_category);

$('#hidden_job_category_id').val(html.data.id);
$('#JobCategoryEditModal').modal('show');
}
})

});

$('#job_category_edit_submit').on('click', function(event) {
event.preventDefault();
let job_category_edit = $('input[name="job_category_edit"]').val();
let hidden_job_category_id= $('#hidden_job_category_id').val();

$.ajax({
url: "{{ route('job_categories.update') }}",
method: "POST",
data: { job_category_edit:job_category_edit,hidden_job_category_id:hidden_job_category_id},
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
$('#job_category_form_edit')[0].reset();
$('#job_category-table').DataTable().ajax.reload();
}
$('.job_category_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#JobCategoryEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.job_category_delete', function() {

let delete_id = $(this).attr('id');
let target = "{{ route('job_categories.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#job_category-table').DataTable().ajax.reload();
}, 2000);
$('.job_category_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#job_category_close').on('click', function() {
$('#job_category_form')[0].reset();
$('#job_category-table').DataTable().ajax.reload();
});