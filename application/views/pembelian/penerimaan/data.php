<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="<?= site_url('penerimaan/create') ?>" class="btn btn-social btn-flat btn-success btn-sm"><i class="icon-plus3"></i> Tambah <?= $title ?></a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped tabel_penerimaan" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>No. Terima</th>
                        <th>Supplier</th>
                        <th>Gudang</th>
                        <th>Tanggal</th>
                        <th class="text-right">Total</th>
                        <th>User</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    $(".tabel_penerimaan").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('penerimaan/data') ?>",
            type: 'GET',
        },
        "columns": [{
                "class": "text-center"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-right"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-center",
                "width": "100px"
            },
            {
                "class": "text-center",
                "width": "60px"
            }
        ]
    });

    function info(kode) {
        $.ajax({
            url: "<?= site_url('penerimaan/info') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_alert").modal('show');
            }
        });
    }

    function hapus(kode) {
        Swal({
            title: "Anda yakin?",
            text: "Anda tidak akan dapat mengembalikan data ini!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya, hapus data ini"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: "<?= site_url('penerimaan/destroy') ?>",
                    data: "&kode=" + kode,
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status == "0100") {
                            Swal.fire({
                                title: 'Deleted!',
                                text: resp.message,
                                type: 'success'
                            }).then((resp) => {
                                var DataTabel = $('.tabel_penerimaan').DataTable();
                                DataTabel.ajax.reload();
                            })
                        } else {
                            toastr.error(resp.message);
                        }
                    }
                });
            }
        })
    }
</script>