<table border="1" style="border-collapse: collapse; border: 1px solid silver; width: 100%;">
	<tbody>
		<tr>
			<td class="table-header"><?=label_for('No')?></td>
			<td class="table-header"><?=label_for('Nota')?></td>
			<td class="table-header"><?=label_for('Tanggal')?></td>
			<td class="table-header"><?=label_for('Nama')?></td>
			<td class="table-header"><?=label_for('Total')?></td>
			<td class="table-header"><?=label_for('Dibayar')?></td>
			<td class="table-header"><?=label_for('Kekurangan')?></td>
			<td class="table-header"><?=label_for('Status')?></td>
			<td class="table-header"><?=label_for('Sales')?></td>
		</tr>
		<?foreach($query->result_array() as $row) : ?>
			<tr>
				<td class='table-row-center'><?=label_for(++$i)?></td>
				<td class='table-row-center'><?=label_for($row['nota'])?></td>
				<td class='table-row-center'><?=label_for(to_human_date($row['tgl_terima']))?></td>
				<td class='table-row-left'><?=label_for($row['klie'])?></td>
				<td class='table-row-right'><?=number_format($row['total'],2,',','.')?></td>
				<? $other_query = $this->db->query("select sum(dibayar) as dibayar from sim_pembayaran where no_nota='".$row['NoNota']."'") ?>
				<? if($other_query->num_rows()!=0) { 
						$other_row = $other_query->row_array();
						$dibayar = $other_row['dibayar'];
						$uangmuka += $row['jumlah_tagihan'] + $dibayar;
						echo "<td class='table-row-right'>".number_format($row['jumlah_tagihan'] + $dibayar,2,',','.')."</td>";
						$other_query->free_result();
					}
					else {
						$uangmuka += $row['jumlah_tagihan'];
						echo "<td class='table-row-right'>".number_format($row['jumlah_tagihan'],2,',','.')."</td>";
					}
				?>
				<td class='table-row-right'><?=number_format($row['sisa'],2,',','.')?></td>
				<? 
					$query_status = $this->db->query("select status from sim_slip_order_nota where nota=".$this->db->escape($row['nota']));
					if($query_status->num_rows() != 0) {
						$row_status = $query_status->row_array();
						echo "<td class='table-row-center'>".$row_status['status']."</td>";
						$query_status->free_result();
					}
					else {
						echo "<td class='table-row-center'>-</td>";
					}
					echo "<td class='table-row-center'>".$this->session->userdata('users')."</td>";  # cok , iki jenenge sales ta ? lha row index e sale , tak kiro jual
					echo "</tr>";
					$total += $row['total'];
				?>
			</tr>
		<?endforeach?>
		<? $kekurangan = $total - $uangmuka ?>
		<tr>
			<td style="font-weight: bold;" class="table-row-right" colspan="4">Total : </td>
			<td style="background-color: yellow; font-weight: bold;" class="table-row-right" id="totaluangmuka">
				<?=number_format($total,2,',','.'); ?>	
			</td>
			<td style="background-color: yellow; font-weight: bold;" class="table-row-right" id="totaljumlah">
				<?=number_format($uangmuka,2,',','.'); ?>
			</td>
			<td style="background-color: yellow; font-weight: bold;" class="table-row-right" id="totaljumlah">
				<?=number_format($kekurangan,2,',','.'); ?>
			</td>
			<td colspan="2"></td>
		</tr>
	</tbody>
</table>
<div style="margin-top: 10px;">
	<input type="button" id="buttonCetak" name="buttonCetak" value="Cetak" 
		onclick="javascript:buttonCetak_onClick(event,'<?=$button_parameter?>')" 
		class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all">
</div>