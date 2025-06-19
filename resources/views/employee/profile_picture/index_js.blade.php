    $('#profile_sample_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "{{ route('profile_picture.store',$employee) }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
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
                    if (data.profile_picture) {
                        $('#employee_profile_photo').html("<img src={{ URL::to('/public') }}/uploads/profile_photos/" + data.profile_picture + " width='100' height='100' class='img-thumbnail' />");
                        $('#employee_profile_photo').append("<input type='hidden'  name='hidden_image' value='" + data.profile_picture + "'  />");
                    }
                    $('#profile_sample_form')[0].reset();
                    $('#profile_sample_form')[0].reset();
                }
                $('#profile_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            }

        });
    });

