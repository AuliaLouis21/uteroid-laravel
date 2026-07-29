<fieldset style="padding: 15px;">
<table style="border-collapse: collapse; border: 1px solid silver; width: 100%;" border="1">
	<tr>
		<td class="table-header"><?=label_for("No")?></td>
		<td class="table-header"><?=label_for("Tanggal")?></td>
		<td class="table-header"><?=label_for("Kode")?></td>
		<td class="table-header"><?=label_for("Account")?></td>
		<td class="table-header"><?=label_for("Reference")?></td>
		<td class="table-header"><?=label_for("Keterangan")?></td>
		<td class="table-header"><?=label_for("Debet")?></td>
		<td class="table-header"><?=label_for("Kredit")?></td>
	</tr>
	<? foreach($query->result_array() as $row) : ?>
		<tr>
			<td class="table-row-center"><?=label_for(++$i)?></td>
			<td class="table-row-center"><?=label_for(strftime('%d %B %Y',time($row['tanggal'])))?></td>
			<td class="table-row-center"><?=label_for($row['code'])?></td>
			<td class="table-row-left"><?=label_for($row['acc'])?></td>
			<td class="table-row-center"><?=label_for($row['reference'])?></td>
			<td class="table-row-left"><?=label_for($row['keterangan'])?></td>
			<? if($row['status'] == 1) { ?>
				<td class="table-row-right"><?=label_for(number_format($row['total'],2,'.',','))?></td>
				<td class="table-row-right"><?=label_for(number_format(0,2,'.',',')) ?></td>
				<? $total_debet += $row['total'] ?>
			<? } else { ?>
				<td class="table-row-right"><?=label_for(number_format(0,2,'.',',')) ?></td>
				<td class="table-row-right"><?=label_for(number_format($row['total'],2,'.',','))?></td>
				<? $total_kredit += $row['total'] ?>
			<? } ?>
		</tr>
	<? endforeach ?>
	<tr>
		<td colspan="6" class="table-row-center"><?=label_for("Total")?></td>
		<td class="table-row-right" style='background-color: yellow; font-weight: bold;'><?=label_for(number_format($total_debet,2,'.',',')) ?></td>
		<td class="table-row-right" style='background-color: yellow; font-weight: bold;'><?=label_for(number_format($total_kredit,2,'.',',')) ?></td>
	</tr>
</table>

</fieldset>