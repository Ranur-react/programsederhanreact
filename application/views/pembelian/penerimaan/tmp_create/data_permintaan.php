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
<div class="modal fade" id="modal_data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Permintaan Barang</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped data_permintaan" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="40px">No.</th>
                            <th>No. Permintaan</th>
                            <th>Supplier</th>
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