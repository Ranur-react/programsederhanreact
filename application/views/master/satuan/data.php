<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <button class="btn btn-social btn-flat btn-success btn-sm" onclick="tambah()"><i class="icon-plus3"></i> Tambah <?= $title ?></button>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="data-tabel">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Singkatan</th>
                        <!-- <th>Telepon</th> -->
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data as $d) { ?>
                        <tr>
                            <td class="text-center" width="40px"><?= $no . '.'; ?></td>
                            <td><?= $d['nama_satuan'] ?></td>
                            <td><?= $d['singkatan_satuan'] ?></td>
                           
                            <td class="text-center" width="60px">
                                <a href="javascript:void(0)" onclick="edit('<?= $d['id_satuan'] ?>')">
                                    <i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="hapus('<?= $d['id_satuan'] ?>')">
                                    <i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    function tambah() {
        $.ajax({
            url: "<?= site_url('satuan/create') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    function edit(kode) {
        $.ajax({
            url: "<?= site_url('satuan/edit') ?>",
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

    function hapus(kode) {
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
                    url: "<?= site_url('satuan/destroy') ?>",
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