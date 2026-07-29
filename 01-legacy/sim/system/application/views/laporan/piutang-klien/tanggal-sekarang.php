<table style="border-collapse: collapse; border: 1px solid silver; width: 100%;" border="1">
	<tr>
		<td class="table-header">No</td>
		<td class="table-header">Nota</td>
		<td class="table-header">Tanggal</td>
		<td class="table-header">Nama</td>
		<td class="table-header">Total</td>
		<td class="table-header">Dibayar</td>
		<td class="table-header">Kekurangan</td>
		<td class="table-header">Status</td>
		<td class="table-header">Sales</td>
	</tr>
	<?php
		$i=0;
		$uangmuka = 0;
		$total = 0;
		$kekurangan = 0;
		foreach($piutang_query->result_array() as $row) {
			echo "<tr>";
			echo "<td class='table-row-center'>".(++$i)."</td>";
			echo "<td class='table-row-center'>".$row['nota']."</td>";
			echo "<td class='table-row-center'>".$row['tgl_terima'].'</td>';
			echo "<td class='table-row-left'>".$row['klie']."</td>";
			echo "<td class='table-row-right'>".number_format($row['total'],2,',','.')."</td>";
			
			$other_query = $this->db->query("select sum(dibayar) as dibayar from sim_pembayaran where no_nota='".$row['NoNota']."'");
			if($other_query->num_rows() != 0) {
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
			
			echo "<td class='table-row-right'>".number_format($row['sisa'],2,',','.')."</td>";
			
			$query_status = $this->db->query("select status from sim_slip_order_nota where nota=".$this->db->escape($row['nota']));
			if($query_status->num_rows() != 0) {
				$row_status = $query_status->row_array();
				echo "<td class='table-row-center'>".$row_status['status']."</td>";
				$query_status->free_result();
			}
			else {
				echo "<td class='table-row-center'>-</td>";
			}
			
			echo "<td class='table-row-center'>".$row['sale']."</td>";
			echo "</tr>";
			
			
			$total += $row['total'];
		}
		$kekurangan = $total - $uangmuka;
		$piutang_query->free_result();
	?>
	<tr>
		<td colspan="4" class="table-row-right" style="font-weight:bold">Total : </td>
		<td id="totaluangmuka" class="table-row-right" style="background-color:yellow;font-weight:bold">
			<?php echo number_format($total,2,',','.'); ?>
		</td>
		<td id="totaljumlah" class="table-row-right" style="background-color:yellow;font-weight:bold">
			<?php echo number_format($uangmuka,2,',','.'); ?>
		</td>
		<td id="totaljumlah" class="table-row-right" style="background-color:yellow;font-weight:bold">
			<?php echo number_format($kekurangan,2,',','.'); ?>
		</td>
		<td colspan="2"></td>
	</tr>
</table>
<div style="margin-top: 10px;">
	<input type="button" 
		class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" 
		onclick="javascript:buttonCetak_onClick(event,'<?php echo $button_parameter; ?>')" 
		value="Cetak" 
		name="buttonCetak" 
		id="buttonCetak">
</div>