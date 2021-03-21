<div class="form-group">
    <label>Nama Barang</label>
    <input type="text" name="nama" id="nama" class="form-control">
</div>
<div class="form-group">
    <label>Slug Barang</label>
    <input type="text" name="slug" id="slug" class="form-control">
</div>
<div class="form-group">
    <label>Deskripsi Barang</label>
    <textarea class="form-control" name="desc" id="desc" cols="50" rows="10" style="visibility: hidden; display: none;"></textarea>
</div>
<div class="form-group">
    <label>Status</label>
    <select name="status" id="status" class="form-control">
        <option value="1">Enabled</option>
        <option value="2">Disabled</option>
    </select>
</div>
<script>
    $(document).ready(function() {
        $("#nama").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#slug").val(Text);
        });
    });
</script>