<input type="hidden" name="idorder" value="<?= $data['id'] ?>">
<input type="hidden" name="idbayar" value="<?= $data['idbayar'] ?>">
<div class="form-group">
    <label for="tanggal">Tanggal Transfer</label>
    <div class="input-group date">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" name="tanggal" id="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
    </div>
</div>
<div class="form-group">
    <label class="required">Jumlah Transfer</label>
    <input type="text" name="nilai" id="nilai" class="form-control" placeholder="Jumlah Transfer">
</div>
<div class="form-group">
    <label>Bukti Transfer</label>
    <input id="upload_image" name="gambar" type="file">
    <div id="pesan_gambar"></div>
</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
        var img_fileinput_setting = {
            showUpload: false,
            showPreview: false,
            browseLabel: 'Telusuri...',
            removeLabel: 'Hapus',
            previewSettings: {
                image: {
                    width: 'auto',
                    height: 'auto',
                    'max-width': '100%',
                    'max-height': '100%'
                },
            },
        };
        $('#upload_image').fileinput(img_fileinput_setting);
        $('#nilai').keyup(function(e) {
            var nilai = formatRupiah($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>