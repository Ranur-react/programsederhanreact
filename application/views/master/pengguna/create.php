<div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama" id="nama" class="form-control">
</div>
<div class="form-group">
    <label>Username</label>
    <input type="text" name="username" id="username" class="form-control">
</div>
<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" id="password" class="form-control">
</div>
<div class="form-group">
    <label>Jenis Pengguna</label>
    <select name="jenis" id="jenis" class="form-control" onchange="get_level();get_gudang()">
        <option value="">Pilih</option>
        <option value="1">Back Office</option>
        <option value="2">Gudang</option>
    </select>
</div>
<div class="form-group">
    <label>Level</label>
    <select name="level" id="level" class="form-control">
        <option value="">Pilih</option>
    </select>
</div>
<div id="get_gudang"></div>