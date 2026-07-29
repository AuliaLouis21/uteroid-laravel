<?php
# 1. cek format tanggal sebelum insert atau update transaksi
class TransaksiNota extends Controller {
	function TransaksiNota() {
		parent::Controller();
		$this->load->helper('date');
		if($this->session->userdata('islogin') != 'true') {
			redirect(base_url().index_page().'/login/');
			die;
		}
	}
	
	function save() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$param = trim($this->input->post('param'));
			if(!empty($param)) {
				$nama = $this->db->escape(trim($this->input->post('_nama')));
				$alamat = $this->db->escape(trim($this->input->post('_alamat')));
				$telepon = $this->db->escape(trim($this->input->post('_telepon')));
				$perusahaan = $this->db->escape(trim($this->input->post('_perusahaan')));
				$email = $this->db->escape(trim($this->input->post('_email')));
				$kota = $this->db->escape(trim($this->input->post('_kota')));
				$id = $this->db->escape(trim($this->input->post('id')));
				switch($param) {
					case "add" :
						$query = $this->db->query('select * from sim_client order by no_id desc');
						$row = $query->row_array();
						$id = $row['no_id'] + 1;
						$query->free_result();
						if(!empty($id)) {
							$query = $this->db->query("insert into sim_client(no_id,nama,alamat,telepon,perusahaan,email)
								values($id,$nama,$alamat,$telepon,$perusahaan,$email)");
							echo "alert('proses penambahan berhasil');button_cari_nama_klien_onClick();reset();";
						}
						break;
					case "edit" :
						if(!empty($id)) {
							$query = $this->db->query("update sim_client 
								set nama = $nama,alamat=$alamat,telepon=$telepon,perusahaan=$perusahaan,email=$email
								where no_id=$id");
							echo 'alert("proses modifikasi berhasil");reset();';
						}
						break;
					case "delete" :
						if(!empty($id)) {
							$query = $this->db->query("delete from sim_client where no_id=$id");
							echo 'alert("proses penghapusan berhasil");reset();';
						}
						break;
					case "add-sales" :
						$query = $this->db->query("select * from sim_salescounter order by no_id desc");
						$row = $query->row_array();
						$id = $row['no_id'] +1;
						$query->free_result();
						if(!empty($id)) {
							$query=$this->db->query("insert into sim_salescounter(no_id,kode,nama,alamat,telepon,kota) values($id,' ',$nama,$alamat,$telepon,$kota)");
							echo "alert('proses penambahan sales berhasil');reset();";
						}
						break;
					case "edit-sales" :
						if(!empty($id)) {
							$query = $this->db->query("update sim_salescounter set nama=$nama,kode=' ',alamat=$alamat,telepon=$telepon,kota=$kota where no_id=$id");
							echo "alert('proses modifikasi sales berhasil');reset();";
						}
						break;
					case "delete-sales":
						if(!empty($id)) {
							$query = $this->db->query("delete from sim_salescounter where no_id=$id");
							echo "alert('proses delete sales berhasil');reset();";
						}
						break;
					case "save-transaksi" :
						$klien 						= $this->db->escape(trim($this->input->post('klien')));
						$tema 						= $this->db->escape(trim($this->input->post('tema')));
						$sales 						= $this->db->escape(trim($this->input->post('sales')));
						$nota 						= $this->db->escape(trim($this->input->post('nota')));
						$serial 					= $this->db->escape(trim($this->input->post('serial')));
						$total					 	= trim($this->input->post('total'));
						$biaya_tambahan 			= trim($this->input->post('biaya_tambahan'));
						$uang_muka 					= trim($this->input->post('uang_muka'));
						$jumlah_uangmuka 			= trim($this->input->post('jumlah_uangmuka'));
						$jumlah_tagihan				= trim($this->input->post('jumlah_tagihan'));
						$sisa 						= trim($this->input->post('sisa'));
						$tgl_terima 				= $this->db->escape($this->tanggal_jancok(trim($this->input->post('tgl_terima'))));
						$tgl_desain 				= $this->db->escape($this->tanggal_jancok(trim($this->input->post('tgl_desain'))));
						$tgl_selesai 				= $this->db->escape($this->tanggal_jancok(trim($this->input->post('tgl_selesai'))));
						$jumlah_card 				= $this->db->escape(trim($this->input->post('jumlah_card')));
						$card_status 				= "";
						
						
						
						if($jumlah_card == "''") $card_status = 0;
						else $card_status = 1;
						
						# begin transaction
						$this->db->trans_start();
						
						$query = $this->db->query("select * from sim_nota_order where nota = $nota");
						if($query->num_rows() != 0) {
							$query = $this->db->query('select max(nota) as sno from sim_nota_order');
							$row = $query->row_array();
							$nota = $row['sno']+1;
							$query->free_result();
						}
						
						$no_id_nota_order = $this->create_noid_from_nota_order();
						$query=$this->db->query("
							insert into sim_nota_order values(
								$no_id_nota_order,$klien,$tema,$sales,$nota,$serial,
								$total,$biaya_tambahan,$uang_muka,
								$jumlah_uangmuka,$jumlah_tagihan,$sisa,
								$tgl_terima,$tgl_desain,$tgl_selesai,$tgl_terima,
								$jumlah_card,$card_status)");
						if($this->db->affected_rows() != 0) {
							echo "firstsavepoint"."-".$nota."-".$no_id_nota_order;
						}
						$this->db->trans_complete();
					break;
						
					case "save-transaksi-detail" :
						$no_id 				= trim($this->input->post('no_id'));
						$no_kategori 		= trim($this->input->post('no_kategori'));
						$no_jenis 			= trim($this->input->post('no_jenis'));
						$no_produk 			= trim($this->input->post('no_produk'));
						$harga 				= trim($this->input->post('harga'));
						$jumlah 			= intval(trim($this->input->post('jumlah')));
						$diskon				= trim($this->input->post('diskon'));
						$ukuran				= $this->db->escape(trim($this->input->post('ukuran')));
						$total 				= $harga*$jumlah;
						$index				= $this->input->post('index');
						$length 			= $this->input->post('length');
						$is_last			= $this->input->post('is_last');
						$this->db->trans_start();
						
						$_no_id = $this->create_noid_from_nota_order_detail();
						# primary key dari tabel sim_nota_order adalah no_id
						# $no_id dari sim_nota_order_detail direlasikan dengan no_id dari tabel sim_nota_order
						$query = $this->db->query("
							insert into sim_nota_order_detail values(
								$_no_id,$no_id,$no_kategori,$no_jenis,$no_produk,
								$harga,$jumlah,$diskon,$total,$ukuran,1)");;
						/*if($this->db->affected_rows() !=0) {
							if($is_last != 'true') {
								echo "next-$no_id";
							}
							else {
								echo "last-$no_id";
							}
							
						}
						else {
							echo "";
						}*/
						$this->db->trans_complete();
						$index++;
						if($index < $length) {	
							echo "save_detail($no_id,bucket,$index,$length)";
						}
						else {
							echo "";
						}
						
					break;
						
					case 'update-transaksi' :
						$no_id						= trim($this->input->post('no-id'));
						$klien 						= $this->db->escape(trim($this->input->post('klien')));
						$tema 						= $this->db->escape(trim($this->input->post('tema')));
						$sales 						= $this->db->escape(trim($this->input->post('sales')));
						$nota 						= $this->db->escape(trim($this->input->post('nota')));
						$serial 					= $this->db->escape(trim($this->input->post('serial')));
						$total					 	= trim($this->input->post('total'));
						$biaya_tambahan 			= trim($this->input->post('biaya_tambahan'));
						$uang_muka 					= trim($this->input->post('uang_muka'));
						$jumlah_uangmuka 			= trim($this->input->post('jumlah_uangmuka'));
						$jumlah_tagihan				= trim($this->input->post('jumlah_tagihan'));
						$sisa 						= trim($this->input->post('sisa'));
						$tgl_terima 				= $this->db->escape(trim($this->input->post('tgl_terima')));
						$tgl_desain 				= $this->db->escape(trim($this->input->post('tgl_desain')));
						$tgl_selesai 				= $this->db->escape(trim($this->input->post('tgl_selesai')));
						$jumlah_card 				= $this->db->escape(trim($this->input->post('jumlah_card')));
						$card_status 				= "";
						
						
						
						if($jumlah_card == "''") {
							$card_status = 0;
						}
						else {
							$card_status = 1;
						}
						$sql_query = "update sim_nota_order 
								set klien=$klien,tema=$tema,sales=$sales,nota=$nota,
										serial=$serial,total=$total,biaya_tambahan=$biaya_tambahan,
										uang_muka=$uang_muka,jumlah_uangmuka=$jumlah_uangmuka,
										jumlah_tagihan=$jumlah_tagihan,sisa=$sisa,
										tgl_terima=$tgl_terima,tgl_desain=$tgl_desain,
										tgl_selesai=$tgl_selesai,card=$jumlah_card,
										status=$card_status 
								where no_id = $no_id";
						$query=$this->db->query($sql_query);
						if($this->db->affected_rows() != 0) {
							$this->db->query("delete from sim_nota_order_detail where no_nota = $no_id");
							if($this->db->affected_rows() != 0) {
								echo "firstsavepoint"."-".$nota."-".$no_id;
							}
						}
					break;
						
					case 'update-transaksi-detail' :
						$no_id 				= trim($this->input->post('no_id'));
						$no_kategori 		= trim($this->input->post('no_kategori'));
						$no_jenis 			= trim($this->input->post('no_jenis'));
						$no_produk 			= trim($this->input->post('no_produk'));
						$harga 				= trim($this->input->post('harga'));
						$jumlah 			= intval(trim($this->input->post('jumlah')));
						$diskon				= trim($this->input->post('diskon'));
						$ukuran				= $this->db->escape(trim($this->input->post('ukuran')));
						$total 				= $harga*$jumlah;
						$is_last 			= trim($this->input->post('is_last'));
						
						$_no_id = $this->create_noid_from_nota_order_detail();
						$query = $this->db->query("
							insert into sim_nota_order_detail values(
								$_no_id,$no_id,$no_kategori,$no_jenis,$no_produk,
								$harga,$jumlah,$diskon,$total,$ukuran,1)");;
						if($this->db->affected_rows() !=0) {
							if($is_last != 'true')
								echo "next-$no_id";
							else
								echo "last-$no_id";
						}
						else {
							echo "";
						}
					break;
				}
			}
		}
	}

	function index() {
		$viewdata = array();
		$viewdata['produk_kategori'] = $this->_get_produk_kategori();
		$viewdata['user'] = $this->session->userdata('users');
		$viewdata['jumlah_card'] = $this->_get_jumlah_card();
		$this->load->view('transaksi-nota/index',$viewdata);
	}
	
	function edit() {
		if($this->session->userdata('isadmin') != 'true') {
			redirect(site_url().'/notarecord/');
			exit;
		}
		$id = intval(get_parameter('id'));
		if($id == "") {
			redirect(site_url().'/notarecord/');
			exit;
		}
		$row_order = $this->db->query("select * from sim_nota_order where no_id = $id")->row_array();
		$viewdata['produk_kategori'] 	= $this->_get_produk_kategori();
		$viewdata['jumlah_card'] 		= $this->_get_jumlah_card();
		$viewdata['user'] 				= $this->session->userdata('users');
		$viewdata['row_order'] 			= $row_order;	
		$viewdata['row_klien'] 			= $this->db->query('select * from sim_client where no_id =' . $row_order['klien'])->row_array();
		$viewdata['row_sales'] 			= $this->db->query('select * from sim_salescounter where no_id ='.$row_order['sales'])->row_array();
		$viewdata['query_detail'] 		= $this->db->query('select * from sim_nota_order_detail where no_nota='.$row_order['no_id']);
		$this->load->view('transaksi-nota/edit/edit',$viewdata);
	}
	
	function loadklien() {
		$query_klien = $this->db->query('select * from sim_client order by nama');
		$viewdata['query_klien'] = $query_klien;
		$this->load->view('transaksi-nota/loadklien',$viewdata);
	}
	
	function carinamaklien() {
		$nama = trim($this->input->post('nama'));
		$str = "";
		if(!empty($nama)) {			
			$query = $this->db->query("select * from sim_client where nama LIKE '%".$nama."%'");
			$this->load->view('transaksi-nota/carinamaklien',array('query_klien'=>$query));
		}
	}
	
	function isinamaklien() {
		$id = trim($this->input->post('id'));
		if(!empty($id)) {
			$query = $this->db->query("select * from sim_client where no_id = '".$id."'");
			$row = $query->row_array();
			$viewdata['row'] = $row;
			$query->free_result();
			$this->load->view('transaksi-nota/isinamaklien',$viewdata);
		}
	}
	
	function loadsales() {
		$query_sales = $this->db->query('select * from sim_salescounter');
		$viewdata['query_sales'] = $query_sales;
		$this->load->view('transaksi-nota/loadsales',$viewdata);
	}
	
	function carinamasales() {
		$nama = trim($this->input->post('nama'));
		if(!empty($nama)) {
			$query = $this->db->query("select * from sim_salescounter where nama like '%".$nama."%'");
			$this->load->view('transaksi-nota/carinamasales',array('query_sales'=>$query));
		}
	}
	
	function isinamasales() {
		$id = trim($this->input->post('id'));
		if(!empty($id)) {
			$query = $this->db->query("select * from sim_salescounter where no_id = ".$this->db->escape($id));
			$row = $query->row_array();
			$viewdata['row'] = $row;
			$this->load->view('transaksi-nota/isinamasales',$viewdata);
		}
	}
	
	function service() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$param = trim($this->input->post('param'));
			switch($param) {
				case "load-jenis-produk" :
					$id = $this->db->escape(trim($this->input->post('id')));
					$query = $this->db->query("select * from sim_produk_jenis where no_kategori=$id");
					$this->load->view('transaksi-nota/service/load-jenis-produk',array('query_jenis_produk'=>$query));
					break;
				case "load-produk" :
					$id = $this->db->escape(trim($this->input->post('id')));
					$query = $this->db->query("select * from sim_produk where no_jenis = $id");
					$this->load->view('transaksi-nota/service/load-produk',array('query_produk'=>$query));
					break;
				case "load-detail-produk" :
					$id=$this->db->escape(trim($this->input->post('id')));
					$query = $this->db->query("select * from sim_produk where no_id=$id");					
					$this->load->view('transaksi-nota/service/load-detail-produk',array('query_produk'=>$query));
					break;
			}
		}
	}
	
	function cariklien() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$viewdata['nama'] = 'nama_'.md5(time());
			$viewdata['button_cari'] = 'button_cari'.md5(time());
			$param = $this->input->post('param');
			switch($param) {
				case "load-view" :					
					$this->load->view('transaksi-nota/cariklien-load-view',$viewdata);
					break;
				case "cari-nama" :
					$nama = $this->input->post('nama');
					$id = $this->input->post('id');
					$query = $this->db->query("select * from sim_client where nama like '$nama%'");
					$viewdata['query_klien']=$query;
					$this->load->view('transaksi-nota/cariklien-cari-nama',$viewdata);
					break;
				case "isi-form" :
					$id = $this->input->post('id');
					if(!empty($id)) {
						$query = $this->db->query("select * from sim_client where no_id = $id");
						$row = $query->row_array();
						$viewdata['row'] = $row;
						$this->load->view('transaksi-nota/cariklien-isi-form',$viewdata);
					}
					break;
			}
		}
	}
	
	function carisales() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$viewdata['nama'] = 'nama_'.md5(time());
			$viewdata['button_cari'] = 'button_cari'.md5(time());
			$param = $this->input->post('param');
			switch($param) {
				case "load-view" :					
					$this->load->view('transaksi-nota/carisales-load-view',$viewdata);
					break;
				case "cari-nama" :
					$nama = $this->input->post('nama');
					$id = $this->input->post('id');
					$query = $this->db->query("select * from sim_salescounter where nama like '$nama%'");
					$viewdata['query_salescounter']=$query;
					$this->load->view('transaksi-nota/carisales-cari-nama',$viewdata);
					break;
				case "isi-form" :
					$id = $this->input->post('id');
					if(!empty($id)) {
						$query = $this->db->query("select * from sim_salescounter where no_id = $id");
						$row = $query->row_array();
						$viewdata['row'] = $row;
						$this->load->view('transaksi-nota/carisales-isi-form',$viewdata);
					}
					break;
			}	
		}
	}

	function createserial() {
		$query = $this->db->query('select max(nota) as sno from sim_nota_order');
		$row = $query->row_array();
		$query->free_result();
		if($row['sno'] == '') $row['sno'] = 1;
		else $row['sno'] = $row['sno'] + 1;
		echo 'document.getElementById("no_nota").value = "'. $row['sno']. '";';
		echo 'serial = "'.mdate('%d%m%y%h%i').'";';
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
			
			$pdf->setFont("ARIAL",'B',7);
			$pdf->text(142,43,"Date Print");
			$pdf->text(164,43,":");
			$pdf->text(166,43,date('d M Y'));
			
			#bagian tabelnya coy
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
				#$pdf->text(5,135,'DAPATKAN STIKER CANTIK UTERO , UNTUK PESANAN APA SAJA      No. Rek. BCA. 8160788306 a.n Dadik Wahyu');
			}
			$pdf->output();
			
			
		}
	}
	
	private function _get_produk_kategori() {
		$query = $this->db->query('select * from sim_produk_kategori');
		$retval = "";
		foreach($query->result_array() as $row) {
			$retval[$row['no_id']] = $row['kategori'];
		}
		$query->free_result();
		return $retval;
	}
	
	private function _get_jumlah_card() {
		$retval = array();
		$query = $this->db->query('select * from sim_bank');
		foreach($query->result_array() as $row) {
			$retval[$row['no_id']] = $row['bank'];
		}
		$query->free_result();
		return $retval;
	}
	
	private function create_noid_from_nota_order() {
		$query = $this->db->query('select max(no_id) as sno from sim_nota_order');
		$row = $query->row_array();
		$query->free_result();
		return $row['sno']+1;
	}
	
	private function create_noid_from_nota_order_detail() {
		$query = $this->db->query('select max(no_id) as sno from sim_nota_order_detail');
		$row = $query->row_array();
		$query->free_result();
		return $row['sno']+1;
	}
	
	private function tanggal_jancok($tanggal) {
		$tanggal = explode("/",$tanggal);
		return $tanggal[2]."-".$tanggal[0]."-".$tanggal[1];
	}
}