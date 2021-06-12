<table class="table table-bordered dataTable table-hover nowrap no-footer">
    <tr>
        <th class="bg-gray color-palette" width="130px">Nomor Invoice</th>
        <td><?= $data['nomor'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status Bayar</th>
        <td><?= status_label($data['status_bayar'], 'bayar') ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status Order</th>
        <td><?= status_label($data['status'], 'order') ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Customer</th>
        <td><?= $data['customer'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Tanggal Pembelian</th>
        <td><?= format_indo(format_tglen_timestamp($data['tanggal'])) . ', ' . sort_jam_timestamp($data['tanggal']) ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Total Bayar</th>
        <td><?= 'Rp ' . rupiah($data['total']) ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Metode Pembayaran</th>
        <td><?= $data['metode'] ?></td>
    </tr>
    <?php if ($bayar['status'] != false) { ?>
        <tr>
            <th class="bg-gray color-palette text-center" colspan="2">Validasi Konfirmasi Pembayaran</th>
        </tr>
        <tr>
            <th class="bg-gray color-palette">Tanggal Transfer</th>
            <td><?= format_indo($bayar['tanggal']) ?></td>
        </tr>
        <tr>
            <th class="bg-gray color-palette">Jumlah Transfer</th>
            <td><?= 'Rp ' . rupiah($bayar['nilai']) ?></td>
        </tr>
        <tr>
            <th class="bg-gray color-palette">Bukti Pembayaran</th>
            <td><a href="<?= assets() . $bayar['bukti'] ?>" target="_blank">Link Bukti Pembayaran</a></td>
        </tr>
        <tr>
            <th class="bg-gray color-palette">Status Konfirmasi</th>
            <td><?= status_label($bayar['status'], 'confirm') ?></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <button type="button" class="btn btn-success" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-checkmark-circle"></i> Setujui Pembayaran</button>
            </td>
        </tr>
    <?php } else { ?>
        <tr>
            <th class="bg-gray color-palette disabled text-center" colspan="2">Customer belum melakukan konfirmasi pembayaran</th>
        </tr>
    <?php } ?>
</table>