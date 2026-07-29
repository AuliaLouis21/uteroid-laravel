<div>
	<div>
		<table style='width:100%;height:100%'>
			<tr>
				<td><img style='width:140px;heigth:140px' src='<?php echo base_url().'/resources/images/utero.jpg'; ?>'/></td>
				<td><center><h1>Laporan Piutang Klien Order</h1><h4><Keterangan><?php echo $keterangan; ?></h4></center></td>
				<td style='text-align:right'>Print Date : <?php echo $print_date ; ?></td>
			</tr>
		</table>
		<table style='width:100%;height:100%'>
			<tr>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>No</center></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>Nota</center></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>Nama</center></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>Total</center></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>Dibayar</center></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>Kekurangan</center></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>Status</center></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'><center>Sales</center></td>
			</tr>
			<?php
				$i=0;
				$uangmuka = 0;
				$total = 0;
				$kekurangan = 0;
				foreach($piutang_query->result_array() as $row) {
					echo "<td class='table-row-center'>". (++$i) . "</td>";
					echo "<td class='table-row-center'>".$row['nota']."</td>";
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
				$piutang_query->free_result();
				$kekurangan = $total - $uangmuka;
				$piutang_query->free_result();
			?>							
			<tr>
				<td colspan='3' style='text-align:right;font-weight:bold;'>Grand Total :</td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>
						<?php echo number_format($total,2,',','.'); ?></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>
						<?php echo number_format($uangmuka,2,',','.'); ?></td>
				<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>
						<?php echo number_format($kekurangan,2,',','.'); ?></td>
				<td> </td>
				<td> </td>
			</tr>
		</table>
	</div>
</div>