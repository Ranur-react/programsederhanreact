<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data_kirim">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Metode Bayar</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Status Bayar</th>
                        <th class="text-center">Status Order</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="tampil-modal"></div>
<script>
    $(".data_kirim").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('pengiriman/data') ?>",
            type: 'GET',
        },
        "columns": [{
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
            }
        ]
    });

    function detail(kode) {
        $.ajax({
            url: "<?= site_url('pesanan/detail') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil-modal").html(resp);
                $("#modal_alert").modal('show');
            }
        });
    }

    function create(kode) {
        $.ajax({
            url: "<?= site_url('pengiriman/create') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil-modal").html(resp);
                $("#modal_alert").modal('show');
            }
        });
    }

    function store(kode) {
        $.ajax({
            url: "<?= site_url('pengiriman/store') ?>",
            type: "GET",
            dataType: 'json',
            data: {
                kode: kode
            },
            beforeSend: function() {
                $('#store').button('loading');
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    Swal.fire({
                        title: 'Sukses!',
                        text: resp.pesan,
                        type: 'success'
                    }).then(okay => {
                        if (okay) {
                            $("#modal_alert").modal('hide');
                            var DataTabel = $('.data_kirim').DataTable();
                            DataTabel.ajax.reload();
                        }
                    });
                }
            },
            complete: function() {
                $('#store').button('reset');
            }
        });
    }

    function terima(kode) {
        $.ajax({
            url: "<?= site_url('pengiriman/terima') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil-modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    $(document).on('submit', '.form_create', function(e) {
        event.preventDefault();
        var formData = new FormData($(".form_create")[0]);
        $.ajax({
            url: $(".form_create").attr('action'),
            dataType: 'json',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.store_data').button('loading');
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    Swal.fire({
                        title: 'Sukses!',
                        text: resp.message,
                        type: 'success'
                    }).then(okay => {
                        if (okay) {
                            $("#modal_create").modal('hide');
                            var DataTabel = $('.data_kirim').DataTable();
                            DataTabel.ajax.reload();
                        }
                    });
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
        })
    });
</script>