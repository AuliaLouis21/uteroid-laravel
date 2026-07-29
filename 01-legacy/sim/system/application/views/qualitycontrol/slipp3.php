<fieldset>
	<? $i=0 ?>
	<table border='1' style='float: left;border-collapse: collapse; border: 1px solid silver; width: 100%;'>
		<tr>
			<td class='table-header'><?= label_for('No') ?></td>
			<td class='table-header'><?= label_for('No. Nota') ?></td>
			<td class='table-header'><?= label_for('Slip') ?></td>
			<td class='table-header'><?= label_for('Nama') ?></td>
			<td class='table-header'><?= label_for('Selesai Desain') ?></td>
			<td class='table-header'><?= label_for('Selesai Produksi') ?></td>
			<td class='table-header'><?= label_for('Selesai Ke Klien') ?></td>
			<td class='table-header'><?= label_for('Status') ?></td>
		</tr>
		<? foreach($query->result_array() as $row) { ?>
			<?
				$query2 = $this->db->query("select * from sim_produk where no_id=".$row['produk']);
				$row_query2 = $query2->row_array();
			?>
			<tr>
				<td class='table-row-center'><?= label_for(++$i) ?></td>
				<td class='table-row-center'><?= label_for($row['no_nota']) ?></td>
				<td class='table-row-center'><?= label_for($row['no_slip_order']) ?></td>
				<td class='table-row-left'><?= label_for($row_query2['nama']) ?></td>
				<td class='table-row-center'><?= label_for(date('d M Y',time($row['tanggal']))) ?></td>
				<td class='table-row-center'><?= label_for(date('d M Y',time($row['tgl_kirim']))) ?></td>
				<td class='table-row-center'><?= label_for(date('d M Y',time($row['pajak_dari']))) ?></td>
				<td class='table-row-center'><?= label_for($row['status']) ?></td>
			</tr>
		<? } ?>
	</table>
</fieldset>