<? foreach($this->db->query($payment_sql)->result_array() as $row) : ?>
	<tr>
		<td class='table-row-center'><?=label_for(++$i)?></td>
		<td class='table-row-center'><?=label_for($row['nota'])?></td>
		<td class='table-row-center'><?=label_for(to_human_date($row['tanggal']))?></td>
		<td class='table-row-right'><?=label_for(number_format($row['dibayar'],2,',','.')) ?></td>
		<td class='table-row-right'><?=label_for(number_format(0,2,',','.')) ?></td>
		<td class='table-row-center'><?=label_for($row['sales'])?></td>
		<td class='table-row-center'><?=label_for('Pelunasan') ?></td>
		<td class='table-row-center'><?=label_for((trim($row['card']) == '' ? "Tunai" : $row['card']))?></td>
		<? $this->total_uang_muka += $row['dibayar'] ?>
		<? $this->total_jumlah += 0 ?>
	</tr>
<? endforeach ?>
	<tr>
		<td colspan="3" class="table-row-right" style="font-weight:bold"><?= label_for('Total : ') ?></td>
		<td id="totaluangmuka" class="table-row-right" style="background-color:yellow;font-weight:bold">
			<? if(isset($this->total_uang_muka)) { ?>
				<? echo label_for(number_format($this->total_uang_muka,2,',','.')) ?>
			<? } else { ?>
				<? echo label_for(number_format(0,2,',','.'))?>
			<? } ?>
		</td>
		<td id="totaljumlah" class="table-row-right" style="background-color:yellow;font-weight:bold">
			<? if(isset($this->total_jumlah)) { ?>
				<? echo label_for(number_format($this->total_jumlah,2,',','.'))?>
			<? } else { ?>
				<? echo label_for(number_format(0,2,',','.'))?>
			<? } ?>
		</td>
		<td colspan="3"></td>
	</tr>