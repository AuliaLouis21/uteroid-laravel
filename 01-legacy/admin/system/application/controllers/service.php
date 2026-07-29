<?php
	class Service extends Controller {
		private $totaluangmuka=0;
		private $totaltagihan=0;
		private $totaluangmukapelunasan = 0;
		
		private $grandtotalpelunasan = 0;
		private $grandtotal = 0;
		
		private $sqlsumtotal = "";
		private $sqlsumtotaluangmuka = "";
		private $sales_id='';
		private $buttonParameter = "";
		private $paymentQuery = "select 
						SC.nama as sales,SK.nama as klien,SP.no_id as no,SP.*,SC.*,SK.* 
					from 
						sim_pembayaran SP 
					left 
						outer join sim_salescounter SC on SP.sales_no=SC.no_id 
					left 
						outer join sim_client SK on SP.klien_no=SK.no_id";
						
		function Service() {
			parent::Controller();
			if($this->session->userdata('islogin') == '') {
				redirect(base_url().index_page().'/login/');
			}
		}
		
		private function _getDate() {
			$result = '';
			$tanggal = date('d');
			$bulan = date('n');
			$tahun = date('Y');
			
			$vaBulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			
			return $tanggal . ' ' . $vaBulan[$bulan - 1] . ' ' . $tahun;
		}
		
		private function _cetaklaporan($tipelaporan,$tanggal) {
			$laporan = '';
			switch($tipelaporan) {
				case "tanggal-sekarang" :
					$laporan = $this->_cetakLaporanTanggalSekarang();
					break;
				case "nota" :
					$laporan = $this->_cetakLaporanNota();
					break;
				case "tanggal-terima" :
					$tanggalterima = to_mysql_date(trim($this->input->post("_tanggalterima")));
					$tanggalterima = $this->db->escape($tanggalterima);
					$laporan = $this->_cetakTanggalTerima($tanggalterima);
					break;
				case "tanggal-awal-akhir" :
					$tanggalawal = to_mysql_date(trim($this->input->post("_tanggalawal")));
					$tanggalakhir = to_mysql_date(trim($this->input->post("_tanggalakhir")));
					
					$tanggalawal = $this->db->escape($tanggalawal);
					$tanggalakhir = $this->db->escape($tanggalakhir);
					
					$laporan = $this->_cetakTanggalAwalAkhir($tanggalawal,$tanggalakhir);
					break;
			}
			$result = "";
			$result .= "<div>
							<div>
								<table style='width:100%;height:100%'>
									<tr>
										<td>
											<img style='width:140px;heigth:140px' src='".base_url().'/resources/images/utero.jpg'."'/>
										</td>
										<td>
											<center>
												<h1>Laporan Nota</h1>
												<h4>Tanggal " . $tanggal . "</h4>
											</center>
										</td>
										<td style='text-align:right'>
											Print Date ".$this->_getDate()."
										</td>
									</tr>
								</table>
								<table style='width:100%;height:100%'>
									<tr>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Sales/Teller</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Tanggal</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Nota</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Total</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Total Order</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Keterangan</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Status</center>
										</td>
									</tr>" . $laporan . "
									<tr>
										<td colspan='6'></td>
									</tr>
									<tr>
										<td colspan='6'></td>
									</tr>
									<tr>
										<td colspan='3' style='text-align:right;font-weight:bold;'>Grand Total :</td>"."
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>".number_format($this->grandtotalpelunasan,2,',','.')."</td>"."
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>".number_format($this->grandtotal,2,',','.')."</td>"."
										<td colspan='2'></td>"."
									</tr>
								</table>
							</div>
					   </div>";	
			echo $result;
		}
		
		private function _getSalesCounter($sc = '') {
			$sql = "select * from sim_salescounter";
			if($sc != '')
				$sql .= " where no_id='" .$sc ."'";
			$query = $this->db->query($sql);
			return $query;
		}
		
		private function _cetakLaporanTanggalSekarang() {
			$result = "";
			$tanggal = date('Y-m-d');
			$tanggal = $this->db->escape($tanggal);
			$x = 0;
			$sales = $this->_getSalesCounter();
			$sc = "";
			$nama = "";
			if($this->sales_id == 'all') {
				foreach($sales->result_array() as $row_sales) {
					$sql = "select 
									sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
									sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card,sim_nota_order.sales
							from
									sim_salescounter,sim_nota_order
							where
									sim_nota_order.tgl_terima = $tanggal and								
									sim_salescounter.no_id = sim_nota_order.sales and sim_nota_order.sales = '" .  $row_sales['no_id'] . "' order by sim_nota_order.sales;";
					
					$query = $this->db->query($sql);
					if($query->num_rows() != 0) {
						foreach($query->result_array() as $row) {
							if($row['sales'] == $row_sales['no_id']) {
								$nama = $row_sales['nama'];
								if($x == 0) {
									$sc = "<tr>
											<td style='text-align:left' colspan='7'>
												<h2 style='margin-left:25px'>" . strtoupper($nama) . "</h2>
											</td>
											</tr>" . $this->_cetakLaporanTanggalSekarang2($sql) . $this->_cetakPayment($this->paymentQuery,$row_sales['no_id']);
								}
								$x++;
							}
						}
						$result = $sc . $result;
						$x = 0;
					}
					else {
						$query = $this->db->query($this->paymentQuery);						
						if($query->num_rows() != 0) {
							$nama = $row_sales['nama'];
							foreach($query->result_array() as $row) {
								if($nama == $row['sales']) {
									$sc = "<tr>
												<td style='text-align:left' colspan='7'>
													<h2 style='margin-left:25px'>".strtoupper($nama)."</h2>
												</td>
											</tr>" . $this->_cetakPayment($this->paymentQuery,$row_sales['no_id']);
									$result = $sc . $result;
								}
							}
						}
					}
				}
			}
			else {
				$sql = "select 
							sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
							sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card,sim_nota_order.sales
						from
							sim_salescounter,sim_nota_order
						where
							sim_nota_order.tgl_terima = $tanggal and								
							sim_salescounter.no_id = sim_nota_order.sales and sim_nota_order.sales = '" .  $this->sales_id . "' order by sim_nota_order.sales;";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
							$nama = $row['nama'];
							if($x == 0) {
								$sc = "<tr>
										<td style='text-align:left' colspan='7'>
											<h2 style='margin-left:25px'>" . strtoupper($nama) . "</h2>
										</td>
										</tr>" . $this->_cetakLaporanTanggalSekarang2($sql) . $this->_cetakPayment($this->paymentQuery,$this->sales_id);
							}
							$x++;
						
					}
					$result = $sc . $result;
					$x = 0;
				}
				else {
					$row_sales = $this->_getSalesCounter($this->sales_id);
					$query = $this->db->query($this->paymentQuery);
					$row_sales = $row_sales->row_array();
					$nama = $row_sales['nama'];
					if($query->num_rows() != 0) {
						$row = $query->row_array();
							$sc = "<tr>
										<td style='text-align:left' colspan='7'>
											<h2 style='margin-left:25px'>".strtoupper($nama)."</h2>
										</td>
									</tr>" . $this->_cetakPayment($this->paymentQuery,$this->sales_id);
							$result = $sc . $result;
					}
				}
			}
			return $result ;
		}
		
		private function _cetakLaporanTanggalSekarang2($sql) {
			$query_tanggal_sekarang = $this->db->query($sql);
			$result = '';
			$totaluangmuka = 0;
			$total = 0;
			$td = "";
			if($query_tanggal_sekarang->num_rows() != 0) {
				foreach($query_tanggal_sekarang->result_array() as $row) {
					$totaluangmuka += $row['jumlah_uangmuka'];
					$total += $row['total'];
					$td .= "<td></td>";
					$td .= "<td style='text-align:center'>" . $row['tgl_terima'] . "</td>";
					$td .= "<td style='text-align:center'>" . $row['nota'] . "</td>";
					$td .= "<td style='text-align:right'>" . number_format($row['jumlah_uangmuka'],2,',','.') . "</td>";
					$td .= "<td style='text-align:right'>" . number_format($row['total'],2,',','.') . "</td>";
					$td .= "<td style='text-align:center'>" . $row['Keterangan'] . "</td>";
					$td .= "<td style='text-align:center'>" . (trim($row['card']) == '' ? "Tunai" : $row['card']) . "</td>";
					if($td != "") {
						$result .= "<tr>". $td . "</tr>"; 
						$td="";
					}
				}	
			}
			$this->totaluangmuka = $totaluangmuka;
			$this->totaltagihan = $total;
			$query_tanggal_sekarang->free_result();
			return $result;
		}
		
		
		private function _cetakTanggalTerima($tanggalterima) {
			$result = "";
			$tanggal = $tanggalterima;
			$x = 0;
			$sales = $this->_getSalesCounter();
			$sc = "";
			$nama = "";
			if($this->sales_id == 'all') {
				foreach($sales->result_array() as $row_sales) {
					$sql = "select 
									sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
									sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card,sim_nota_order.sales
							from
									sim_salescounter,sim_nota_order
							where
									sim_nota_order.tgl_terima = $tanggal and								
									sim_salescounter.no_id = sim_nota_order.sales and sim_nota_order.sales = '" .  $row_sales['no_id'] . "' order by sim_nota_order.sales;";
					$query = $this->db->query($sql);
					if($query->num_rows() > 0) {
						foreach($query->result_array() as $row) {
							if($row['sales'] == $row_sales['no_id']) {
								$nama = $row_sales['nama'];
								if($x == 0) {
									$sc = "<tr>
											<td style='text-align:left' colspan='7'>
												<h2 style='margin-left:25px'>" . strtoupper($nama) . "</h2>
											</td>
											</tr>" . $this->_cetakLaporanTanggalSekarang2($sql) . $this->_cetakPayment($this->paymentQuery,$row_sales['no_id']);
								}
								$x++;
							}
						}
						$result = $sc . $result;
						$x = 0;
					}
					else {
						$query = $this->db->query($this->paymentQuery . " and sales_no='" . $row_sales['no_id'] . "' order by nota");
						if($query->num_rows() != 0) {
							$nama = $row_sales['nama'];
							$row = $query->row_array();
							if($nama == $row['sales']) {
								$sc = "<tr>
											<td style='text-align:left' colspan='7'>
												<h2 style='margin-left:25px'>".strtoupper($nama)."</h2>
											</td>
										</tr>" . $this->_cetakPayment($this->paymentQuery,$row_sales['no_id']);
								$result = $sc . $result;
							}
						}
					}
				}
			}
			else {
				#yang ini perlu ditambahin apa lagi ya ?
				$sql = "select 
							sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
							sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card,sim_nota_order.sales
						from
							sim_salescounter,sim_nota_order
						where
							sim_nota_order.tgl_terima = $tanggal and								
							sim_salescounter.no_id = sim_nota_order.sales and sim_nota_order.sales = '" .  $this->sales_id . "' order by sim_nota_order.sales;";
				$query = $this->db->query($sql);
				$num_rows = $query->num_rows();
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
							$nama = $row['nama'];
							if($x == 0) {
								$sc = "<tr>
										<td style='text-align:left' colspan='7'>
											<h2 style='margin-left:25px'>" . strtoupper($nama) . "</h2>
										</td>
										</tr>" . $this->_cetakLaporanTanggalSekarang2($sql) . $this->_cetakPayment($this->paymentQuery,$this->sales_id);
							}
							$x++;
						
					}
					$result = $sc . $result;
					$x = 0;
				}
				else {
					$row_sales = $this->_getSalesCounter($this->sales_id);
					$query = $this->db->query($this->paymentQuery);
					$row_sales = $row_sales->row_array();
					$nama = $row_sales['nama'];
					if($query->num_rows() != 0) {
						$row = $query->row_array();
							$sc = "<tr>
										<td style='text-align:left' colspan='7'>
											<h2 style='margin-left:25px'>".strtoupper($nama)."</h2>
										</td>
									</tr>" . $this->_cetakPayment($this->paymentQuery,$this->sales_id);
							$result = $sc . $result;
					}
				}
			}
			return $result ;
		}
		
		private function _cetakTanggalAwalAkhir($tanggalawal,$tanggalakhir) {
			$result = "";
			$x = 0;
			$sales = $this->_getSalesCounter();
			$sc = "";
			$nama = "";
			if($this->sales_id == 'all') {
				foreach($sales->result_array() as $row_sales) {
					$sql = "select 
									sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
									sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card,sim_nota_order.sales
							from
									sim_salescounter,sim_nota_order
							where
									sim_nota_order.tgl_terima between $tanggalawal and $tanggalakhir and								
									sim_salescounter.no_id = sim_nota_order.sales and sim_nota_order.sales = '" .  $row_sales['no_id'] . "' order by sim_nota_order.sales;";
					$query = $this->db->query($sql);
					if($query->num_rows() > 0) {
						foreach($query->result_array() as $row) {
							if($row['sales'] == $row_sales['no_id']) {
								$nama = $row_sales['nama'];
								if($x == 0) {
									$sc = "<tr>
											<td style='text-align:left' colspan='7'>
												<h2 style='margin-left:25px'>" . strtoupper($nama) . "</h2>
											</td>
											</tr>" . $this->_cetakLaporanTanggalSekarang2($sql) . $this->_cetakPayment($this->paymentQuery,$row_sales['no_id']);
								}
								$x++;
							}
						}
						$result = $sc . $result;
						$x = 0;
					}
					else {
						$query = $this->db->query($this->paymentQuery . " and sales_no='" . $row_sales['no_id'] . "' order by nota");
						if($query->num_rows() != 0) {
							$nama = $row_sales['nama'];
							$row = $query->row_array();
							if($nama == $row['sales']) {
								$sc = "<tr>
											<td style='text-align:left' colspan='7'>
												<h2 style='margin-left:25px'>".strtoupper($nama)."</h2>
											</td>
										</tr>" . $this->_cetakPayment($this->paymentQuery,$row_sales['no_id']);
								$result = $sc . $result;
							}
						}
					}
				}
			}
			else {
				$sql = "select 
							sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
							sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card,sim_nota_order.sales
						from
							sim_salescounter,sim_nota_order
						where
							sim_nota_order.tgl_terima between $tanggalawal and $tanggalakhir and							
							sim_salescounter.no_id = sim_nota_order.sales and sim_nota_order.sales = '" .  $this->sales_id . "' order by sim_nota_order.sales;";
				$query = $this->db->query($sql);
				$num_rows = $query->num_rows();
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
							$nama = $row['nama'];
							if($x == 0) {
								$sc = "<tr>
										<td style='text-align:left' colspan='7'>
											<h2 style='margin-left:25px'>" . strtoupper($nama) . "</h2>
										</td>
										</tr>" . $this->_cetakLaporanTanggalSekarang2($sql) . $this->_cetakPayment($this->paymentQuery,$this->sales_id);
							}
							$x++;
						
					}
					$result = $sc . $result;
					$x = 0;
				}
				else {
					$row_sales = $this->_getSalesCounter($this->sales_id);
					$query = $this->db->query($this->paymentQuery);
					$row_sales = $row_sales->row_array();
					$nama = $row_sales['nama'];
					if($query->num_rows() != 0) {
						$row = $query->row_array();
							$sc = "<tr>
										<td style='text-align:left' colspan='7'>
											<h2 style='margin-left:25px'>".strtoupper($nama)."</h2>
										</td>
									</tr>" . $this->_cetakPayment($this->paymentQuery,$this->sales_id);
							$result = $sc . $result;
					}
				}
			}
			return $result ;
		}
		
		
		private function _cetakLaporanNota() {
			$result = "";
			$x = 0;
			$sc = "";
			$nama = "";
			$nonota = $this->db->escape(trim($this->input->post('nota')));
			$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card,sim_nota_order.sales
					from
						sim_salescounter,sim_nota_order
					where
						sim_salescounter.no_id = sim_nota_order.sales and sim_nota_order.nota = $nonota order by nota";
					$query = $this->db->query($sql);
			if($query->num_rows() > 0) {
				foreach($query->result_array() as $row) {
					$nama = $row['nama'];
					if($x == 0) {
						$sc = "<tr>
								<td style='text-align:left' colspan='7'>
									<h2 style='margin-left:25px'>" . strtoupper($nama) . "</h2>
								</td>
								</tr>" . $this->_cetakLaporanTanggalSekarang2($sql) . $this->_cetakPayment($this->paymentQuery,$this->input->post('nota'),'nota');
					}	
					$x++;
				}
				$result = $sc . $result;
				$x = 0;
			}
			
			return $result ;
		}
		
		# ini buat proses payment tanggal sekarang
		private function _cetakPayment($sql,$sc,$param="") {
			$_sql = "";
			if($sc != 'all')
				$_sql = $sql . " and sales_no='".$sc."' order by nota";
			else
				$_sql = $sql . ' order by nota';
			
			if($param == 'nota') {
				$_sql = $sql;
			}
				
			$query_payment = $this->db->query($_sql);
			$result = '';
			$totaluangmukapelunasan = 0;
			$total = 0;
			$rowtotal = '';
			$td = "";
		
			if($query_payment->num_rows() != 0) {
				foreach($query_payment->result_array() as $row) {
					$totaluangmukapelunasan += $row['dibayar'];
					$td .= "<td></td>";
					$td .= "<td style='text-align:center'>" . $row['tanggal'] . "</td>";
					$td .= "<td style='text-align:center'>" . $row['nota'] . "</td>";
					$td .= "<td style='text-align:right'>" . number_format($row['dibayar'],2,',','.') . "</td>";
					$td .= "<td style='text-align:right'>" . number_format(0,2,',','.') . "</td>";
					$td .= "<td style='text-align:center'>" . "Pelunasan" . "</td>";
					$td .= "<td style='text-align:center'>" . (trim($row['card']) == '' ? "Tunai" : $row['card']) . "</td>";
					if($td != "") {
						$result = "<tr>". $td . "</tr>"; 
						$td = "";
					}
				}	
			}
			$this->totaluangmukapelunasan = $totaluangmukapelunasan + $this->totaluangmuka;
			$rowtotal = "<tr>
							<td colspan='3' style='text-align:right;font-weight:bold;'>Sub Total :</td>"."
							<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>".number_format($this->totaluangmukapelunasan,2,',','.')."</td>"."
							<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>".number_format($this->totaltagihan,2,',','.')."</td>"."
							<td colspan='2'></td>"."
						</tr>";
					
			$this->grandtotalpelunasan += $this->totaluangmukapelunasan;
			$this->grandtotal += $this->totaltagihan;
			$this->totaluangmukapelunasan = 0;
			$this->totaluangmuka = 0;
			$this->totaltagihan = 0;
			$query_payment->free_result();
			return $result . $rowtotal;
		}
		
		function preview() {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$action = $this->input->post('action');
				if($action != '') {
					if($action == 'tanggal-sekarang') {
						$sc = $this->input->post('sc');
						$tanggalsekarang = date('Y-m-d');
						if($sc != 'all') {
							$this->buttonParameter = 'action=tanggal-sekarang&sc='.$sc;
							$sc = $this->db->escape($sc);
							$tanggalsekarang = $this->db->escape($tanggalsekarang);
							$this->paymentQuery .= " where sales_no= $sc and tanggal =  $tanggalsekarang order by nota";
						}
						else {
							$this->buttonParameter = 'action=tanggal-sekarang&sc=all';
							$tanggalsekarang = $this->db->escape($tanggalsekarang);
							$this->paymentQuery .= " where tanggal = $tanggalsekarang order by nota ";
						}
						echo $this->_prosesTanggalSekarang($sc);
					}
					if($action == 'nota') {
						$nonota = trim($this->input->post('nota'));
						$this->buttonParameter = 'action=nota';
						$nonota = $this->db->escape($nonota);
						$this->paymentQuery .= " where nota= $nonota order by nota";
						echo $this->_prosesNota($nonota);
					}
					if($action == 'tanggal-terima') {
					
						$tanggalterima = to_mysql_date(trim($this->input->post('tanggalterima')));
						$sc = trim($this->input->post('sc'));
						
						if($sc != 'all') {
							$this->buttonParameter = 'action=tanggal-terima&sc='.$sc;
							$sc = $this->db->escape($sc);
							$tanggalterima = $this->db->escape($tanggalterima);
							$this->paymentQuery .= " where sales_no= $sc and tanggal= $tanggalterima order by nota";
						}
						else {
							$this->buttonParameter = 'action=tanggal-terima&sc=all';
							$tanggalterima = $this->db->escape($tanggalterima);
							$this->paymentQuery .= " where tanggal= $tanggalterima order by nota";
						}
							
						echo $this->_prosesTanggalTerima($tanggalterima,$sc);
					}
					if($action == 'tanggal-awal-akhir') {
						# ini dari tanggal mssql dirubah ke format tanggal mysql
						$tanggalawal = to_mysql_date(trim($this->input->post('tglawal')));
						$tanggalakhir = to_mysql_date(trim($this->input->post('tglakhir')));		
						$sc = trim($this->input->post('sc'));
						
						if($sc != 'all') {
							$this->buttonParameter = 'action=tanggal-awal-akhir&sc='.$sc;
							$sc = $this->db->escape($sc);
							$tanggalawal = $this->db->escape($tanggalawal);
							$tanggalakhir = $this->db->escape($tanggalakhir);
							$this->paymentQuery .= " where SP.sales_no= $sc and tanggal between  $tanggalawal 
												    and $tanggalakhir  order by nota;";
						}
						else {
							$this->buttonParameter = 'action=tanggal-awal-akhir&sc=all';
							$tanggalawal = $this->db->escape($tanggalawal);
							$tanggalakhir = $this->db->escape($tanggalakhir);
							$this->paymentQuery .= " where tanggal between $tanggalawal and $tanggalakhir  order by nota;";
						}
						echo $this->_prosesTanggalAwalDanAkhir($tanggalawal,$tanggalakhir,$sc);
					}
				}
			}
		}
		
		
		function cetak() {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$action = $this->input->post('action');
				if($action != '') {
					if($action == 'tanggal-sekarang') {
						$sc = trim($this->input->post('sc'));
						$tanggalsekarang = date('Y-m-d');
			
						if($sc != 'all') {
							$this->sales_id = $sc;
							$this->buttonParameter = 'action=tanggal-sekarang&sc=' . $sc;
							$tanggalsekarang = $this->db->escape($tanggalsekarang);
							$sc = $this->db->escape($sc);
							$this->paymentQuery .= " where tanggal =  and SP.sales_no= $sc ";
						}
						else { 
							$this->sales_id='all';
							$this->buttonParameter = 'action=tanggal-sekarang&sc=all';
							$tanggalsekarang = $this->db->escape($tanggalsekarang);
							$this->paymentQuery .= " where tanggal = $tanggalsekarang ";
						}
						echo $this->_cetaklaporan('tanggal-sekarang',$this->_getDate());
					}
					if($action == 'nota') {
						$nonota = $this->db->escape(trim($this->input->post('nota')));
						$this->paymentQuery .= " where nota= $nonota order by nota";
						$this->buttonParameter = 'action=nota';
						$this->_cetakLaporan('nota','tanggal----');
					}
					if($action == 'tanggal-terima') {
						$tanggalterima = to_mysql_date(trim($this->input->post('_tanggalterima')));
						$sc = $this->input->post('sc');
						
						if($sc != 'all') {
							$this->sales_id = $sc;
							$this->buttonParameter = 'sc='.$sc.'&action=tanggal-terima';
							$tanggalterima = $this->db->escape($tanggalterima);
							$this->paymentQuery .= " where sales_no=".$this->db->escape($sc)." and tanggal=$tanggalterima ";
						}
						else {
							$this->sales_id='all';
							$this->buttonParameter = 'action=tanggal-terima&sc=all';
							$tanggalterima = $this->db->escape($tanggalterima);
							$this->paymentQuery .= " where tanggal=$tanggalterima ";
						}	
						echo $this->_cetaklaporan('tanggal-terima',$this->input->post('_tanggalterima'));
					}
					if($action == 'tanggal-awal-akhir') {
						$tanggalawal = to_mysqL_date(trim($this->input->post('_tanggalawal')));
						$tanggalakhir = to_mysqL_date(trim($this->input->post('_tanggalakhir')));
						$sc = trim($this->input->post('sc'));	
						if($sc != 'all') {
							$this->sales_id = $sc;
							$this->buttonParameter = 'action=tanggal-awal-akhir&sc='.$sc;
							$tanggalawal = $this->db->escape($tanggalawal);
							$tanggalakhir = $this->db->escape($tanggalakhir);
							$sc = $this->db->escape($sc);
							$this->paymentQuery .= " where sales_no=$sc and tanggal between $tanggalawal and $tanggalakhir ";
						}
						else {
							$this->sales_id = 'all';
							$this->buttonParameter = 'action=tanggal-awal-akhir&sc='.$sc;
							$tanggalawal = $this->db->escape($tanggalawal);
							$tanggalakhir = $this->db->escape($tanggalakhir);
							$this->paymentQuery .= " where tanggal between $tanggalawal and $tanggalakhir ";
						}
						echo $this->_cetakLaporan('tanggal-awal-akhir',$this->input->post('tanggalawal') . '---'.$this->input->post('tanggalakhir'));
					}
				}
			}
		}
		
		private function _prosesTanggalAwalDanAkhir($tanggalawal,$tanggalakhir,$sc) {
			$salescounter = "";
			if($sc != 'all')
				$salescounter = " sim_nota_order.sales = $sc and ";
			$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.tgl_terima between $tanggalawal and $tanggalakhir and $salescounter								
						sim_salescounter.no_id = sim_nota_order.sales order by nota;";
			$query = $this->db->query($sql);
			return $this->_printTable($query);
		}
		
		private function _prosesTanggalTerima($tanggalterima,$sc) {
			$tanggalterima = $this->db->escape(trim($tanggalterima) . ' 12:00 AM');
			$salescounter = "";
			if($sc != 'all') 
				$salescounter = " sim_nota_order.sales = " . $this->db->escape($sc) . " and ";
			$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.tgl_terima = $tanggalterima and $salescounter								
						sim_salescounter.no_id = sim_nota_order.sales order by nota;";
			$query = $this->db->query($sql);
			return $this->_printTable($query);
			
		}
		
		private function _prosesNota($nonota) {
			$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.nota = $nonota and								
						sim_salescounter.no_id = sim_nota_order.sales order by nota;";
			$query = $this->db->query($sql);
			return $this->_printTable($query);
			
		}
		
		private function _prosesTanggalSekarang($sc) {
			$tanggal = date('Y-m-d');
			$tanggal = $this->db->escape($tanggal);
			if($sc == 'all') {				
				$result = '';
				$sc = $this->db->escape($sc);
				$sql = "select 
								sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
								sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
						from
								sim_salescounter,sim_nota_order
						where
								sim_nota_order.tgl_terima = $tanggal and								
								sim_salescounter.no_id = sim_nota_order.sales order by nota;";
				$query = $this->db->query($sql);
				return $this->_printTable($query);
			}
			else {
				$result = '';
				$sc = $this->db->escape($sc);
				$sql = "select 
								sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
								sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
						from
								sim_salescounter,sim_nota_order
						where
								sim_nota_order.tgl_terima = $tanggal and
								sim_nota_order.sales = $sc and
								sim_salescounter.no_id = sim_nota_order.sales;";
				$query = $this->db->query($sql);
				return $this->_printTable($query);
			}
		}			
		
		private function _processPayment($sql,$no=0) {
			$result = "";
			$query = $this->db->query($sql);
			
			if($query->num_rows() != 0) {
				foreach($query->result_array() as $row) {
					$no++;
					$this->totaluangmuka += $row['dibayar'];
					$result .= '<tr>
									<td class="table-row-center">'.$no.'</td>
									<td class="table-row-center">'.$row['nota'].'</td>
									<td class="table-row-center">'.$row['tanggal'].'</td>
									<td class="table-row-right">'.number_format($row['dibayar'],2,',','.').'</td>
									<td class="table-row-right">'.number_format("0",2,',','.').'</td>
									<td class="table-row-center">'.$row['sales'].'</td>
									<td class="table-row-center">Pelunasan</td>
									<td class="table-row-center">'. (trim($row['card']) == '' ? "Tunai" : $row['card']) .'</td>'.
								'</tr>';

				}
			}
			$query->free_result();
			return $result;
		}
		
		private function _printTable($query) {
			$result = '';
			$no = 0;
			$totaltagihan=0;
			$totaluangmuka = 0;
			if($query->num_rows() != 0) {
				foreach($query->result_array() as $row) {
					$no++;
					$this->totaltagihan += $row['total'];
					$this->totaluangmuka += $row['jumlah_uangmuka'];
					$result .= '<tr>
									<td class="table-row-center">'.$no.'</td>
									<td class="table-row-center">'.$row['nota'].'</td>								
									<td class="table-row-center">'.$row['tgl_terima'].'</td>
									<td class="table-row-right">'.number_format($row['jumlah_uangmuka'],2,',','.').'</td>
									<td class="table-row-right">'.number_format($row['total'],2,',','.').'</td>
									<td class="table-row-center">'.$row['nama'].'</td>
									<td class="table-row-center">'.$row['Keterangan'].'</td>
									<td class="table-row-center">'. (trim($row['card']) == '' ? "Tunai" : $row['card']) .'</td>
								</tr>';    
				}
			}
			
			$buttonCetak = '
						<div style="margin-top: 10px;">
							<input 
								type="button" 
								class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" 
								onclick="javascript:buttonCetak_onClick(event,\''.$this->buttonParameter.'\')" 
								value="Cetak" 
								name="buttonCetak" 
								id="buttonCetak">
						</div>';
			
			$result .= $this->_processPayment($this->paymentQuery,$no);
			$result .= '<tr>
							<td colspan="3" class="table-row-right" style="font-weight:bold">Total : </td>
							<td id="totaluangmuka" class="table-row-right" style="background-color:yellow;font-weight:bold">'.number_format($this->totaluangmuka,2,',','.').'</td>
							<td id="totaljumlah" class="table-row-right" style="background-color:yellow;font-weight:bold">'.number_format($this->totaltagihan,2,',','.').'</td>
							<td colspan="3"></td>
						</tr>';
			return '<table style="border-collapse: collapse; border: 1px solid silver; width: 100%;" border="1">
						<tr>
							<td class="table-header">No</td>
							<td class="table-header">Nota</td>
							<td class="table-header">Tanggal Terima</td>
							<td class="table-header">Uang Muka</td>
							<td class="table-header">Jumlah</td>
							<td class="table-header">Sales Counter</td>
							<td class="table-header">Keterangan</td>
							<td class="table-header">Status</td>
						</tr>'.$result.
					'</table>' . $buttonCetak;
		}	
	} # end class