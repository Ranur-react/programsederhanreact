<?php //ob_start(); ?>
<!DOCTYPE html>
<style type="text/css">
	.foto{
		width: 80px;
		height: 80px; 
		border-radius: 50%
	}
</style>
<html>
<head>
	<title>Laporan Data Penjualan</title>
	<style>

 table {border-collapse:collapse; table-layout:fixed;}
 table td {word-wrap:break-word;text-align: left;}

 </style>
</head>
<body onload="window.print()">
	<h1 align="center">Laporan Data Penjualan
		 <br>Barangmudo</h1>
	<h3 align="center">Kota Padang</h3>
	<table align="center" width="60%" border="0">
</table>
<table align="center"  border="1">
	<thead>
						<tr>
							<th class="text-center" width="5%">No.</th>
							<th>No Faktur</th>
							<th>Tanggal Jual</th>
							<th>Nama Barang</th>
							<th>Harga Barang</th>
							<th>Qty</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($data as $d) { ?>
							<tr>
								<td class="text-center" width="40px"><?= $no . '.'; ?></td>
								<td><?= $d['invoice_order'] ?></td>
								<td><?= $d['tanggal_order'] ?></td>
								<td><?= $d['nama_barang'] ?></td>
								<td><?= $d['harga_order_barang'] ?></td>
								<td><?= $d['jumlah_order_barang'] ?></td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
	<tfoot>
						
					</tfoot>
</table>
<center><br>Padang,
<?php echo date('d-M-y') ?>
<br><br><br><br>
<u>(......................................)</u><br>
<b>Bagian Penjualan</b></center>
</body>
</html>
<?php
// $html = ob_get_contents();
// ob_end_clean();
// require_once('html2pdf/html2pdf.class.php');
// $pdf = new HTML2PDF('P','A4','en');
// $pdf->WriteHTML($html);
// $pdf->Output('Laporan File.pdf', 'D');
?>