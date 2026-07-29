<?php
class QualityControl extends Controller {
	function QualityControl() {
		parent::Controller();
		if($this->session->userdata('islogin') != 'true') {
			redirect(base_url().index_page());
			die;
		}
	}
	function index() {
		$viewdata['user'] = $this->session->userdata('users');
		$this->load->view('qualitycontrol/index',$viewdata);
	}
	
	function service() {
		$param 					= trim($this->input->post('param'));
		$document_state = trim($this->input->post('document_state'));
		$query 					= null;
		switch($param) {
			case "selesaidesaintanggalawal":	
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* 
						from 
							sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							SN.desain='" . $this->change_date($this->input->post('tanggal')) . "' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state == 'konstruksi') {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where dtpDesain>='" . $this->change_date($this->input->post('tanggal')) . "' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_desain='" . $this->change_date($this->input->post('tanggal')) . "' order by no_slip"
					);
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
			case "selesaidesaintanggalsekarang":
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* 
						from 
							sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							SN.desain='" . date('m/d/Y') . "' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state == 'konstruksi') {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where dtpDesain>='" .  date('m/d/Y') . "' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_desain='" .  date('m/d/Y') . "' order by no_slip"
					);
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
			case "selesaidesaintanggalawalakhir":
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* 
						from 
							sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							SN.desain between '" . $this->change_date($this->input->post('tanggalawal')) . 
							"' and '". $this->change_date($this->input->post('tanggalakhir')) ."' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state == 'konstruksi') {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where dtpDesain between'" . $this->change_date($this->input->post('tanggalawal')) . "' 
						and '" .$this->change_date($this->input->post('tanggalakhir')) . "' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_desain between '" . $this->change_date($this->input->post('tanggalawal')) . "' 
						and '". $this->change_date($this->input->post('tanggalakhir')) . "' order by no_slip"
					);
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
				
			case "slipordertanggalsekarang":
				if($document_state == "sablon") {
					$query = $this->db->query("
						select SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id where SN.tanggal='" . date('m/d/Y'). "' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state == "konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where tanggal='" . date('m/d/Y'). "' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
					
				}
				if($document_state == "slipp3"){
					$query = $this->db->query("
						select * from sim_slipp3 where tanggal='" . date('m/d/Y') . "' order by no_slip_order
					");
					$this->load->view('qualitycontrol/slipp3',array('query'=>$query));
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tanggal='" . date('m/d/Y'). "' order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
			
			case "slipordertanggal":
				if($document_state == "sablon") {
					$query = $this->db->query("
						select SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id where SN.tanggal='" . $this->change_date($this->input->post('tanggal')) . "' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state == "konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where tanggal='" . $this->change_date($this->input->post('tanggal')) . "' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
					
				}
				if($document_state == "slipp3"){
					$query = $this->db->query("
						select * from sim_slipp3 where tanggal='" . $this->change_date($this->input->post('tanggal')) . "' order by no_slip_order
					");
					$this->load->view('qualitycontrol/slipp3',array('query'=>$query));
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tanggal='" . $this->change_date($this->input->post('tanggal'))  . "' order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
			case "slipordertanggalawalakhir" :
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where SN.tanggal between '" . $this->change_date($this->input->post('tanggalawal')) . "' and '". $this->change_date($this->input->post('tanggalakhir')) . "' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state == "konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi 
							where tanggal between '" . $this->change_date($this->input->post('tanggalawal')) . "' and '". $this->change_date($this->input->post('tanggalakhir')) . "' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
					
				}
				if($document_state == "slipp3"){
					$query = $this->db->query("
						select * from sim_slipp3 
						where 
							tanggal between '" .$this->change_date($this->input->post('tanggalawal')) . "' and '". $this->change_date($this->input->post('tanggalakhir')) . "' order by no_slip_order
					");
					$this->load->view('qualitycontrol/slipp3',array('query'=>$query));
					
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum 
						where 
							tanggal between '" . $this->change_date($this->input->post('tanggalawal')) . "' and '". $this->change_date($this->input->post('tanggalakhir')) . "' order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
				
			case "slipproduksitanggalsekarang":
				if($document_state == "sablon") {
					$query = $this->db->query("
						select SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id where SN.produksi='" .date('m/d/Y') .	"' order by no_slip"
					);
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state =="konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where dtpklien='" .date('m/d/Y') .	"'"
					);
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}	
				if($document_state =="slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_produksi='" .date('m/d/Y') .	"' order by no_slip"
					);
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
				
			case "slipproduksitanggal":
				if($document_state == "sablon") {
					$query = $this->db->query("
						select SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id where SN.produksi='" .$this->change_date($this->input->post('tanggal'))."' order by no_slip"
					);
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state =="konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where dtpklien='".$this->change_date($this->input->post('tanggal'))."'"
					);
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}	
				if($document_state =="slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_produksi='".$this->change_date($this->input->post('tanggal'))."' order by no_slip"
					);
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
			
			case "slipproduksitanggalawalakhir":
				if($document_state == "sablon") {
					$query = $this->db->query("
						select SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							SN.produksi between '" .$this->change_date($this->input->post('tanggalawal'))."' and '".$this->change_date($this->input->post('tanggalakhir')). "' order by no_slip"
					);
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state =="konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where dtpklien between '".$this->change_date($this->input->post('tanggalawal'))."' and '".$this->change_date($this->input->post('tanggalakhir'))."'"
					);
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}	
				if($document_state =="slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_produksi between '".$this->change_date($this->input->post('tanggalawal'))."' and '".$this->change_date($this->input->post('tanggalakhir'))."' order by no_slip"
					);
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
			
			case "slipklientanggalsekarang" :
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							SN.selesai='" . date('m/d/Y') . "' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state =="konstruksi") {
					$query = $this->db->query("
						select
							* from sim_slip_konstruksi 
						where 
							dtpklien='" . date('m/d/Y') . "'
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}
				if($document_state=="slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_selesai='" . date('m/d/Y') . "' order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
				
			case "slipklientanggal" :
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							SN.selesai='" . $this->change_date($this->input->post('tanggal')) . "' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state =="konstruksi") {
					$query = $this->db->query("
						select
							* from sim_slip_konstruksi 
						where 
							dtpklien='" . $this->change_date($this->input->post('tanggal')) . "'
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}
				if($document_state=="slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_selesai='" . $this->change_date($this->input->post('tanggal')) . "' order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
				
			case "slipklientanggalawalakhir" :
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							SN.selesai between '" . $this->change_date($this->input->post('tanggalawal')) . "' and '". $this->change_date($this->input->post('tanggalakhir')) ."' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state =="konstruksi") {
					$query = $this->db->query("
						select
							* from sim_slip_konstruksi 
						where 
							dtpklien between '" . $this->change_date($this->input->post('tanggalawal')) . "' and '". $this->change_date($this->input->post('tanggalakhir')) ."'
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}
				if($document_state=="slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where tgl_selesai between '" . $this->change_date($this->input->post('tanggalawal')) . "' and '". $this->change_date($this->input->post('tanggalakhir')) ."' order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
		}
		
	}
	
	
	function service2() {
		$param 					= trim($this->input->post('param'));
		$document_state = trim($this->input->post('document_state'));
		$nota 					= trim($this->input->post('nota'));
		$noslip					= trim($this->input->post('slip'));
		switch($param) {
			case "nonota" :
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							upper(SN.Nota) LIKE '%" . $nota . "%' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
					
				}
				if($document_state == "konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi where upper(nota) LIKE '%" . $nota . "%' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
					echo 'konstruksi';
				}
				if($document_state == "slipp3") {
					$query = $this->db->query("
						select * from sim_slipp3 where upper(no_nota) LIKE '%" . $nota . "%' order by no_slipp3
					");
					$this->load->view('qualitycontrol/slipp3',array('query'=>$query));
					echo 'slipp3';
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where upper(nota) LIKE '%" . $nota . "%'order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
					echo 'slipumum';
				}
				break;
				
			case "noslip" :
				if($document_state == "sablon") {
					$query = $this->db->query("
						select 
							SO.no_id as slip,SN.no_id as no_nota,* from sim_slip_order SO left outer join sim_slip_order_nota SN on SO.no_nota=SN.no_id 
						where 
							upper(SO.no_slip) like '" .$noslip. "%' order by no_slip
					");
					$this->load->view('qualitycontrol/sablon',array('query'=>$query));
				}
				if($document_state == "konstruksi") {
					$query = $this->db->query("
						select * from sim_slip_konstruksi 
						where upper(slip) like '" .$noslip. "%' order by slip
					");
					$this->load->view('qualitycontrol/konstruksi',array('query'=>$query));
				}
				if($document_state == "slipp3") {
					$query = $this->db->query("
						select * from sim_slipp3 where upper(no_slipp3) like '" .$noslip. "%' order by no_slipp3
					");
					$this->load->view('qualitycontrol/slipp3',array('query'=>$query));
				}
				if($document_state == "slipumum") {
					$query = $this->db->query("
						select * from sim_slip_umum where upper(no_slip) like '" .$noslip. "%' order by no_slip
					");
					$this->load->view('qualitycontrol/slipumum',array('query'=>$query));
				}
				break;
		}
	}
	private function change_date($date) {
		$date = split("-",$date);
		return $date[1]."/".$date[0]."/".$date[2];
	}
}