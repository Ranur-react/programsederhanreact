<table class="tabel-data">
	<thead>
		<tr>
			<th>Kode Supplier</th>
			<th>Nama Supplier</th>
			<th>Alamat Supplier</th>
			<th>No Telpon</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;
		foreach ($data as $d) { ?>
			<tr>
				<td align="center"><?= $d['id_supplier'] ?></td>
				<td><?= $d['nama_supplier'] ?></td>
				<td><?= $d['alamat_supplier'] ?></td>
				<td><?= $d['telp_supplier'] ?></td>
			</tr>
		<?php $no++;
		} ?>
	</tbody>
</table>
<table class="tabel-footer">
	<tr>
		<td width="80%"></td>
		<td style="border-bottom: none;">
			Padang, <?= format_indo(date('Y-m-d')) ?><br>
			<br><br><br><br><br><br>
			<?= role_user() ?>
		</td>
	</tr>
</table>