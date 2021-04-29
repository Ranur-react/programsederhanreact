<h4 class="page-header">Daftar permintaan barang yang telah dipilih</h4>
<?php foreach ($data as $d) {
    $id_minta = $d['id_permintaan'];
    $barang = $this->db->from('permintaan_detail')
        ->join('barang_satuan', 'barang_detail=id_brg_satuan')
        ->join('barang', 'barang_brg_satuan=id_barang')
        ->join('satuan', 'satuan_brg_satuan=id_satuan')
        ->where('permintaan_detail', $id_minta)
        ->get()->result_array();
?>
    <div class="panel panel-default m-t-1 m-b-0">
        <div class="panel-body panel-body-custom">
            <div class="row">
                <div class="col-lg-12 col-xs-12 ">
                    <div class="row">
                        <div class="col-lg-2 col-xs-4"><b>Nomor</b> <span class="value">:</span></div>
                        <div class="col-lg-10 col-xs-8"><?= $d['id_permintaan'] ?></div>
                        <div class="col-lg-2 col-xs-4"><b>Supplier</b> <span class="value">:</span></div>
                        <div class="col-lg-10 col-xs-8"><?= $d['nama_supplier'] ?></div>
                        <div class="col-lg-2 col-xs-4"><b>Tanggal</b> <span class="value">:</span></div>
                        <div class="col-lg-10 col-xs-8"><?= format_indo($d['tanggal_permintaan']) ?></div>
                        <div class="col-lg-2 col-xs-4"><b>Status</b> <span class="value">:</span></div>
                        <div class="col-lg-2 col-xs-4"><?= status_label($d['status_permintaan'], 'permintaan') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered dataTable table-hover nowrap no-footer">
            <thead class="bg-gray color-palette">
                <tr>
                    <th>Barang</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Total</th>
                    <th class="text-center" width="40px">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($barang as $b) {
                    $total = $total + ($b['harga_detail'] * $b['jumlah_detail']);
                ?>
                    <tr>
                        <td><?= $b['nama_barang'] ?></td>
                        <td><?= akuntansi($b['harga_detail']) ?></td>
                        <td class="text-right"><?= rupiah($b['jumlah_detail']) . ' ' . $b['singkatan_satuan'] ?></td>
                        <td><?= akuntansi($b['harga_detail'] * $b['jumlah_detail']) ?></td>
                        <td class="text-center">
                            <a href="javascript:void(0)" onclick="create('<?= $b['id_detail'] ?>')" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th><?= akuntansi($total) ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php } ?>