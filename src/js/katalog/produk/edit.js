var kode = $('input[name=\'kode\']').val();

$(document).ready(function () {
    data_gambar();
    // Update no urut gambar
    $('tbody[id=\'bodygambar\']').sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui) {
            var page_id_array = new Array();
            $('tbody tr').each(function () {
                page_id_array.push($(this).attr('id'));
            });
            $.ajax({
                url: BASE_URL + "produk/data-gambar",
                method: "GET",
                data: {
                    page_id_array: page_id_array,
                    action: 'noupdate'
                },
                success: function () {
                    load_gambar();
                }
            })
        }
    });

    // Menampilkan slug sesuai nama produk
    $("#nama").keyup(function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
        $("#slug").val(Text);
    });
});

$(function () {
    $('.select2').select2()
});

// Tambah inputan deskripsi produk
var deskripsi_row = $('input[name=\'nomor\']').val();

function createDeksripsi() {
    html = '<tr id="deskripsi-row' + deskripsi_row + '">';
    html += '<td class="text-left"><input type="text" name="produk_desc[' + deskripsi_row + '][name]" value="" placeholder="Judul" class="form-control" /><input type="hidden" name="produk_desc[' + deskripsi_row + '][attribute_id]" value="' + deskripsi_row + '" /></td>';
    html += '<td class="text-left">';
    html += '<textarea name="produk_desc[' + deskripsi_row + '][produk_desc_desc][text]" rows="5" placeholder="Deskripsi" class="form-control"></textarea>';
    html += '</td>';
    html += '<td class="text-right"><button type="button" onclick="$(\'#deskripsi-row' + deskripsi_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';
    $('#deskripsi tbody').append(html);
    deskripsi_row++;
}

// Autocomplete kategori produk
$('input[name=\'kategori\']').autocomplete({
    'source': function (request, response) {
        $.ajax({
            url: BASE_URL + "kategori/kategori_by_nama",
            data: {
                filter_nama: request
            },
            dataType: 'json',
            success: function (json) {
                response($.map(json, function (item) {
                    return {
                        label: item['nama'],
                        value: item['id']
                    }
                }));
            }
        });
    },
    'select': function (item) {
        $('input[name=\'kategori\']').val('');
        $('#produk-kategori' + item['value']).remove();
        $('#produk-kategori').append('<div id="produk-kategori' + item['value'] + '"><i class="fa fa-minus-circle text-red"></i> ' + item['label'] + '<input type="hidden" name="produk_kategori[]" value="' + item['value'] + '" /></div>');
    }
});
// Hapus item kategori produk
$('#produk-kategori').delegate('.fa-minus-circle', 'click', function () {
    $(this).parent().remove();
});

// Autocomplete satuan produk
$('input[name=\'satuan\']').autocomplete({
    'source': function (request, response) {
        $.ajax({
            url: BASE_URL + "satuan/satuan_by_nama",
            data: {
                filter_nama: request
            },
            dataType: 'json',
            success: function (json) {
                response($.map(json, function (item) {
                    return {
                        label: item['nama'],
                        value: item['id']
                    }
                }));
            }
        });
    },
    'select': function (item) {
        $('input[name=\'satuan\']').val('');
        $('#produk-satuan' + item['value']).remove();
        $('#produk-satuan').append('<div id="produk-satuan' + item['value'] + '"><i class="fa fa-minus-circle text-red"></i> ' + item['label'] + '<input type="hidden" name="produk_satuan[]" value="' + item['value'] + '" /></div>');
    }
});
// Hapus item satuan produk
$('#produk-satuan').delegate('.fa-minus-circle', 'click', function () {
    $(this).parent().remove();
});

// Tampilkan gambar dari tmp
function data_gambar() {
    $.ajax({
        url: BASE_URL + "produk/data-gambar",
        method: "GET",
        data: {
            action: 'update',
            kode: kode
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            if (data == 0) {
                html += '<tr>';
                html += '<td colspan="8">Belum ada data</td>';
                html += '</tr>';
            } else {
                for (var count = 0; count < data.length; count++) {
                    html += '<tr id="' + data[count].id + '">';
                    html += '<td>' + data[count].satuan + '</td>';
                    html += '<td><img src="' + data[count].gambar + '" width="100" height="100" /></td>';
                    html += '<td class="text-center" width="100px">';
                    html += '<a class="text-red" href="javascript:void(0)" onclick="destroyGambar(' + data[count].id + ')"><i class="ace-icon icon-trash bigger-120"></i></a>';
                    html += '</td>';
                    html += '</tr>';
                }
            }
            $('tbody[id=\'bodygambar\']').html(html);
        }
    })
}

function createGambar() {
    var kode = $('input[name=\'kode\']').val();
    $.ajax({
        url: BASE_URL + "produk/create-gambar",
        type: "GET",
        data: {
            action: 'update',
            kode: kode
        },
        success: function (resp) {
            $("#tampil_modal").html(resp);
            $("#modal_create").modal('show');
        }
    });
}

function destroyGambar(kode) {
    $.ajax({
        url: BASE_URL + "produk/destroy-gambar",
        type: "GET",
        data: {
            action: 'update',
            kode: kode
        },
        success: function (resp) {
            data_gambar();
        }
    });
}

$(document).on('submit', '.form_create', function (e) {
    event.preventDefault();
    var formData = new FormData($(".form_create")[0]);
    $.ajax({
        url: $(".form_create").attr('action'),
        dataType: 'json',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('.store_data').button('loading');
        },
        success: function (resp) {
            resetToken(resp.token);
            if (resp.status == "0100") {
                $("#modal_create").modal('hide');
                data_gambar();
            } else {
                $("#pesan_gambar").html(resp.error);
                $.each(resp.pesan, function (key, value) {
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
        complete: function () {
            $('.store_data').button('reset');
        }
    })
});

$(document).ready(function () {
    $('#form_create').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            cache: false,
            beforeSend: function () {
                $('#store').button('loading');
            },
            success: function (resp) {
                resetToken(resp.token);
                if (resp.status == "0100") {
                    Swal.fire('Sukses', resp.msg, 'success',).then((resp) => {
                        window.location.href = BASE_URL + "produk";
                    });
                } else {
                    $.each(resp.pesan, function (key, value) {
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
            complete: function () {
                $('#store').button('reset');
            }
        })
    });
});