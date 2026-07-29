<?php
class NotaRecord extends Controller {
	function NotaRecord() {
		parent::Controller();
		if($this->session->userdata('islogin') == '') {
			redirect(base_url().index_page().'/login/');
			die;
		}
	}
	
	function index() {
		$viewdata['user'] = $this->session->userdata('users');
		$this->load->view('notarecord/index',$viewdata);
	}
	
	function show() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
			$param 				= trim($this->input->post('param'));
			$nota				= trim($this->db->escape($this->input->post('nota')));
			$tanggal_terima 	= trim($this->input->post('tanggal-terima'));
			$tanggal_awal 		= trim($this->input->post('tanggal-awal'));
			$tanggal_akhir 		= trim($this->input->post('tanggal-akhir'));
			$sql_plus = "";
			if($this->session->userdata('isadmin') != 'true') {
				$sql_plus = ' and sales = ' . $this->session->userdata('users_code');
			}
			switch($param) {
				case "tanggal-sekarang" :
					$tanggal_sekarang = date('Y-m-d');
					$query = $this->db->query("select * from sim_nota_order where tgl_terima = '$tanggal_sekarang' $sql_plus");
					
					if($query->num_rows() != 0) {
						$this->load->view('notarecord/show/table',array('query'=>$query));
					}
					break;
				
				case "no-nota" :
					$query = $this->db->query("select * from sim_nota_order where nota = $nota $sql_plus");
					if($query->num_rows() != 0) {
						$this->load->view('notarecord/show/table',array('query'=>$query));
					}
					break;
				
				case "tanggal-terima" :
					$tanggal_terima = $this->db->escape(to_mysql_date($tanggal_terima));
					$query = $this->db->query("select * from sim_nota_order where tgl_terima = $tanggal_terima $sql_plus");
					if($query->num_rows() != 0) {
						$this->load->view('notarecord/show/table',array('query'=>$query));
					}
					break;
					
				case "tanggal-awal-akhir" :
					$tanggal_awal = $this->db->escape(to_mysql_date($tanggal_awal));
					$tanggal_akhir = $this->db->escape(to_mysql_date($tanggal_akhir));
					$query = $this->db->query("select * from sim_nota_order where tgl_terima between $tanggal_awal and $tanggal_akhir $sql_plus");
					if($query->num_rows() != 0) {
						$this->load->view('notarecord/show/table',array('query'=>$query));
					}
					break;
			}
		}
	}
	
	function cetak() {
		$row_gap = 49;
		$id = get_parameter('id');
		$query = $this->db->query("select * from sim_nota_order where no_id = $id");
		if($query->num_rows() != 0) {
		
			$query_order = $this->db->query("select * from sim_nota_order where no_id = $id");
			$row_order = $query->row_array();
			
			$query_detail = $this->db->query("select * from sim_nota_order_detail where no_nota = $id"); 
			
			$query_klien = $this->db->query("select * from sim_client where no_id = ".$row_order['klien']);
			$row_klien = $query_klien->row_array();
			
			$query_salescounter = $this->db->query('select * from sim_salescounter where no_id = '.$row_order['sales']);
			$row_salescounter = $query_salescounter->row_array();
			require_once('lib/fpdf/fpdf.php');
			$pdf = new FPDF('L','mm',array(140,220));
			$pdf->Open();
			$pdf->addPage();
			
			# bagian header coy 
			$pdf->Image('resources/images/utero.jpg',20,2.5,20,20,'jpg');
			$pdf->setFont("ARIAL",'',7);
			$pdf->text(100,5,"Head Office");
			$pdf->text(88,8,"Graha Soekarno Hatta 2B Malang");
			$pdf->text(83,11,"Telp.(0341) 408 408 - Fax. (0341) 417 417");
			$pdf->text(86,14,"email : marketing_utero@yahoo.com");
			$pdf->text(95,17,"www.uterogroup.com");
			$pdf->Image('resources/images/logo-utero.jpg',161,2.5,43,18,'jpg');
			$pdf->setFont("ARIAL",'B',7);
			$pdf->text(186,21,"Mlg-01 BB 01");
			$pdf->setFont("ARIAL",'',7);
			#bagian header selesai coy
			
			#bagian keterangan atas kiri coy
			$pdf->text(5,27,"Nama");
			$pdf->text(27,27,":");
			$pdf->text(29,27,strtoupper($row_klien['nama']));
			
			$pdf->text(5,30,"Alamat");
			$pdf->text(27,30,":");
			$pdf->text(29,30,strtoupper($row_klien['alamat']));
			
			$pdf->text(5,33,"No.Telp");
			$pdf->text(27,33,":");
			$pdf->text(29,33,strtoupper($row_klien['telepon']));
			
			$pdf->text(5,36,"Perusahaan");
			$pdf->text(27,36,":");
			$pdf->text(29,36,strtoupper($row_klien['perusahaan']));
			
			$pdf->text(5,39,"Tema");
			$pdf->text(27,39,":");
			$pdf->text(29,39,strtoupper($row_order['tema']));
			
			$pdf->setFont("ARIAL",'B',8);
			$pdf->text(5,44,"Nota Bukti Pengambilan Barang");
			$pdf->setFont("ARIAL",'',7);
			
			#bagian keterangan atas kanan coy
			$pdf->text(142,27,"No.Nota");
			$pdf->text(164,27,":");
			$pdf->text(166,27,$row_order['nota']);
			
			$pdf->text(142,30,"Sales Counter");
			$pdf->text(164,30,":");
			$pdf->text(166,30,strtoupper($row_salescounter['nama']));
			
			$pdf->text(142,33,"Terima Tgl");
			$pdf->text(164,33,":");
			$pdf->text(166,33,date('d M Y',time($row_order['tgl_selesai'])));
			
			$pdf->text(142,36,"Selesai Tgl");
			$pdf->text(164,36,":");
			$pdf->text(166,36,date('d M Y',time($row_order['tgl_selesai'])));
			
			$pdf->setFont("ARIAL",'B',8);
			$pdf->text(142,44,"Date Print");
			$pdf->text(164,44,":");
			$pdf->text(166,44,date('d M Y'));
			
			#bagian tabelnya coy
			$pdf->setFont("ARIAL",'B',7);
			$pdf->Line(5,45,215,45);
			
			$pdf->text(10,48,"Banyak");
			$pdf->text(80,48,"Keterangan");
			$pdf->text(155,48,"Harga");
			$pdf->text(180,48,"Jumlah");
			$pdf->text(200,48,"Disc %");

			$pdf->setFont("ARIAL",'',7);
			$pdf->Line(5,49,215,49);
			
			
			foreach($query_detail->result_array() as $row) {
				$row_gap += 3;
				$query_produk = $this->db->query('select nama from sim_produk where no_id = '.$row['no_produk']);
				if($query_produk->num_rows() != 0) {
					$row_produk = $query_produk->row_array();
					$pdf->text(13,$row_gap,$row['jumlah']);
					$pdf->text(40,$row_gap,$row_produk['nama']);
					$pdf->text(155,$row_gap,number_format($row['harga']));
					$pdf->text(180,$row_gap,$row['jumlah']);
					$pdf->text(202,$row_gap,$row['diskon']);
					$query_produk->free_result();
				}
			}
			
			#bagian bawah coy
			$pdf->setFont("ARIAL",'B',7);
			$pdf->Line(5,105,215,105);
			$pdf->text(20,110,"Klien");
			$pdf->Line(10,130,37,130);
			
			$pdf->text(60,110,"Sales");
			$pdf->Line(50,130,77,130);
			
			$pdf->text(135,110,"Total");
			$pdf->text(155,110,":");
			$pdf->text(185,110,number_format($row_order['total']));
			
			$pdf->text(135,115,"Dibayar");
			$pdf->text(155,115,":");
			$pdf->text(185,115,number_format($row_order['jumlah_uangmuka']));
			
			$pdf->text(135,120,"Kekurangan");
			$pdf->text(155,120,":");
			$pdf->text(185,120,number_format($row_order['sisa']));
			
			if(($row_order['total'] - $row_order['jumlah_uangmuka']) == 0) {
				$pdf->setFont('ARIAL','B',25);
				$pdf->text(90,115,'LUNAS');
				$pdf->setFont("ARIAL",'B',7);
			}
			
			if($this->session->userdata('isadmin') == 'true') {
				$pdf->text(5,135,'DAPATKAN STIKER CANTIK UTERO , UNTUK PESANAN APA SAJA      No. Rek. BCA. 8160788306 a.n Dadik Wahyu');
			}
			$pdf->output();
		}
	}
}