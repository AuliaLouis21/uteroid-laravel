<?php 
	class KlienOrder extends Controller {
		private $total = 0;
		private $jumlah = 0;
		private $buttonParameter = "";
		function KlienOrder() {
			parent::Controller();
			if($this->session->userdata('islogin') == '') {
				redirect(base_url().index_page().'/login');
			}
		}
		
		function preview() {
			$action = $this->input->post('action');
			if($action != "" and $action != null) {
				switch($action) {
					case "nota" :
						$this->buttonParameter = "nota";
						echo $this->_printTable($this->_processNota());
						break;
					case "tanggal-terima" :
						$this->buttonParameter = "tanggal-terima";
						echo $this->_printTable($this->_processTanggalTerima());
						break;
					case "tanggal-sekarang" :
						$this->buttonParameter = "tanggal-sekarang";
						echo $this->_printTable($this->_processTanggalSekarang());
						break;
					case "tanggal-awal-akhir" :
						$this->buttonParameter = "tanggal-awal-akhir";
						echo $this->_printTable($this->_processTanggalAwalAkhir());
						break;
					case "klien" :
						$this->buttonParameter = "klien";
						echo $this->_printTable($this->_processKlien());
						break;
					case "tema" :
						$this->buttonParameter = "tema";
						echo $this->_printTable($this->_processTema());
						break;
					case "perusahaan" :	
						$this->buttonParameter = "perusahaan";
						echo $this->_printTable($this->_processPerusahaan());
						break;
				}
			}
		}
		
		function cetak() {
			$action = $this->input->post('action');
			if($action != "" and $action != null) {
				switch($action) {
					case "nota" :
						echo $this->_cetakTable($this->_cetakNota(),"Nomor Nota : " . $this->input->post('nota'));
						break;
					case "tanggal-terima" :
						echo $this->_cetakTable($this->_cetakTanggalTerima(),"Tanggal Terima : " . $this->input->post('_tanggalterima'));
						break;
					case "tanggal-sekarang" :
						echo $this->_cetakTable($this->_cetakTanggalSekarang(),"Tanggal : " . date('m-d-Y'));
						break;
					case "tanggal-awal-akhir" :
						echo $this->_cetakTable($this->_cetakTanggalAwalAkhir(),"Antara Tanggal : " . $this->input->post('_tanggalawal') . " S/D Tanggal : " . $this->input->post('_tanggalakhir'));
						break;
					case "klien" :
						echo $this->_cetakTable($this->_cetakKlien(),"Nama Klien : " . $this->_getClient($this->input->post('klien')));
						break;
					case "tema" :
						echo $this->_cetakTable($this->_cetakTema(),"Tema : " . $this->input->post("tema"));
						break;
					case "perusahaan" :
						echo $this->_cetakTable($this->_cetakPerusahaan(),"Perusahaan : " . $this->input->post("perusahaan"));
						break;
				}
			}
		}
		
		private function _processTanggalSekarang() {
			$klien = $this->input->post('klien');
			$tanggal = date('m/d/Y');
			$retval = "";
			$td = "";
			$i=0;			
			if($klien == 'all') {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima='" . $tanggal . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows()!=0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_terima']."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_selesai']."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			else {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima='" . $tanggal . "'" . " and klien='".$klien."' " .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".substr($row['tgl_terima'],0,-7)."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".substr($row['tgl_selesai'],0,-7)."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}		
		
		private function _processTanggalTerima() {
			$this->total =0;
			$this->jumlah = 0;
			$tanggal_terima = $this->input->post('tanggalterima');
			$retval = "";
			$td = "";
			$i=0;
			$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima='" . $tanggal_terima . "'" .
                                " order by SO.tgl_terima,nota";
			$query = $this->db->query($sql);
			if($query->num_rows()!=0) {
				foreach($query->result_array() as $row) {
					$this->total += $row['total'];
					$this->jumlah += $row['jumlah'];
					$td .= "<td style='text-align:center'>". ++$i ."</td>";
					$td .= "<td style='text-align:center'>".$row['tgl_terima']."</td>";
					$td .= "<td style='text-align:center'>".$row['nota']."</td>";
					$td .= "<td>".$row['jeneng']."</td>";
					$td .= "<td>".$row['nama_produk']."</td>";
					$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
					$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
					$td .= "<td style='text-align:center'>".$row['tgl_selesai']."</td>";
					if($td != "") {
						$retval .= "<tr>".$td."</tr>";
						$td = "";
					}
				}
				$query->free_result();				
			}			
			return $retval;
		}
		
		private function _processKlien() {			
			$klien = $this->input->post('klien');
			$retval = "";
			$td = "";
			$i = 0;
			if($klien != 'all') {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where klien='" . $klien . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_terima']."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_selesai']."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
						
					}
					$query->free_result();
					
				}
			}
			return $retval;
		}
		
		private function _processNota() {
			$nota = "";
			$nota = $this->input->post('nota');
			$retval = "";
			$td = "";
			$i=0;
			if($nota != "") {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where nota='" . $nota . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_terima']."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_selesai']."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}
		
		private function _processTanggalAwalAkhir() {
			$tglawal = $this->input->post('tglawal');
			$tglakhir = $this->input->post('tglakhir');
			$retval = "";
			$td = "";
			$i=0;
			$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima between '".$tglawal."' and '".$tglakhir."' ".
                                " order by SO.tgl_terima,nota";
			$query = $this->db->query($sql);
			if($query->num_rows()!=0) {
				foreach($query->result_array() as $row) {
					$this->total += $row['total'];
					$this->jumlah += $row['jumlah'];
					$td .= "<td style='text-align:center'>". ++$i ."</td>";
					$td .= "<td style='text-align:center'>".$row['tgl_terima']."</td>";
					$td .= "<td style='text-align:center'>".$row['nota']."</td>";
					$td .= "<td>".$row['jeneng']."</td>";
					$td .= "<td>".$row['nama_produk']."</td>";
					$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
					$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
					$td .= "<td style='text-align:center'>".$row['tgl_selesai']."</td>";
					if($td != "") {
						$retval .= "<tr>".$td."</tr>";
						$td = "";
					}
				}
				$query->free_result();
			}	
			return $retval;
		}
		
		private function _processTema() {
			$tema = "";
			$tema = $this->input->post('tema');
			$retval = "";
			$td = "";
			$i=0;
			if($tema != "") {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where tema LIKE '" . $tema . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_terima']."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_selesai']."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}
		
		private function _processPerusahaan() {
			$perusahaan = "";
			$perusahaan = $this->input->post('perusahaan');
			$retval = "";
			$td = "";
			$i=0;
			if($perusahaan != "") {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where perusahaan LIKE '" . $perusahaan . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_terima']."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$row['tgl_selesai']."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}
		
		private function _printTable($content) {
			$button = '<div style="margin-top: 10px;">
							<input 
								type="button" 
								class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" 
								onclick="javascript:buttonCetak_onClick(event,\''.$this->buttonParameter.'\')" 
								value="Cetak" 
								name="buttonCetak" 
								id="buttonCetak">
						</div>';						
			$tr_total = "<tr><td colspan='5' style='text-align:center'>Total</td><td style='font-weight:bold;text-align:right;background-color:yellow;'>"
							.$this->jumlah."</td><td style='font-weight:bold;text-align:right;background-color:yellow;'>".number_format($this->total,2,",",".")."</td><td></td></tr>";
			$table = '<table style="border-collapse: collapse; border: 1px solid silver; width: 100%;" border="1">
						<tr>
							<td class="table-header">No</td>
							<td class="table-header">Tanggal</td>
							<td class="table-header">No.Nota</td>
							<td class="table-header">Nama</td>
							<td class="table-header">Produk</td>
							<td class="table-header">Jumlah</td>
							<td class="table-header">Harga</td>
							<td class="table-header">Deadline</td>
						</tr>'. $content . $tr_total .'
					</table>' . $button;
			$this->total =0;
			$this->jumlah = 0;
			return $table;
		}
		
		private function _cetakTanggalSekarang() {
			$klien = $this->input->post('klien');
			$tanggal = date('m/d/Y');
			$retval = "";
			$td = "";
			$i=0;			
			if($klien == 'all') {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima='" . $tanggal . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows()!=0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['alamat']."</td>";
						$td .= "<td>".$row['perusahaan']."</td>";
						$td .= "<td>".$row['telepon']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			else {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima='" . $tanggal . "'" . " and klien='".$klien."' " .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['alamat']."</td>";
						$td .= "<td>".$row['perusahaan']."</td>";
						$td .= "<td>".$row['telepon']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}

		private function _cetakTanggalTerima() {
			$this->total =0;
			$this->jumlah = 0;
			$tanggal_terima = $this->input->post('_tanggalterima');
			$retval = "";
			$td = "";
			$i=0;
			$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima='" . $tanggal_terima . "'" .
                                " order by SO.tgl_terima,nota";
			$query = $this->db->query($sql);
			if($query->num_rows()!=0) {
				foreach($query->result_array() as $row) {
					$this->total += $row['total'];
					$this->jumlah += $row['jumlah'];
					$td .= "<td style='text-align:center'>". ++$i ."</td>";
					$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
					$td .= "<td style='text-align:center'>".$row['nota']."</td>";
					$td .= "<td>".$row['jeneng']."</td>";
					$td .= "<td>".$row['alamat']."</td>";
					$td .= "<td>".$row['perusahaan']."</td>";
					$td .= "<td>".$row['telepon']."</td>";
					$td .= "<td>".$row['nama_produk']."</td>";
					$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
					$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
					$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
					if($td != "") {
						$retval .= "<tr>".$td."</tr>";
						$td = "";
					}
				}
				$query->free_result();				
			}			
			return $retval;
		}
		
		private function _cetakKlien() {
			$klien = $this->input->post('klien');
			$retval = "";
			$td = "";
			$i = 0;
			if($klien != 'all') {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where klien='" . $klien . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['alamat']."</td>";
						$td .= "<td>".$row['perusahaan']."</td>";
						$td .= "<td>".$row['telepon']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}
		
		private function _cetakNota() {
			$nota = "";
			$nota = $this->input->post('nota');
			$retval = "";
			$td = "";
			$i=0;
			if($nota != "") {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where nota='" . $nota . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['alamat']."</td>";
						$td .= "<td>".$row['perusahaan']."</td>";
						$td .= "<td>".$row['telepon']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}
		
		private function _cetakTanggalAwalAkhir() {
			$tglawal = $this->input->post('_tanggalawal');
			$tglakhir = $this->input->post('_tanggalakhir');
			$retval = "";
			$td = "";
			$i=0;
			$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where SO.tgl_terima between '".$tglawal."' and '".$tglakhir."' ".
                                " order by SO.tgl_terima,nota";
			$query = $this->db->query($sql);
			if($query->num_rows()!=0) {
				foreach($query->result_array() as $row) {
					$this->total += $row['total'];
					$this->jumlah += $row['jumlah'];
					$td .= "<td style='text-align:center'>". ++$i ."</td>";
					$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
					$td .= "<td style='text-align:center'>".$row['nota']."</td>";
					$td .= "<td>".$row['jeneng']."</td>";
					$td .= "<td>".$row['alamat']."</td>";
					$td .= "<td>".$row['perusahaan']."</td>";
					$td .= "<td>".$row['telepon']."</td>";
					$td .= "<td>".$row['nama_produk']."</td>";
					$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
					$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
					$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
					if($td != "") {
						$retval .= "<tr>".$td."</tr>";
						$td = "";
					}
				}
				$query->free_result();
			}	
			return $retval;
		}
		
		private function _cetakTema() {
			$tema = "";
			$tema = $this->input->post('tema');
			$retval = "";
			$td = "";
			$i=0;
			if($tema != "") {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where tema LIKE '" . $tema . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['alamat']."</td>";
						$td .= "<td>".$row['perusahaan']."</td>";
						$td .= "<td>".$row['telepon']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}
		
		private function _cetakPerusahaan() {
			$perusahaan = "";
			$perusahaan = $this->input->post('perusahaan');
			$retval = "";
			$td = "";
			$i=0;
			if($perusahaan != "") {
				$sql = "select SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,* from sim_nota_order SO left outer join sim_nota_order_detail SD " .
                                " on SO.no_id=SD.no_nota left outer join sim_produk SP" .
                                " on SD.no_produk=SP.no_id left outer join sim_client SC" .
                                " on SO.klien=SC.no_id where perusahaan LIKE '" . $perusahaan . "'" .
                                " order by SO.tgl_terima,nota";
				$query = $this->db->query($sql);
				if($query->num_rows() != 0) {
					foreach($query->result_array() as $row) {
						$this->total += $row['total'];
						$this->jumlah += $row['jumlah'];
						$td .= "<td style='text-align:center'>". ++$i ."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_terima'],0,-7))."</td>";
						$td .= "<td style='text-align:center'>".$row['nota']."</td>";
						$td .= "<td>".$row['jeneng']."</td>";
						$td .= "<td>".$row['alamat']."</td>";
						$td .= "<td>".$row['perusahaan']."</td>";
						$td .= "<td>".$row['telepon']."</td>";
						$td .= "<td>".$row['nama_produk']."</td>";
						$td .= "<td style='text-align:right'>".$row['jumlah']."</td>";
						$td .= "<td style='text-align:right'>".number_format($row['total'],2,',','.')."</td>";
						$td .= "<td style='text-align:center'>".$this->_formatDate(substr($row['tgl_selesai'],0,-7))."</td>";
						if($td != "") {
							$retval .= "<tr>".$td."</tr>";
							$td = "";
						}
					}
					$query->free_result();
				}
			}
			return $retval;
		}
		
		private function _cetakTable($content,$keterangan = "") {
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
												<h1>Laporan Klien Order</h1>
												<h4>".$keterangan."</h4>
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
											<center>No</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Tanggal</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Nota</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Nama Klien</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Alamat</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Perusahaan</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Telepon</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Produk</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Jumlah</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Harga</center>
										</td>
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444;'>
											<center>Deadline</center>
										</td>
									</tr>" . $content . "									
									<tr>
										<td colspan='8' style='text-align:right;font-weight:bold;'>Grand Total :</td>"."
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>".$this->jumlah."</td>"."
										<td style='border-top:2px solid #444444;border-bottom:2px solid #444444; text-align:right;'>".number_format($this->total,2,',','.')."</td>"."
										<td></td>"."
									</tr>
								</table>
							</div>
					   </div>";	
			echo $result;
		}
		
		private function _getDate() {
			$result = '';
			$tanggal = date('d');
			$bulan = date('n');
			$tahun = date('Y');
			
			$vaBulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			
			return $tanggal . ' ' . $vaBulan[$bulan - 1] . ' ' . $tahun;
		}
		
		private function _formatDate($tanggal) {
			$tanggal = explode(" ",$tanggal);
			return $tanggal[1] . " " . $tanggal[0] . " " . $tanggal[2];
		}
		
		private function _getClient($client) {
			$query = $this->db->query("select * from sim_client where no_id='".$client."'");
			$row = $query->row_array();
			$client = $row['nama'];
			$query->free_result();
			return $client;
		}
		
	}