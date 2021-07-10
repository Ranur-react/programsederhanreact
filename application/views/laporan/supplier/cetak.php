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
	<title>Laporan Absensi Karyawan</title>
	<style>

 table {border-collapse:collapse; table-layout:fixed;}
 table td {word-wrap:break-word;text-align: left;}

 </style>
</head>
<body onload="window.print()">
	<h1 align="center">Laporan Data Supplier
		 <br>Barangmudo</h1>
	<h3 align="center">Kota Padang</h3>
	<table align="center" width="60%" border="0">
</table>
<table align="center"  border="1">
	<thead>
						<tr>
							<th class="text-center" width="5%">No.</th>
							<th>Id Supplier</th>
							<th>Nama Supplier</th>
							<th>Alamat Supplier</th>
							<th>No Telpon</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($data as $d) { ?>
							<tr>
								<td class="text-center" width="40px"><?= $no . '.'; ?></td>
								<td><?= $d['id_supplier'] ?></td>
								<td><?= $d['nama_supplier'] ?></td>
								<td><?= $d['alamat_supplier'] ?></td>
								<td><?= $d['telp_supplier'] ?></td>
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