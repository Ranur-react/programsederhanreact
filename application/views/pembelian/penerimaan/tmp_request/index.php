<style>
    .modal {
        padding: 10px !important;
    }

    .modal .modal-dialog {
        width: 100%;
        max-width: none;
        margin: 0;
    }

    .modal .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }
</style>
<div class="modal fade" id="modal-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Permintaan Produk</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped data-tabel">
                    <thead>
                        <tr>
                            <th class="text-center" width="40px">No.</th>
                            <th>No. Permintaan</th>
                            <th>Tanggal</th>
                            <th class="text-right">Total</th>
                            <th>User</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="70px">#</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        table = $('.data-tabel').DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": BASE_URL + "penerimaan/tmp-permintaan/data",
                "type": "GET"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }],
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
                    "class": "text-right"
                },
                {
                    "class": "text-left"
                },
                {
                    "class": "text-center"
                },
                {
                    "class": "text-center"
                }
            ]
        });
    });
</script>