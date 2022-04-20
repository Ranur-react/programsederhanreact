$(document).ready(function() {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('#form_signin').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#btn_signin').button('loading');
            },
            success: function(data) {
                resetToken(data.token);
                if (data.status == "0101") {
                    if (data.username_error != '') {
                        $('#username_error').html(data.username_error);
                    } else {
                        $('#username_error').html('');
                    }
                    if (data.password_error != '') {
                        $('#password_error').html(data.password_error);
                    } else {
                        $('#password_error').html('');
                    }
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Anda berhasil login',
                    }).then(okay => {
                        if (okay) {
                            window.location.href = BASE_URL + 'welcome';
                        }
                    });
                }
                $('.btn_signin').button('reset');
            },
            complete: function() {
                $('#btn_signin').button('reset');
            }
        })
    });
});