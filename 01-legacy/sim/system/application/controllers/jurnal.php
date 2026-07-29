<?php
	class Jurnal extends Controller {
		function Jurnal() {
			parent::Controller();
			$this->load->helper('form');
			if($this->session->userdata('islogin') != 'true') {
				redirect(site_url().'/login/');
				die;
			}
		}
		
		function index() {
			$viewdata = array();
			$viewdata['user'] = $this->session->userdata('users');
			$this->load->view('jurnal/index',$viewdata);
		}
		
		function glreport() {
			$viewdata = array();
			$viewdata['user'] = $this->session->userdata('users');
			$viewdata['account_group'] = $this->_get_account_group();
			$this->load->view("jurnal/glreport",$viewdata);
		}
		
		function glposting() {
			$viewdata = array();
			$viewdata['user'] = $this->session->userdata('users');
			$this->load->view("jurnal/glposting",$viewdata);
		}
		
		function service() {
			$param = $this->input->post('param');
			switch($param) {
				case "get_account_group" :
					$this->_process_get_account_group();
					break;
				case "get_nama_account_group" :
					$this->_process_get_nama_account_group();
					break;
				case "get_transaksi_hari_ini" :
					$this->_process_get_transaksi_hari_ini();
					break;
				case "get_transaksi_tanggal_awal_akhir" :
					$this->_process_get_transaksi_tanggal_awal_akhir();
					break;
				case "get_keterangan" :
					$this->_process_get_keterangan();
					break;
			}
		}	
		
		function preview() {
			$total 									= 0;
			$balance 								= 0;
			$debet									= 0;
			$kredit									= 0;
			$total_sim_general_report_1 = 0;
			$tanggal_akhir					= get_parameter("tanggal_akhir");
			$tanggal_awal						= get_parameter("tanggal_awal");
			$all_checkbox_value			= explode(";",get_parameter("all_checkbox_value"));
			$checkbox								= "";
			$kode_account 					= "";
			$nama_account						= "";
			$va_sim_general_report 	= array();
			foreach($all_checkbox_value as $value) {
				$checkbox .= $value;
				$kode_account .= "$value, ";
			}
			$kode_account = substr($kode_account,0,-2);
			$nama_account = $this->_get_nama_account($kode_account);
			require_once "lib/fpdf/fpdf.php";
			$pdf = new FPDF('P','pt','A4');
			$pdf->Open();
			$pdf->addPage();
			
			/* header */
			$pdf->Image('resources/images/utero.jpg',30,15,70,70,'jpg');
			$pdf->Image('resources/images/logo-utero.jpg',100,15,155,70,'jpg');
			
			$pdf->setFont("ARIAL",'B',13);
			$pdf->text(260,50,"GENERAL LEDGER REPORT");
			
			$pdf->setFont("ARIAL",'B',6);
			$pdf->text(285,60,$this->_get_formatted_date($tanggal_awal) . " S/D " . $this->_get_formatted_date($tanggal_akhir));
			$pdf->text(485,77,"PRINT DATE : " . strftime("%d-%m-%Y %H:%M"));
			
			$pdf->Line(30,90,575,90);
			$pdf->setLineWidth(1);
			$pdf->Line(30,92,575,92);
			/* end header */
			if(strlen($nama_account) > 100) {
				$nama_account = substr($nama_account,0,100) . " ...";
			}
			if(strlen($kode_account) > 100) {
				$kode_account = substr($kode_account,0,100) . " ...";
			}
			
			$pdf->setFont("ARIAL",'',8);
			$pdf->text(40,105,"Kode Account"); 
			$pdf->text(100,105,":");
			$pdf->text(105,105,"$kode_account");
			$pdf->text(40,115,"Nama Account"); 
			$pdf->text(100,115,":");
			$pdf->text(105,115,"$nama_account"); #100+ 3
			$pdf->setLineWidth(0);
			$pdf->Line(30,122,575,122);
			
			$pdf->setFont("ARIAL",'B',8);
			$pdf->text(45,133,"Tanggal"); 
			$pdf->text(90,133,"Reference"); 
			$pdf->text(140,133,"Keterangan"); 
			$pdf->text(400,133,"Debet"); 
			$pdf->text(465,133,"Kredit"); 
			$pdf->text(520,133,"Saldo"); 
			$pdf->Line(30,139,575,139);
			
			$pdf->setFont("ARIAL",'',6);
			
			$this->_delete_from_sim_general_report();
			
			foreach($all_checkbox_value as $value) {
				# step 1 saldo
				$sql = "select sum(total) as total,status from sim_general_ledger where account=$value and tanggal < '"
					.$this->_to_mssql_date($tanggal_awal)."' group by status";
				$column_name = "total";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					if($row['status'] == 1) {
						$total += $row['total'];
					}
					if($row['status'] == 2) {
						$total -= $row['total'];
					}
				}
				$query->free_result();
				
				# step 2 bank
				$sql = "select sum(jumlah_uangmuka)as total 
								from sim_nota_order SO left outer join sim_bank SB on SO.status=SB.no_id left outer join sim_client SK on SO.klien=SK.no_id 
								where SB.no_acc=" .$value. " and tgl_terima < '".$this->_to_mssql_date($tanggal_awal)."'";
				$total += $this->_query_step($sql,$column_name);
				
				# step 3 pelunasan
				$sql = "select sum(dibayar)as total  
								from sim_pembayaran SO left outer join sim_bank SB on SO.bank=SB.no_id left outer join sim_client SK on SO.klien_no=SK.no_id left outer join sim_bank SA on SA.no_id=SO.bank 
								where SA.no_acc=" .$value . " and tanggal<'" .$this->_to_mssql_date($tanggal_awal). "'";
				$total += $this->_query_step($sql,$column_name);
				
				# step 4 pendapatan produk
				$column_name = "tot";
				$sql = "select sum(SD.total)as tot 
								from sim_nota_order SO left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota left outer join sim_produk SP on SD.no_produk=SP.no_id left outer join sim_produk_kategori SK on SP.no_kategori=SK.no_id left outer join sim_client SC on SO.klien=SC.no_id 
								where SK.no_acc=" .$value. " and tgl_terima<'" .$this->_to_mssql_date($tanggal_awal). "'";
				$total += $this->_query_step($sql,$column_name);
				
				# step 5 kas penjualan
				if(intval($value) == 3) {
					# transaksi nota
					$sql = "select sum(jumlah_uangmuka) as tot 
									from sim_nota_order SO left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where tgl_terima<'" .$this->_to_mssql_date($tanggal_awal). "' and status=0";
					$total += $this->_query_step($sql,$column_name);
					
					# pembayaran nota
					$sql = "select sum(dibayar) as tot 
									from sim_pembayaran SO left outer join sim_salescounter SS on SO.sales_no=SS.no_id 
									where tanggal<'" .$this->_to_mssql_date($tanggal_awal).  "' and bank=0";
					$total += $this->_query_step($sql,$column_name);
					
					# cancel nota
					$sql = "select sum(diambil) as tot 
									from sim_cancel SO left outer join sim_salescounter SS on SO.sales_no=SS.no_id 
									where tanggal<'" .$this->_to_mssql_date($tanggal_awal). "'";
					$total -= $this->_query_step($sql,$column_name);
				}
				
				# step 6 biaya produksi 
				$sql = "select sum(SP.total) as tot 
								from sim_pembelian_detail SP left outer join sim_pembelian SK on SP.no_pembelian=SK.no_id left outer join sim_suplaier SS on SK.suplier=SS.no_id 
								where tanggal<'" .$this->_to_mssql_date($tanggal_awal). "' and SP.no_acc=" .$value;
				$total -= $this->_query_step($sql,$column_name);
				
				# step 7 pembelian
				$sql = "select sum(uangmuka) as tot 
								from sim_pembelian SP left outer join sim_suplaier SS on SP.suplier=SS.no_id 
								where tanggal<". $this->db->escape($this->_to_mssql_date($tanggal_awal)) ." and SP.no_acc=" .$value;
				$total -= $this->_query_step($sql,$column_name);

				# step 8 bayar
				$sql = "select sum(dibayar) as tot 
								from sim_pembelian_lunas SP left outer join sim_suplaier SS on SP.suplier=SS.no_id left outer join sim_pembelian SN on SN.no_id=SP.no_pembelian 
								where SP.tanggal<" .$this->db->escape($this->_to_mssql_date($tanggal_awal)) ." and SP.no_acc=" .$value;
				$total -= $this->_query_step($sql,$column_name);
				
				# step 9 return
				$sql = "select sum(dibayar) as tot 
								from sim_pembelian_return SP left outer join sim_suplaier SS on SP.suplier=SS.no_id left outer join sim_pembelian SN on SN.no_id=SP.no_pembelian 
								where SP.tanggal<" .$this->db->escape($this->_to_mssql_date($tanggal_awal)) ." and SP.no_acc=" .$value;
				$total -= $this->_query_step($sql,$column_name);
				
				#$va_sim_general_report[] = array(0,$value,'saldo awal',$total);
				# step 10 simpan
				$this->db->query("insert into temp_sim_general_report values(0,$value,null,null,'Saldo Awal',null,null,$total,1)");
			}
			$last_text_position = 150;
			$pdf->text(200,$last_text_position,"Saldo Awal");
			$pdf->text(520,$last_text_position,number_format($total ,2, '.', ','));
			
			
			
			# ------------- detail -------------
			foreach($all_checkbox_value as $value) {
				$no_acc = 0;
				$no_acc = $value;
				# step 1
				$sql = "select * from temp_sim_general_report where account = $no_acc and no_id = 0";
				foreach($this->db->query($sql)->result_array() as $row) {
					$total_sim_general_report_1 += $row['saldo'];
					$balance += $row['saldo'];
				}
				
				# step 2 GL
				$sql = "select * from sim_general_ledger where account = $no_acc and tanggal between '".$this->_to_mssql_date($tanggal_awal)
					."' and '".$this->_to_mssql_date($tanggal_akhir)."' order by tanggal";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql = "insert into temp_sim_general_report values(
							$created_id,
							".$row['account'].",
							'".$row['tanggal']."',
							'".$row['reference']."',".$this->db->escape($row['keterangan']);
							
					if($row['status'] == 1) {
						$sql .= ",".$row['total'];
						$total += $row['total'];
					}
					else {
						$sql .= ",0";
					}
					
					if($row['status'] == 2) {
						$sql .= ",".$row['total'];
						$total -= $row['total'];
					}
					else {
						$sql .= ",0";
					}
					$sql .= "," . $total . "," . 2 . ")";
					$query2 = $this->db->query($sql);
				}
				$query->free_result();
				
				# step 3 penjualan bank
				$sql = "select * from sim_nota_order SO left outer join sim_bank SB" .
								" on SO.status=SB.no_id left outer join sim_client SK" .
                " on SO.klien=SK.no_id" .
                " where SB.no_acc=" .$no_acc.
                " and tgl_terima>='" .$this->_to_mssql_date($tanggal_awal). "'" .
                " and tgl_terima<='" .$this->_to_mssql_date($tanggal_akhir). "'" .
                " order by tgl_terima,nota";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql = "insert into temp_sim_general_report values($created_id,".
						"'".$row['account']."','".$row['tanggal']."','".$row['reference']."',".$this->db->escape($row['keterangan']);
					if($row['status'] == 1) {
						$sql .= ",".$row['total'];
						$total += $row['total'];
					}
					else {
						$sql .= ",0";
					}
					
					if($row['status'] == 2) {
						$sql .= ",".$row['total'];
						$total -= $row['total'];
					}
					else {
						$sql .= ",0";
					}
					$sql .= "," . $total . "," . 2 . ")";
					$query2 = $this->db->query($sql);
				}
				$query->free_result();
				
				# step 3 penjualan bank
				 $sql = "select * from sim_nota_order SO left outer join sim_bank SB" .
                  " on SO.status=SB.no_id left outer join sim_client SK" .
                  " on SO.klien=SK.no_id" .
                  " where SB.no_acc=" .$no_acc . 
                  " and tgl_terima>='" .$this->_to_mssql_date($tanggal_awal)."'" .
                  " and tgl_terima<='" .$this->_to_mssql_date($tanggal_akhir). "'" .
                  " order by tgl_terima,nota";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
						$created_id = $this->_create_id("temp_sim_general_report","no_id");
						$sql = "insert into temp_sim_general_report values(
												$created_id,".$row['no_acc'].",'".$row['tgl_terima']."','".
												$row['nota']."',".$this->db->escape($row['nama']. " --> " .$row['tema']) .",";
						
						$sql .= ",".$row['jumlah_uangmuka'];
						$total += $row['jumlah_uangmuka'];
						
						$sql .= ",0";
						$sql .= ",".$total.",". 2 .")";
						$this->db->query($sql);
				}
				$query->free_result();
				
				# step 4 pelunasan bank
				$sql = "select SO.nota as note,* from sim_pembayaran SO left outer join sim_nota_order SB" .
									" on SO.no_nota=SB.no_id left outer join sim_client SK" .
                  " on SO.klien_no=SK.no_id" .
                  " left outer join sim_bank SA" .
                  " on SA.no_id=SO.bank" .
                  " where SA.no_acc=".$no_acc.
                  " and SO.tanggal>='"  .$this->_to_mssql_date($tanggal_awal)."'" .
                  " and SO.tanggal<='"  .$this->_to_mssql_date($tanggal_akhir). "'" .
                  " order by tanggal,SO.nota";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql = "insert into sim_general_report values(" .$created_id .
                    "," .$no_acc.
										",'" .$row['tanggal'].
                    "'," .$this->db->escape($row['note']). "," .$this->db->escape($row['nama']. " --> " .$row['tema']);
					$sql .= ",".$row['dibayar'];
					$total += $row['dibayar'];
					$sql .= ",0";
					$sql .= ",".$total.",". 2 .")";
					$this->db->query($sql);
				}
				$query->free_result();
				
				# step 5 pendapatan produk
				$sql = "select * from sim_nota_order SO left outer join" .
                  " sim_nota_order_detail SD on SO.no_id=SD.no_nota" .
                  " left outer join sim_produk SP" .
                  " on SD.no_produk=SP.no_id" .
                  " left outer join sim_produk_kategori SK on SP.no_kategori=SK.no_id" .
                  " left outer join sim_client SC" .
                  " on SO.klien=SC.no_id" .
                  " where SK.no_acc=" .$no_acc.
                  " and tgl_terima>='" .$this->_to_mssql_date($tanggal_awal)."'" .
                  " and tgl_terima<='" .$this->_to_mssql_date($tanggal_akhir)."'" .
                  " order by tgl_terima";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql = "insert into sim_general_report values(" .$created_id.
                    "," .$row['no_acc'].
                    ",'" .$row['tgl_terima'].
                    "','" .$row['nota']. "'," .($this->db->escape($row['nama']. " --> " .$row['tema']));
					$sql .= ",".$row['total'];
					$total += $row['total'];
					
					$sql .= ",0";
					$sql .= ",".$total.",". 2 .")";
					$this->db->query($sql);
				}
				$query->free_result();
				
				# step 6 kas penjualan transaksi nota
				if($no_acc == 3) {
					# detail
					$sql = "select sum(jumlah_uangmuka) as tot,nama,tgl_terima from sim_nota_order SO left outer join sim_salescounter SS" .
										" on SO.sales=SS.no_id where tgl_terima>='" .$this->_to_mssql_date($tanggal_awal). "'" .
										" and tgl_terima<='" .$this->_to_mssql_date($tanggal_akhir)."'" .
										" and status=0" .
										" group by nama,tgl_terima" .
										" order by tgl_terima";
					$query = $this->db->query($sql);
					foreach($query->result_array() as $row) {
						$created_id = $this->_create_id("temp_sim_general_report","no_id");
						$sql = "insert into sim_general_report values(" .$created_id.
										"," . 3 .
										",'" .$row['tgl_terima'].
										"','" . "\"\"".  "'," . $this->db->escape("TRANSAKSI NOTA DARI " .$row['nama']);
						$sql .= ",".$row['tot'];
						$total += $row['tot'];
						
						$sql .= ",0";
						$sql .= ",".$total.",". 1 . ")";
						$this->db->query($sql);
					}
					$query->free_result();
					
					# kas penjualan pelunasan nota
					$sql = "select sum(dibayar) as total,nama,tanggal from sim_pembayaran SO left outer join sim_salescounter SS" .
										" on SO.sales_no=SS.no_id where tanggal>='" .$this->_to_mssql_date($tanggal_awal)."'".
										" and tanggal<='".$this->_to_mssql_date($tanggal_akhir)."'".
										" and bank=0" .
										" group by nama,tanggal" .
										" order by tanggal";
					$query = $this->db->query($sql);
					foreach($query->result_array() as $row) {
						$created_id = $this->_create_id("temp_sim_general_report","no_id");
						$sql = "insert into sim_general_report values(" .$no_acc.
											"," . 3 .
											",'" .$row['tanggal'].
											"','" . "\"\"". "'," . $this->db->escape("PELUNASAN NOTA DARI " .$row['nama']);
						$sql .= ",".$row['total'];
						$total += $row['total'];
						
						$sql .= ",0";
						$sql .= ",".$total.",". 1 . ")";
						$this->db->query($sql);

					}
					$query->free_result();
					
					# cancel nota
					$sql = "select sum(diambil) as total,nama,tanggal from sim_cancel SO left outer join sim_salescounter SS" .
										" on SO.sales_no=SS.no_id where tanggal>='" .$this->_to_mssql_date($tanggal_awal)."'".
										" and tanggal<='" .$this->_to_mssql_date($tanggal_akhir)."'".
										" group by nama,tanggal".
										" order by tanggal";
					$query = $this->db->query($sql);
					foreach($query->result_array() as $row) {
						$created_id = $this->_create_id("temp_sim_general_report","no_id");
						$sql = "insert into sim_general_report values(". $created_id .
											"," . 3 .
											",'" .$row['tanggal'].
											"','"  . "\"\"". "',".$this->db->escape("CANCEL NOTA DARI " .$row['nama']);
						$sql .= ",0";
						$total -= $row['total'];
						
						$sql .= ",".$row['total'];
						$sql .= ",".$total.",". 2 .")";
						$this->db->query($sql);
					}
					$query->free_result();
				}
				
						# kas pembelian
				$sql = "select * from sim_pembelian SP left outer join sim_suplaier SS" .
									" on SP.suplier=SS.no_id" .
									" where tanggal>=" .$this->db->escape($this->_to_mssql_date($tanggal_awal)).
									" and tanggal<=" .$this->db->escape($this->_to_mssql_date($tanggal_akhir)).
									" and SP.no_acc=" .$no_acc.
									" and SP.uangmuka>0" .
									" order by SP.tanggal";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql = "insert into sim_general_report values(" .$created_id.
										"," .$no_acc.
										",'" .$row['tanggal'].
										"','" .$row['nota']. "'," . $this->db->escape("PEMBELIAN KE " . $row['nama'].  " - INV: "  .$row['invoice']);
					$sql .= ",0";
          $total -= $row['uangmuka'];
          $sql .= ",".$row['uangmuka'];
          $sql .= "," .$total ."," . 2 . ")";
					$this->db->query($sql);
				}
				$query->free_result();
					
				# pembelian pelunasan
				$sql = "select SP.tanggal as tgl,* from sim_pembelian_lunas SP left outer join sim_suplaier SS" .
									" on SP.suplier=SS.no_id" .
									" left outer join sim_pembelian SN on SN.no_id=SP.no_pembelian" .
									" where SP.tanggal>=" .$this->db->escape($this->_to_mssql_date($tanggal_awal)).
									" and SP.tanggal<=" .$this->db->escape($this->_to_mssql_date($tanggal_akhir)).
									" and SP.no_acc=" .$no_acc.
									" order by SP.tanggal";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql = "insert into sim_general_report values(" .$created_id.
										"," .$no_acc.
										",'" .$row['tgl'].
										"','" .$row['nota']. "'," . $this->db->escape($row['keterangan'] ." " . $row['nama'] . " - INV: " . $row['invoice']);
					$sql .= ",0";
					$total -= $row['dibayar'];
					$sql .= ",".$row['dibayar'];
					$sql .= ",".$total.",". 2 . ")";
					$this->db->query($sql);
				}
				$query->free_result();
					
				# return pembelian
				$sql = "select SP.tanggal as tgl,* from sim_pembelian_return SP left outer join sim_suplaier SS" .
									" on SP.suplier=SS.no_id" .
									" left outer join sim_pembelian SN on SN.no_id=SP.no_pembelian" .
									" where SP.tanggal>=".$this->db->escape($this->_to_mssql_date($tanggal_awal)).
									" and SP.tanggal<=" .$this->db->escape($this->_to_mssql_date($tanggal_akhir)).
									" and SP.no_acc=" .$no_acc.
									" order by SP.tanggal";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql= "insert into sim_general_report values(" .$created_id.
                   "," .$no_acc.
                   ",'" .$row['tgl'].
                   "','".$row['nota']. "'," .$this->db->escape($row['keterangan']. " " .$row['nama']. " - INV: " .$row['invoice']);
									
					$total += $row['dibayar'];
					$sql .= ",".$row['dibayar'];
					$sql .= ",0";
					$sql .= ",".$total.",". 1 .")";
					$this->db->query($sql);
				}
        $query->free_result();        

				# biaya produksi
				$sql = "select SP.total as tot,* from sim_pembelian_detail SP left outer join sim_pembelian SK".
									" on SP.no_pembelian=SK.no_id" .
									" left outer join sim_suplaier SS" .
									" on SK.suplier=SS.no_id" .
									" where tanggal>=" .$this->db->escape($this->_to_mssql_date($tanggal_awal)).
									" and tanggal<=" .$this->db->escape($this->_to_mssql_date($tanggal_akhir)).
									" and SP.no_acc=" .$no_acc.
									" order by tanggal";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$created_id = $this->_create_id("temp_sim_general_report","no_id");
					$sql = "insert into sim_general_report values(" .$created_id.
										"," .$no_acc.
										",'" .$row['tanggal'].
										"','" .$row['nota']. "'," .$this->db->escape($row['keterangan']. "-->" .$row['nama']);
					$sql .= ",".$row['tot'];
					$total += $row['tot'];
					$sql .= ",0";
					$sql .= ",".$total.",". 1 .")";
					$this->db->query($sql);
				}
				$query->free_result();
				
				# update saldo
				$sql = "select * from sim_general_report where no_id<>0 order by tanggal,no_id";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $row) {
					$sql =  "update sim_general_report set saldo=" . ($balance + $row['debit'] - $row['credit'] ).
                     " where no_id=" . $row['no_id'];
           $this->db->query($sql);
				}
				$query->free_result();
				
			} # end foreach
			
			# update saldo
			$last_text_position = 160;
			$query = $this->db->query("select * from temp_sim_general_report where no_id != 0");
			foreach($query->result_array() as $row) {
				$pdf->text(45,$last_text_position,strftime("%d-%m-%Y",time($row['tanggal'])));
				if(trim($row['refrence']) != "") 
					$pdf->text(91,$last_text_position,$row['refrence']);
				else
					$pdf->text(91,$last_text_position,"-");
				$pdf->text(140,$last_text_position,$row['keterangan']);
				$pdf->text(400,$last_text_position,number_format($row['debit'],2,',','.'));
				$pdf->text(465,$last_text_position,number_format($row['credit'],2,',','.'));
				$pdf->text(520,$last_text_position,number_format($row['saldo'],2,',','.'));
				if($last_text_position >= 810) {
					$last_text_position = 30;
					$pdf->addPage();
					$pdf->Line(30,10,575,10);
					$pdf->setFont("ARIAL",'B',8);
					$pdf->text(45,20,"Tanggal"); 
					$pdf->text(90,20,"Reference"); 
					$pdf->text(140,20,"Keterangan"); 
					$pdf->text(400,20,"Debet"); 
					$pdf->text(465,20,"Kredit"); 
					$pdf->text(520,20,"Saldo"); 
					$pdf->Line(30,25,575,25);
					$pdf->setFont("ARIAL",'',6);
				}
				$last_text_position += 10;
			}
			$query->free_result();	
			$pdf->output();
		}
		
		private function _process_get_transaksi_hari_ini() {
			$query = $this->db->query("select SG.no_id as no,SA.account as acc,SA.no_id as no_acc,* from sim_general_ledger SG left outer join sim_account SA on SG.account=SA.no_id where SG.tanggal>='" .strftime("%m/%d/%Y"). "' order by tanggal,SG.no_id");
			$this->load->view('jurnal/_process_get_transaksi_hari_ini',array('query'=>$query,"i"=>0,"total_debet"=>0,"total_kredit"=>0));
		}
		
		private function _process_get_transaksi_tanggal_awal_akhir() {
			$tanggal_awal = $this->db->escape($this->_to_mssql_date($this->input->post('tanggal_awal')));
			$tanggal_akhir = $this->db->escape($this->_to_mssql_date($this->input->post('tanggal_akhir')));
			$query = $this->db->query("select SG.no_id as no,SA.account as acc,SA.no_id as no_acc,* from sim_general_ledger SG left outer join sim_account SA on SG.account=SA.no_id where SG.tanggal between $tanggal_awal and $tanggal_akhir order by tanggal,SG.no_id");
			$this->load->view('jurnal/_process_get_transaksi_hari_ini',array('query'=>$query,"i"=>0,"total_debet"=>0,"total_kredit"=>0));
		}
		
		private function _process_get_keterangan() {
			$tanggal_awal = $this->db->escape($this->_to_mssql_date($this->input->post('tanggal_awal')));
			$tanggal_akhir = $this->db->escape($this->_to_mssql_date($this->input->post('tanggal_akhir')));
			$keterangan = $this->db->escape("%".$this->input->post('keterangan')."%") ;
			$query = $this->db->query("select SG.no_id as no,SA.account as acc,SA.no_id as no_acc,* from sim_general_ledger SG left outer join sim_account SA on SG.account=SA.no_id where SG.tanggal>= $tanggal_akhir and upper(keterangan) like $keterangan order by tanggal,SG.no_id");
			$this->load->view('jurnal/_process_get_transaksi_hari_ini',array('query'=>$query,"i"=>0,"total_debet"=>0,"total_kredit"=>0));
		}
		
		private function  _get_account_group() {
			$retval = array();
			$query = $this->db->query("select * from sim_account_group");
			$retval['-'] = "-";
			foreach($query->result_array() as $row) {
				$retval[$row['no_id']] = $row['account_group'];
			}
			$query->free_result();
			return $retval;
		}
		
		private function _process_get_account_group() {
			$id = $this->input->post('id');
			$sql = "";
			if($id == "-") $sql = "select * from sim_account";
			else $sql = "select * from sim_account where no_group = $id";
			$query = $this->db->query($sql);
			if($query->num_rows() != 0) 
				$this->load->view('jurnal/_process_get_account_group',array('query'=>$query));
			else 
				echo "false";
		}
		
		private function _process_get_nama_account_group() {
			$id = trim($this->input->post("id"));
			$sql = "";
			if($id == "") $sql = "select * from sim_account";
			else $sql = "select * from sim_account where account LIKE '%$id%'";
			$query = $this->db->query($sql);
			if($query->num_rows() != 0) 
				$this->load->view('jurnal/_process_get_nama_account_group',array('query'=>$query));
			else 
				echo "false";
		}
		
		private function _get_formatted_date($tanggal) {
			$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli',
			'Agustus','September','Oktober','November','Desember');
			$tanggal = explode("-",$tanggal);
			return $tanggal[0]." ".$bulan[$tanggal[1]-1]." ".$tanggal[2];
		}
	
		private function _to_mssql_date($date) {
			$date = explode("-",$date);
			return $date[1]."/".$date[0]."/".$date[2];
		}
	
		private function _query_step($sql,$column_name) {
			$result = 0;
			$query = $this->db->query($sql);
			foreach($query->result_array() as $row) {
				$result += $row[$column_name];
			}
			$query->free_result();
			return $result;
		}
		
		private function _get_nama_account($kode_account) {
			$result = "";
			$query = $this->db->query("select * from sim_account where no_id in ($kode_account)");
			foreach($query->result_array() as $row) {
				$result .= $row['account'] . ", ";
			}
			$query->free_result();
			return substr($result,0,-2);
		}
		
		private function _create_id($table_name,$column_name) {
			$result = "";
			$query = $this->db->query("select max($column_name) as sno from $table_name");
			$row = $query->row_array();
			$result = $row['sno'] + 1;
			$query->free_result();
			return $result;
		}
		
		private function _delete_from_sim_general_report() {
			$query = $this->db->query("delete from temp_sim_general_report");
		}
	}