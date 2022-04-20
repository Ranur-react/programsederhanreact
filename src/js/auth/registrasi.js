function get_level() {
    var jenis = $("#jenis").val();
    $.ajax({
        type: "GET",
        url: BASE_URL + 'registrasi/signup-level',
        data: {
            jenis: jenis
        },
        success: function(data) {
            $("#level").html(data);
        }
    });
}

function get_gudang() {
    var jenis = $('#jenis').val();
    $.ajax({
        url: BASE_URL + 'registrasi/signup-gudang',
        method: "GET",
        data: {
            jenis: jenis
        },
        success: function(data) {
            $('#get_gudang').html(data);
        }
    });
}

$(document).ready(function() {
    $('#form_signup').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#btn_signup').button('loading');
            },
            success: function(resp) {
                resetToken(resp.token);
                if (resp.status == "0100") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses Registrasi',
                        html: resp.msg,
                    }).then(okay => {
                        if (okay) {
                            window.location.href = BASE_URL + 'login';
                        }
                    });
                } else {
                    $.each(resp.pesan, function(key, value) {
                        var element = $('#' + key);
                        element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.help-block')
                            .remove();
                        element.after(value);
                    });
                }
            },
            complete: function() {
                $('#btn_signup').button('reset');
            }
        })
    });
});