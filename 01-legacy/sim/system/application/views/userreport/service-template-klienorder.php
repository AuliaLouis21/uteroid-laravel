<table border="1" style="border-collapse: collapse; border: 1px solid silver; width: 100%;">
	<tbody>
		<tr>
			<td class="table-header"><?=label_for('No')?></td>
			<td class="table-header"><?=label_for('Tanggal')?></td>
			<td class="table-header"><?=label_for('Nota')?></td>
			<td class="table-header"><?=label_for('Nama')?></td>
			<td class="table-header"><?=label_for('Alamat')?></td>
			<td class="table-header"><?=label_for('Perusahaan')?></td>
			<td class="table-header"><?=label_for('Telepon')?></td>
			<td class="table-header"><?=label_for('Nama Produk')?></td>
		</tr>
		<?foreach($query->result_array() as $row): ?>
			<tr>
				<td class='table-row-center'><?=label_for(++$i)?></td>
				<td class='table-row-center'><?=label_for(to_human_date($row['tgl_terima']))?></td>
				<td class='table-row-center'><?=label_for($row['nota'])?></td>
				<td class='table-row-left'><?=label_for($row['jeneng'])?></td>
				<td class='table-row-left'><?=label_for($row['alamat'])?></td>
				<td class='table-row-left'><?=label_for($row['perusahaan'])?></td>
				<td class='table-row-left'><?=label_for($row['telepon'])?></td>
				<td class='table-row-left'><?=label_for($row['nama_produk'])?></td>
				<?$total += $row['total'] ?>
			</tr>
		<?endforeach?>
		<tr>
			<td class="table-row-right" colspan="5"><?=label_for("total")?></td>
			<td class="table-row-right" style='background-color:yellow;font-weight:bold;'><?=number_format($total,2,',','.')?></td>
			<td class="table-row-right" colspan="2"></td>
		</tr>
	</tbody>
</table>
<div style="margin-top: 10px;">
	<input type="button" id="buttonCetak" name="buttonCetak" value="Cetak" 
		onclick="javascript:buttonCetak_onClick(event,'<?=$button_parameter?>')" 
		class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all">
</div>