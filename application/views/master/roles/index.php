<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <button class="btn btn-social btn-flat btn-success btn-sm" title="Tambah Data" onclick="create()"><i class="icon-plus3"></i> Tambah <?= $title ?></button>
        </div>
        <div class="box-body no-padding table-responsive">
            <table class="table-style table text-nowrap">
                <tbody>
                    <?php foreach ($data as $d) { ?>
                        <tr>
                            <td class="text-center" width="100px">
                                <a href="javascript:void(0)" onclick="edit('<?= $d['id_role'] ?>')"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>
                                <a href="javascript:void(0)" onclick="destroy('<?= $d['id_role'] ?>')"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>
                            </td>
                            <td>
                                <?= $d['nama_role'] ?>
                                <div class="text-muted text-size-small">
                                    <span class="status-mark <?= $d['jenis_role'] == '1' ? 'border-success' : 'border-danger' ?> position-left"></span><?= $d['jenis_role'] == '1' ? 'Back Office' : 'Gudang' ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    function create() {
        $.ajax({
            url: "<?= site_url('roles/create') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    function edit(kode) {
        $.ajax({
            url: "<?= site_url('roles/edit') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    function destroy(kode) {
        Swal({
            title: "Apakah kamu yakin?",
            text: "Anda tidak akan dapat mengembalikan ini!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya, hapus data ini"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: "<?= site_url('roles/destroy') ?>",
                    data: {
                        kode: kode
                    },
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status == "0100") {
                            Swal.fire({
                                title: 'Deleted!',
                                text: resp.message,
                                type: 'success'
                            }).then((resp) => {
                                location.reload();
                            })
                        } else {
                            Swal.fire('Oops...', resp.message, 'error');
                        }
                    }
                });
            }
        })
    }

    $(document).on('submit', '.form_create', function(e) {
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $('.store_data').button('loading');
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    localStorage.setItem("swal", swal({
                        title: "Sukses!",
                        text: resp.pesan,
                        type: "success",
                    }).then(function() {
                        location.reload();
                    }));
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
                $('.store_data').button('reset');
            }
        });
        return false;
    });
</script>