<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="<?= site_url('pesanan/create') ?>" class="btn btn-social btn-flat btn-success btn-sm"><i class="icon-plus3"></i> Tambah <?= $title ?></a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data_pesanan">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Metode Bayar</th>
                        <th class="text-right">Total</th>
                        <th>Konfirmasi</th>
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
    $(".data_pesanan").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('pesanan/data') ?>",
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

    function batal(kode) {
        Swal({
            title: "Perhatian!",
            text: "Apakah kamu yakin untuk batalkan pesanan ini?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Batalkan Pesanan"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: "<?= site_url('pesanan/batal') ?>",
                    data: {
                        kode: kode
                    },
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status == "0100") {
                            Swal.fire({
                                title: 'Pembatalan!',
                                text: resp.pesan,
                                type: 'success'
                            }).then((resp) => {
                                var DataTabel = $('.data_pesanan').DataTable();
                                DataTabel.ajax.reload();
                            })
                        } else {
                            Swal.fire('Oops...', resp.pesan, 'error');
                        }
                    }
                });
            }
        })
    }

    function confirm(kode) {
        $.ajax({
            url: "<?= site_url('pembayaran/confirm') ?>",
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

    function bayar(kode) {
        $.ajax({
            url: "<?= site_url('pembayaran/detail') ?>",
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

    function approve(kode) {
        $.ajax({
            url: "<?= site_url('pembayaran/approve') ?>",
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
                            var DataTabel = $('.data_pesanan').DataTable();
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

    function batalConfrim(kode) {
        $.ajax({
            url: "<?= site_url('pembayaran/batal') ?>",
            type: "GET",
            dataType: 'json',
            data: {
                kode: kode
            },
            beforeSend: function() {
                $('#batal').button('loading');
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
                            var DataTabel = $('.data_pesanan').DataTable();
                            DataTabel.ajax.reload();
                        }
                    });
                }
            },
            complete: function() {
                $('#batal').button('reset');
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
                        text: resp.pesan,
                        type: 'success'
                    }).then(okay => {
                        if (okay) {
                            $("#modal_create").modal('hide');
                            var DataTabel = $('.data_pesanan').DataTable();
                            DataTabel.ajax.reload();
                        }
                    });
                } else {
                    $("#pesan_gambar").html(resp.error);
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