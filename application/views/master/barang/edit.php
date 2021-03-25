<div class="col-xs-12">
    <?= form_open('barang/update', ['id' => 'form_create'], ['kode' => $data['id_barang']]) ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#umum" data-toggle="tab">Umum</a></li>
            <li><a href="#deskripsi" data-toggle="tab">Deskripsi Barang</a></li>
            <li><a href="#kategori" data-toggle="tab">Kategori & Satuan</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="umum">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama_barang'] ?>">
                </div>
                <div class="form-group">
                    <label>Slug Barang</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="<?= $data['slug_barang'] ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?= $data['status_barang'] == '1' ? 'selected' : null ?>>Enabled</option>
                        <option value="2" <?= $data['status_barang'] == '2' ? 'selected' : null ?>>Disabled</option>
                    </select>
                </div>
            </div>
            <div class="tab-pane" id="deskripsi">
                <div class="table-responsive">
                    <table id="attribute" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left" style="width: 20%;">Judul</td>
                                <td class="text-left">Deskripsi</td>
                                <td style="width: 5%;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($barang_desc as $barang_desc) { ?>
                                <tr id="deskripsi-row<?= $no ?>">
                                    <td class="text-left">
                                        <input type="text" name="barang_desc[<?= $no ?>][name]" placeholder="Judul" class="form-control" value="<?= $barang_desc['judul_brg_desc'] ?>" <?= $barang_desc['level_brg_desc'] == 0 ? 'readonly' : null  ?>>
                                        <input type="hidden" name="barang_desc[<?= $no ?>][attribute_id]" value="<?= $no ?>" />
                                    </td>
                                    <td class="text-left">
                                        <textarea name="barang_desc[<?= $no ?>][barang_desc_desc][text]" rows="5" placeholder="Deskripsi" class="form-control editor"><?= $barang_desc['desc_brg_desc'] ?></textarea>
                                    </td>
                                    <td class="text-right">
                                        <?php if ($barang_desc['level_brg_desc'] != 0) : ?>
                                            <button type="button" onclick="$('#deskripsi-row<?= $no ?>').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-right">
                                    <button type="button" onclick="tambahDeksripsi();" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="kategori">
                <div class="row">
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" value="" placeholder="Kategori" id="input-kategori" class="form-control">
                            <div id="barang-kategori" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($barang_kategori as $barang_kategori) { ?>
                                    <div id="barang-kategori<?= $barang_kategori['kategori_brg_kategori'] ?>"><i class="fa fa-minus-circle text-red"></i> <?= $barang_kategori['nama_kategori'] ?><input type="hidden" name="barang_kategori[]" value="<?= $barang_kategori['kategori_brg_kategori'] ?>"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" name="satuan" value="" placeholder="Satuan" id="input-satuan" class="form-control">
                            <div id="barang-satuan" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($barang_satuan as $barang_satuan) { ?>
                                    <div id="barang-satuan<?= $barang_satuan['satuan_brg_satuan'] ?>"><i class="fa fa-minus-circle text-red"></i> <?= $barang_satuan['nama_satuan'] ?><input type="hidden" name="barang_satuan[]" value="<?= $barang_satuan['satuan_brg_satuan'] ?>"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan</button>
            <a href="<?= site_url('barang') ?>" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
        </div>
    </div>
    <?= form_close() ?>
</div>
<script>
    $(function() {
        $("#nama").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#slug").val(Text);
        });
    });

    // autocomplete kategori
    $('input[name=\'kategori\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: "<?= site_url('kategori/kategori_by_nama') ?>",
                data: {
                    filter_nama: request
                },
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['nama'],
                            value: item['id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'kategori\']').val('');
            $('#barang-kategori' + item['value']).remove();
            $('#barang-kategori').append('<div id="barang-kategori' + item['value'] + '"><i class="fa fa-minus-circle text-red"></i> ' + item['label'] + '<input type="hidden" name="barang_kategori[]" value="' + item['value'] + '" /></div>');
        }
    });

    // Hapus item kategori
    $('#barang-kategori').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });

    // tambah inputan otomatis untuk deskripsi barang
    var deskripsi_row = 3;

    function tambahDeksripsi() {
        html = '<tr id="deskripsi-row' + deskripsi_row + '">';
        html += '  <td class="text-left"><input type="text" name="barang_desc[' + deskripsi_row + '][name]" value="" placeholder="Judul" class="form-control" /><input type="hidden" name="barang_desc[' + deskripsi_row + '][attribute_id]" value="' + deskripsi_row + '" /></td>';
        html += '  <td class="text-left">';
        html += '<textarea name="barang_desc[' + deskripsi_row + '][barang_desc_desc][text]" rows="5" placeholder="Deskripsi" class="form-control"></textarea>';
        html += '  </td>';
        html += '  <td class="text-right"><button type="button" onclick="$(\'#deskripsi-row' + deskripsi_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#deskripsi tbody').append(html);

        deskripsi_row++;
    }

    // Update data
    $(document).ready(function() {
        $('#form_create').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $('#store').button('loading');
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
                    $('#store').button('reset');
                }
            })
        });
    });
</script>