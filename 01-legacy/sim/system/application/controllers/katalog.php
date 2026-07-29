<?php
class Katalog extends Controller {
	private $viewdata = null;
	function Katalog() {
		parent::Controller();
		if($this->session->userdata('islogin') != 'true') {
			redirect(base_url().index_page().'/login/');
			die;
		}
		$this->viewdata = array();
		$this->viewdata['user'] = $this->session->userdata('users');
	}
	
	function index() {
		$this->viewdata['kategori'] = $this->_get_kategori_produk();
		$this->load->view('katalog/index',$this->viewdata);
	}
	
	function service() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$param = $this->input->post('param');
			switch($param) {
				case 'get-jenis-produk' :
					echo $this->_get_jenis_produk($this->input->post('jenis-produk'));
					break;
				case 'get-keterangan-jenis' :
					echo $this->_get_keterangan_jenis($this->input->post('jenis-produk')) 
									. ':::' . $this->_get_nama_produk($this->input->post('jenis-produk'));
					break;
				case 'get-detail-produk' :
					echo $this->_get_detail_produk($this->input->post('jenis-produk'));
					break;
			}
		}
	}
	
	function cetak() {
		$kategori_produk = get_parameter('kategori_produk');
		$jenis_produk = get_parameter('jenis_produk');
		$nama_produk = get_parameter('nama_produk');
		$jumlah_order = get_parameter('jumlah_order');
		$quantity = get_parameter('quantity');
		$harga_satuan1 = get_parameter('harga_satuan1');
		$harga_satuan2 = get_parameter('harga_satuan2');
		if($nama_produk != "null") {
			$query_produk = $this->db->query('select * from sim_produk where no_id='.$nama_produk);
			if($query_produk->num_rows() != 0) {
			
				$row = $query_produk->row_array();
				
				$query_jenis = $this->db->query('select * from sim_produk_jenis where no_id = ' . $jenis_produk );
				$query_kategori = $this->db->query('select * from sim_produk_kategori where no_id = ' . $kategori_produk);
				$row_jenis = $query_jenis->row_array();
				$row_kategori = $query_kategori->row_array();
			
				require_once('lib/fpdf/fpdf.php');
				$pdf = new FPDF('P','pt','A4');
				$pdf->Open();
				$pdf->addPage();
				
				/*----------------------- header ----------------------------*/
				$pdf->Image('resources/images/logo-utero.jpg',427,5,120,55,'jpg');
				$pdf->setFont("ARIAL",'',12);
				$pdf->text(210,30,"IDEA & CONCEPT FACTORY");
				$pdf->setFont("ARIAL","B",20);
				$pdf->text(185,50,"SURAT PENAWARAN");
				$pdf->setFont("ARIAL",'',10);
				$pdf->text(260,65,'15 JULI 2010');
				
				$pdf->Image('resources/images/utero.jpg',50,10,90,90,'jpg');
				$pdf->setFont("ARIAL",'',6);
				$pdf->text(440,60,'GRAHA UTERO SOEKARNO HATTA');
				$pdf->text(449,67,'Jalan Soekarno Hatta 2B - Malang');
				$pdf->text(456,74,'Jawa Timur - Indonesia - 65142');
				$pdf->text(443,81,'Tlp. 0341-408408 Fax. 0341-417417');
				
				$pdf->Line(50,105,542,105);
				$pdf->setLineWidth(1);
				$pdf->Line(50,107,542,107);
				
				/*----------------------- header ----------------------------*/
				
				$pdf->Rect(50,115,492,65);
				$pdf->setFont("ARIAL",'',10);
				$pdf->text(60,130,'Kategori Produk : ');
				$pdf->text(140,130,$row_kategori['kategori']);
				
				$pdf->text(74,145,'Jenis Produk : ');
				$pdf->text(140,145,$row_jenis['jenis']);
				
				$pdf->text(80,160,'Keterangan : ');
				$pdf->text(140,160,$row_jenis['keterangan']);
				
				
				$pdf->Rect(50,183,492,65);
				$pdf->text(70,200,'Nama Produk : ');
				$pdf->text(140,200,$row['nama']);
				
				$pdf->text(99,220,'Ukuran : ');
				$pdf->text(140,220,$row['ukuran']);
				
				$pdf->text(350,220,'Ketebalan : ');
				$pdf->text(405,220,$row['tebal']);
				
				$pdf->text(69,235,'Minimal Order : ');
				$pdf->text(140,235,$row['min_order']);
				$pdf->text(333,235,'Harga Satuan : ');
				$pdf->text(405,235,$row['harga']);
				
				$pdf->Rect(50,251,492,33);
				$pdf->text(55,270,'Jumlah Order M2 : ');
				$pdf->text(140,270,$jumlah_order);
				$pdf->text(342,270,'Total Harga : ');
				$pdf->text(405,270,$harga_satuan1);
				
				$pdf->Rect(50,287,492,33);
				$pdf->text(55,306,'Jumlah Order Qty : ');
				$pdf->text(143,306,$quantity);
				$pdf->text(342,306,'Total Harga : ');
				$pdf->text(405,306,$harga_satuan2);
				$pdf->output();
			}
		}	
	}
	
	function imageservice($id) {
		if(isset($id) or $id != null or $id != "") {
			$id = intval($id);
			$query = $this->db->query("select * from sim_produk where no_id=".$this->db->escape($id));
			$row = $query->row_array();
			if(isset($row['gambar'])) {
				$gambar = trim($row['gambar']);
				if(!empty($gambar) and $gambar != '"') {	
					require_once('lib/image_resize.php');
					/*if(substr($gambar,0,7) == "\\Ari\3D\\") {
						$gambar = "D:\\3D\\" . substr($gambar,7,strlen($gambar));
					}
					if(substr($gambar,0,3) == "Z:\\") {
						$gambar = "D:\\".substr($gambar,3,strlen($gambar));
					}*/
					
					if(is_file($gambar)) {
						$image = new SimpleImage();
						$image->load($gambar);
						$image->resize(350,253);					
						$image->output();
						$image->free();
					}
					else {
						$image = new SimpleImage();
						$image->load('resources/images/image.jpg');
						$image->resize(350,253);					
						$image->output();
						$image->free();
					}
				}
				else {
					require_once('lib/image_resize.php');
					$image = new SimpleImage();
					$image->load('resources/images/image.jpg');
					$image->resize(350,253);					
					$image->output();
					$image->free();
				}
			}			
		}
	}
	
	private function _get_kategori_produk() {
		$retval = array();
		$query = $this->db->query('select * from sim_produk_kategori order by kategori');
		foreach($query->result_array() as $row) {
			$retval[$row['no_id']] = $row['kategori'];
		}	
		$query->free_result();
		return $retval;
	}

	private function _get_keterangan_jenis($jenis_produk) {
		$retval = "";
		$query = $this->db->query("select * from sim_produk_jenis where no_id=".$jenis_produk);
		$row = $query->row_array();
		if(isset($row['keterangan'])) $retval = $row['keterangan'];
		$query->free_result();
		return $retval;
	}
	
	private function _get_jenis_produk($jenis_produk) {
		$retval = "";
		$query = $this->db->query("select * from sim_produk_jenis where no_kategori=".$jenis_produk);
		foreach($query->result_array() as $row) {
			$retval .= "<option value='".$row['no_id'] . "'>".$row['jenis']."</option>";
		}
		$query->free_result();
		return $retval;
	}
	
	private function _get_nama_produk($jenis_produk) {
		$retval = "";
		$query = $this->db->query("select * from sim_produk where no_jenis = ".$jenis_produk);
		foreach($query->result_array() as $row) {
			$retval .= "<option value='".$row['no_id'] . "'>".$row['nama']."</option>";
		}
		$query->free_result();
		return $retval;
	}
	
	private function _get_detail_produk($jenis_produk) {
		$retval = "";
		$query = $this->db->query("select * from sim_produk where no_id=".$jenis_produk);
		foreach($query->result_array() as $row) {
			$retval .= "document.getElementById('ukuran').value = '".$row['ukuran']."';";
			$retval .= "document.getElementById('ketebalan').value = '".$row['tebal']."';";
			$retval .= "document.getElementById('minimal_order').value = '".$row['min_order']."';";
			$retval .= "document.getElementById('harga_satuan').value = Number2String(".$row['harga'].");";
		}
		$query->free_result();
		return $retval;
	}
	
	private function get_formatted_date($tanggal) {
		$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli',
			'Agustus','September','Oktober','November','Desember');
		
	}
}