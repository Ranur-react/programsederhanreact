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
                        <th>Username</th>
                        <th>Level</th>
                        <th class="text-center">API Key</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data as $d) {
                        $kode = $d['id_user'];
                        $jenis = $d['jenis_user'];
                        if ($jenis == 1) :
                            $tabel = 'user_office';
                            $gudang = '';
                        else :
                            $tabel = 'user_gudang';
                            $data_gudang = $this->db->from($tabel)->join('role', 'role_level=id_role')->join('gudang', 'gudang_level=id_gudang')->where('user_level', $kode)->get()->row_array();
                            $gudang = $data_gudang['nama_gudang'];
                        endif;
                        $level = $this->db->from($tabel)->join('role', 'role_level=id_role')->where('user_level', $kode)->get()->row_array();
                        $api = $this->db->where('user_api', $kode)->get('user_api')->row_array();
                    ?>
                        <tr>
                            <td class="text-center" width="40px"><?= $no . '.'; ?></td>
                            <td>
                                <?= $d['nama_user'] ?>
                                <div class="text-muted text-size-small">
                                    <span class="status-mark <?= $d['jenis_user'] == 1 ? 'border-success' : 'border-danger' ?> position-left"></span><?= $d['jenis_user'] == 1 ? 'Back Office' : 'Gudang' ?>
                                </div>
                            </td>
                            <td><?= $d['username'] ?></td>
                            <td>
                                <?= $level['nama_role'] ?>
                                <div class="text-muted text-size-small"><?= $gudang ?></div>
                            </td>
                            <td class="text-center">
                                <?php if ($api != null) { ?>
                                    <input type="hidden" value="<?= $api['key_api']; ?>" id="myInput">
                                    <a href="javascript:void(0)" onclick="myFunction()">
                                        <i class="icon-copy4 text-purple" title="Copy"></i>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= site_url('pengguna/generate-api/' . $kode) ?>">
                                        <i class="icon-plus-circle2 text-black" title="Tambah"></i>
                                    </a>
                                <?php } ?>
                            </td>
                            <td width="120px">
                                <a href="<?= site_url('pengguna/status-pengguna/' . $kode) ?>">
                                    <span class="label status <?= $d['status_user'] == 1 ? 'status-active' : 'status-pending' ?>"><?= $d['status_user'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></span>
                                </a>
                            </td>
                            <td class="text-center" width="60px">
                                <a href="javascript:void(0)" onclick="edit('<?= $kode ?>')">
                                    <i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="hapus('<?= $kode ?>')">
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
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();

        /* Copy the text inside the text field */
        document.execCommand("Copy");

        /* Alert the copied text */
        toastr.success("Copied!");
        // alert("Copied the text: " + copyText.value);
    }

    function tambah() {
        $.ajax({
            url: "<?= site_url('pengguna/create') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    function get_level() {
        var jenis = $("#jenis").val();
        $.ajax({
            type: "GET",
            url: "<?= site_url('master/pengguna/get_level') ?>",
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
            url: "<?= site_url('master/pengguna/get_gudang') ?>",
            method: "GET",
            data: {
                jenis: jenis
            },
            success: function(data) {
                $('#get_gudang').html(data);
            }
        });
    }

    function edit(kode) {
        $.ajax({
            url: "<?= site_url('pengguna/edit') ?>",
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
                    url: "<?= site_url('pengguna/destroy') ?>",
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