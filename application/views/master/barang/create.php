<style type="text/css">
    .TombolUpload{

    }
</style>
<div class="col-xs-12">
    <?= form_open('barang/store', ['id' => 'form_create']) ?>
    <div class="nav-tabs-custom">
<!-- NavTab Header -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#umum" data-toggle="tab">Umum</a></li>
            <li><a href="#deskripsi" data-toggle="tab">Deskripsi Barang</a></li>
            <li><a href="#kategori" data-toggle="tab">Kategori & Satuan</a></li>
            <li><a href="#gambar" data-toggle="tab">Gambar</a></li>
        </ul>
<!--  Isi dari NavTab -->
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
            <div  class="tab-pane" id="kategori">
                <div class="row">
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" value="" placeholder="Kategori" id="input-kategori" class="form-control">
                            <div id="barang-kategori" class="well well-sm" style="height: 150px; overflow: auto;"></div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" name="satuan" value="" placeholder="Satuan" id="input-satuan" class="form-control">
                            <div id="barang-satuan" class="well well-sm" style="height: 150px; overflow: auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="gambar">
                <div class="table-responsive">
                    <table id="attribute" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left" style="width: 20%;">Satuan</td>
                                <td class="text-left">Gambar</td>
                                <td class="text-left">Nomor Urut</td>
                                <td style="width: 5%;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
<!-- Akhiran isi  -->
        <div class="box-footer">
            <button type="submit" class="btn btn-success" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan</button>
            <a href="<?= site_url('barang') ?>" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
        </div>
    </div>
    <?= form_close() ?>
</div>

<script>
    $(document).ready(function() {
//GLobal Variable declartae
         Gsatuan={
        };

        // menampilkan slug otomatis sesuai dengan nama barang
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

    // autocomplete satuan
    $('input[name=\'satuan\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: "<?= site_url('satuan/satuan_by_nama') ?>",
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
            $('input[name=\'satuan\']').val('');
            $('#barang-satuan' + item['value']).remove();
            if (!Boolean(Gsatuan[item['value']])) {
            Gsatuan[item['value']]=[item['label'],count(Gsatuan)+1];
            }
            console.log(Gsatuan);
            TampilGambarTab();
            $('#barang-satuan').append('<div id="barang-satuan' + item['value'] + '"><i class="fa fa-minus-circle text-red"></i> ' + item['label'] + '<input type="hidden" name="barang_satuan[]" value="' + item['value'] + '" /></div>');
        }
    });

    function TampilGambarTab() {
                $('#gambar tbody').html("");
                for (const [key, value] of Object.entries(Gsatuan)) {
                        // alert(value);     
                        $('#gambar tbody').append(rowOfImages(value, key));
                }
    }
    function  rowOfImages(v, k){

     let a=12;
    return   `
            <tr id="deskripsi-row${v[1]}">
                <td class="text-left">
                    ${v[0]}
                </td>
                <td class="text-left">
                    <img onmouseenter="ShowButton()" class="profile-user-img img-responsive img-circle" src="https://adminlte.io/themes/AdminLTE/dist/img/user4-128x128.jpg" alt="User profile picture">
                    <div class="TombolUpload">
                        Tombol
                    </div>
                </td>
                <td class="text-left">
                    ${v[1]} 
                </td>
            </tr>
            `;
        }
function panggil(argument) {
    alert("Bisa");
}
function count(obj) {
   var count=0;
   for(var prop in obj) {
      if (obj.hasOwnProperty(prop)) {
         ++count;
      }
   }
   return count;
}
    // Hapus item kategori
    $('#barang-kategori').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });

    // Hapus item satuan
    $('#barang-satuan').delegate('.fa-minus-circle', 'click', function() {
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