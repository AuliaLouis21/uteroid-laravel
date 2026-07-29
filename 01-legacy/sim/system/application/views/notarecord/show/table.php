<table style="border-collapse: collapse; border: 1px solid silver; width: 100%;" border="1">
	<tr>
		<td class="table-header"><?php echo label_for('No') ?></td>
		<td class="table-header"><?php echo label_for('Nota') ?></td>
		<td class="table-header"><?php echo label_for('Tanggal Terima') ?></td>
		<td class="table-header"><?php echo label_for('Tanggal Desain') ?></td>
		<td class="table-header"><?php echo label_for('Tanggal Selesai') ?></td>
		<td class="table-header"><?php echo label_for('Nama Klien') ?></td>
		<td class="table-header"><?php echo label_for('Status') ?></td>
		<td class="table-header"><?php echo label_for('Action') ?></td>
	</tr>
	<?php $i = 1 ?>
	<?php foreach($query->result_array() as $row) { ?>
		<?php $query_klien = $this->db->query('select * from sim_client where no_id='.$row['klien']) ?>
		<?php $row_klien = $query_klien->row_array() ?>
		<tr>
			<td class='table-row-center'><?php echo label_for($i) ?></td>
			<td class='table-row-center'><?php echo label_for($row['nota']) ?></td>
			<td class='table-row-center'><?php echo label_for(to_human_date($row['tgl_terima'])) ?></td>
			<td class='table-row-center'><?php echo label_for(to_human_date($row['tgl_desain'])) ?></td>
			<td class='table-row-center'><?php echo label_for(to_human_date($row['tgl_selesai'])) ?></td>
			<td class='table-row-center'><?php echo label_for($row_klien['nama']) ?></td>
			<td class='table-row-center'><?php echo label_for('-') ?></td>
			<td class='table-row-center'>
				<?php echo link_to('cetak','#',array('id'=>'a_cetak','onclick'=>'cetak('.$row['no_id'].')')) ?>
				<?php if($this->session->userdata('isadmin')=='true') { ?>
					<?php echo link_to('edit','transaksinota/edit/id/'.$row['no_id']) ?>
				<?php } ?>
			</td>
		</tr>		
		<?php $query_klien->free_result() ?>
		<?php $i+=1 ?>
	<?php } ?>
</table>