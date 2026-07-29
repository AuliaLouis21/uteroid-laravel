<table style="border-collapse: collapse; border: 1px solid silver; width: 100%;" border="1">
	<tr>
		<td class="table-header"><?=label_for('No')?></td>
		<td class="table-header"><?=label_for('Nota')?></td>
		<td class="table-header"><?=label_for('Tanggal Terima')?></td>
		<td class="table-header"><?=label_for('Uang Muka')?></td>
		<td class="table-header"><?=label_for('Jumlah')?></td>
		<td class="table-header"><?=label_for('Sales Counter')?></td>
		<td class="table-header"><?=label_for('Keterangan')?></td>
		<td class="table-header"><?=label_for('Status')?></td>
	</tr>
	<? foreach($query->result_array() as $row) : ?>
		<tr>
			<td class='table-row-center'><?=label_for(++$i)?></td>
			<td class='table-row-center'><?=label_for($row['nota'])?></td>
			<td class='table-row-center'><?=label_for(to_human_date($row['tgl_terima']))?></td>
			<td class='table-row-right'><?=label_for(number_format($row['jumlah_uangmuka'],2,',','.')) ?></td>
			<td class='table-row-right'><?=label_for(number_format($row['total'],2,',','.')) ?></td>
			<td class='table-row-center'><?=label_for($row['nama'])?></td>
			<td class='table-row-center'><?=label_for($row['Keterangan']) ?></td>
			<td class='table-row-center'><?=label_for((trim($row['card']) == '' ? "Tunai" : $row['card']))?></td>
			<? $this->total_uang_muka += $row['jumlah_uangmuka'] ?>
			<? $this->total_jumlah += $row['total'] ?>
		</tr>
	<? endforeach ?>
	<? $this->load->view('userreport/service-payment-template',array('payment_sql'=>$payment_sql,'i'=>$i)) ?>
</table>
<div style="margin-top: 10px;">
	<input type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" 
		onclick="javascript:buttonCetak_onClick(event,'<?=$button_parameter?>')" 
		value="Cetak" name="buttonCetak" id="buttonCetak">
</div>