<?php
class ServiceKlien extends Controller {
	private $buttonParameter = "";
	function ServiceKlien() {
		parent::Controller();
		if($this->session->userdata('islogin') != 'true') {
			redirect(base_url().index_page().'/login/');
		}
	}
	
	function preview() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$action = $this->input->post('action');
			switch($action) {
				case 'nota' :
					$nonota = $this->input->post('nonota');
					$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
					                " left outer join sim_client SC on SO.klien=SC.no_id" .
					                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
					            	 " where nota=".$this->db->escape($nonota) . " order by nota";
					$this->buttonParameter = 'action=nota';
					echo $this->_prosesNota($sql);
					break;
				case 'tanggal-sekarang' :
					$tanggalsekarang = date('m/d/Y') . ' 12:00 AM';
					$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
					                " left outer join sim_client SC on SO.klien=SC.no_id" .
					                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
					            	 " where tgl_terima='" . $tanggalsekarang. "' order by nota";
					$this->buttonParameter = 'action=tanggal-sekarang';
					echo $this->_prosesTanggalSekarang($sql);
					break;
				case 'tanggal-terima' :
					$tanggalterima = $this->input->post('tanggal-terima');
					$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
					                " left outer join sim_client SC on SO.klien=SC.no_id" .
					                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
					            	 " where tgl_terima=" . $this->db->escape($tanggalterima) . " order by nota";
					$this->buttonParameter = 'action=tanggal-terima';
					echo $this->_prosesTanggalTerima($sql);
					break;
				case 'tanggal-awal-akhir' :
					$tanggalawal = $this->input->post('tanggal-awal');
					$tanggalakhir = $this->input->post('tanggal-akhir');
					$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
					                " left outer join sim_client SC on SO.klien=SC.no_id" .
					                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
					            	 " where tgl_terima between " .$this->db->escape($tanggalawal) ." and " 
											. $this->db->escape($tanggalakhir) . " order by nota";
					$this->buttonParameter = 'action=tanggal-awal-akhir';
					echo $this->_prosesTanggalAwalAkhir($sql);
					break;
			}
		}
	}
	
	function cetak() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$action = $this->input->post('action');
			if($action != "" and $action != null) {
				switch($action) {
					case "nota" :
						$nonota = $this->input->post('nota');
						$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
						                " left outer join sim_client SC on SO.klien=SC.no_id" .
						                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
						            	 " where nota=".$this->db->escape($nonota) . " order by nota";
						echo $this->_cetakTable($sql,'laporan nomor nota : ' . $nonota);
						break;
					case "tanggal-terima" :
					$tanggalterima = $this->input->post('_tanggalterima');
					$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
					                " left outer join sim_client SC on SO.klien=SC.no_id" .
					                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
					            	 " where tgl_terima=" . $this->db->escape($tanggalterima) . " order by nota";
						echo $this->_cetakTable($sql,'laporan dengan tanggal terima : ' . $tanggalterima);
						break;
					case "tanggal-sekarang" :
						$tanggalsekarang = date('m/d/Y') . ' 12:00 AM';
						$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
						                " left outer join sim_client SC on SO.klien=SC.no_id" .
						                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
						            	 " where tgl_terima='" . $tanggalsekarang. "' order by nota";
						echo $this->_cetakTable($sql,'laporan nota tanggal : ' . $tanggalsekarang);
						break;
					case "tanggal-awal-akhir" :
						$tanggalawal = $this->input->post('_tanggalawal');
						$tanggalakhir = $this->input->post('_tanggalakhir');
						$sql = "select SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,* from sim_nota_order SO" .
						                " left outer join sim_client SC on SO.klien=SC.no_id" .
						                " left outer join sim_salescounter SS on SO.sales=SS.no_id" .
						            	 " where tgl_terima between " .$this->db->escape($tanggalawal) ." and " 
												. $this->db->escape($tanggalakhir) . " order by nota";
						echo $this->_cetakTable($sql,'laporan nota antara tanggal : ' .$tanggalawal .' sampai : ' . $tanggalakhir);
						break;
				}
			}
		}
	}
	
	private function _cetakTable($sql,$keterangan) {
		$viewdata['piutang_query'] = $this->db->query($sql);
		$viewdata['keterangan'] = $keterangan;
		$viewdata['print_date'] = $this->_getDate();
		$this->load->view('laporan/piutang-klien/laporan-piutang-klien',$viewdata);
	}
	
	private function _prosesNota($sql) {
		$query = $this->db->query($sql);
		$viewdata['piutang_query'] =  $query;
		$viewdata['button_parameter'] = $this->buttonParameter;
		$this->load->view('laporan/piutang-klien/tanggal-sekarang',$viewdata);
	}
	
	private function _prosesTanggalSekarang($sql) { 
		$query = $this->db->query($sql);
		$viewdata['piutang_query'] = $query;
		$viewdata['button_parameter'] = $this->buttonParameter;
		$this->load->view('laporan/piutang-klien/tanggal-sekarang',$viewdata);
	}
	
	private function _prosesTanggalTerima($sql) {
		$query = $this->db->query($sql);
		$viewdata['piutang_query'] = $query;
		$viewdata['button_parameter'] = $this->buttonParameter;
		$this->load->view('laporan/piutang-klien/tanggal-sekarang',$viewdata);
	}
	
	private function _prosesTanggalAwalAkhir($sql) {
		$query = $this->db->query($sql);
		$viewdata['piutang_query'] = $query;
		$viewdata['button_parameter'] = $this->buttonParameter;
		$this->load->view('laporan/piutang-klien/tanggal-sekarang',$viewdata);
	}
	
	private function _getDate() {
		$result = '';
		$tanggal = date('d');
		$bulan = date('n');
		$tahun = date('Y');
		$vaBulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		return $tanggal . ' ' . $vaBulan[$bulan - 1] . ' ' . $tahun;
	}
}