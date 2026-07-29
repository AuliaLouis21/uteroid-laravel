<table border='1' style='border-collapse: collapse; border: 1px solid silver; width: 100%;'>
	<tr>
		<td class='table-header'><?php echo label_for('No') ?></td>
		<td class='table-header'><?php echo label_for('Nama') ?></td>
		<td class='table-header'><?php echo label_for('Alamat') ?></td>
		<td class='table-header'><?php echo label_for('Telepon') ?></td>
	</tr>
	<?php $i=0; ?>
	<?php foreach($query_salescounter->result_array() as $row) { ?>
		<tr>
			<td id="<?php echo $row['no_id'] ?>" onclick="row_onClick(event)"><?php echo label_for(++$i) ?></td>
			<td onclick="row_onClick(event)"><?php echo label_for($row['nama']) ?></td>
			<td onclick="row_onClick(event)"><?php echo label_for($row['alamat']) ?></td>
			<td onclick="row_onClick(event)"><?php echo label_for($row['telepon']) ?></td>
		</tr>
	<?php } ?>
	<?php $query_salescounter->free_result() ?>
</table>