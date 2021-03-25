<div class="col-xs-12">
    <?= form_open('barang/store', ['id' => 'form_create']) ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#umum" data-toggle="tab">Umum</a></li>
            <li><a href="#deskripsi" data-toggle="tab">Deskripsi Barang</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="umum">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label>Slug Barang</label>
                    <input type="text" name="slug" id="slug" class="form-control">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Enabled</option>
                        <option value="2">Disabled</option>
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
                            <tr id="deskripsi-row0">
                                <td class="text-left">
                                    <input type="text" name="barang_desc[0][name]" placeholder="Judul" class="form-control" value="Deskripsi Umum" readonly>
                                    <input type="hidden" name="barang_desc[0][attribute_id]" value="0" />
                                </td>
                                <td class="text-left">
                                    <textarea name="barang_desc[0][barang_desc_desc][text]" rows="5" placeholder="Deskripsi" class="form-control editor"></textarea>
                                </td>
                            </tr>
                            <tr id="deskripsi-row1">
                                <td class="text-left">
                                    <input type="text" name="barang_desc[1][name]" placeholder="Judul" class="form-control" value="Nutrisi dan Manfaat">
                                    <input type="hidden" name="barang_desc[1][attribute_id]" value="1" />
                                </td>
                                <td class="text-left">
                                    <textarea name="barang_desc[1][barang_desc_desc][text]" rows="5" placeholder="Deskripsi" class="form-control editor"></textarea>
                                </td>
                                <td class="text-right">
                                    <button type="button" onclick="$('#deskripsi-row1').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                            <tr id="deskripsi-row2">
                                <td class="text-left">
                                    <input type="text" name="barang_desc[2][name]" placeholder="Judul" class="form-control" value="Cara Penyimpanan">
                                    <input type="hidden" name="barang_desc[2][attribute_id]" value="2" />
                                </td>
                                <td class="text-left">
                                    <textarea name="barang_desc[2][barang_desc_desc][text]" rows="5" placeholder="Deskripsi" class="form-control editor"></textarea>
                                </td>
                                <td class="text-right">
                                    <button type="button" onclick="$('#deskripsi-row2').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
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
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan</button>
            <a href="<?= site_url('barang') ?>" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
        </div>
    </div>
    <?= form_close() ?>
</div>

<script>
    $(document).ready(function() {
        // menampilkan slug otomatis sesuai dengan nama barang
        $("#nama").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#slug").val(Text);
        });
    });

    // simpan data
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