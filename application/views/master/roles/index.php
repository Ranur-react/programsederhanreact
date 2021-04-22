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
                                <a href="#"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>
                                <a href="#"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>
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
</script>