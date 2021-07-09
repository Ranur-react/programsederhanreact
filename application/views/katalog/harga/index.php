<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped list_data">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
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
    $(document).ready(function() {
        table = $('.list_data').DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('harga/data') ?>",
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
                    "class": "text-left"
                },
                {
                    "class": "text-center"
                },
                {
                    "class": "text-center"
                }
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData[2] == '0') {
                    $('td', nRow).css('background-color', '#f2dede');
                }
            }
        });
    });

    function detail(kode) {
        $.ajax({
            url: "<?= site_url('harga/detail') ?>",
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
</script>