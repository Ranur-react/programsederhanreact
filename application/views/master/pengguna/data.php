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
                            <td width="120px">
                                <span class="label status <?= $d['status_user'] == 1 ? 'status-active' : 'status-pending' ?>"><?= $d['status_user'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></span>
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
</script>