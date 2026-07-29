<?php 
class BahanBaku extends Controller {
	function BahanBaku() {
		parent::Controller();
		if($this->session->userdata('islogin') != 'true') {
			redirect(base_url().index_page().'/login/');
			die;
		}
	}
	
	function index() {
		$viewdata['user'] = $this->session->userdata('users');
		$viewdata['query_bahan_baku'] = $this->db->query('select * from sim_bahanbaku');
		$this->load->view('bahanbaku/index',$viewdata);
	}
	
	function add() {
		$viewdata['user'] = $this->session->userdata('users');
		$viewdata['post_url'] = base_url().index_page().'/bahanbaku/save/';
		$this->load->view('bahanbaku/add',$viewdata);
	}
	
	function edit($par = "") {
		$par = intval($par);
		if($par == "" or $par == 0) {
			redirect(base_url().index_page().'/bahanbaku/');
			die;
		}
		$viewdata['user'] = $this->session->userdata('users');
		$viewdata['post_url'] = base_url().index_page().'/bahanbaku/save/';
		$viewdata['query_bahan_baku'] = $this->db->query('select * from sim_bahanbaku where no_id='.$par);
		$this->load->view('bahanbaku/edit',$viewdata);
	}
	
	function delete($par = "") {
		$par = intval($par);
		if($par == "" or $par == 0) {
			redirect(base_url().index_page().'/bahanbaku/');
			die;
		}
		$viewdata['user'] = $this->session->userdata('users');
		$viewdata['post_url'] = base_url().index_page().'/bahanbaku/save/';
		$viewdata['query_bahan_baku'] = $this->db->query('select * from sim_bahanbaku where no_id='.$par);
		$this->load->view('bahanbaku/delete',$viewdata);
	}
	
	function jeniswarna($par = "") {
		$par = intval($par);
		if($par == ""  or $par == 0) {
			redirect(base_url().index_page().'/bahanbaku/');
			die;
		}
		$par = $this->db->escape(trim($par));
		$query_bahan_baku = $this->db->query("select * from sim_bahanbaku where no_id = " . $par);
		$query_jenis_bahan_baku = $this->db->query("select * from sim_bahanbaku_jenis where no_bahanbaku = " . $par);
		$viewdata['query_bahan_baku'] = $query_bahan_baku;
		$viewdata['query_jenis_bahan_baku'] = $query_jenis_bahan_baku;
		$viewdata['user'] = $this->session->userdata('users');
		$viewdata['post_url'] = base_url().index_page().'/bahanbaku/save';
		$this->load->view('bahanbaku/jeniswarna',$viewdata);
	}
	
	function deletejeniswarna($par = "") {
		$par = intval($par);
		if($par == '' or $par == 0) {
			redirect(base_url().index_page().'/bahanbaku/');
			die;
		}
		$sql = "delete from sim_bahanbaku_jenis where no_id=".$par;
		$query = $this->db->query($sql);
		redirect(base_url().index_page().'/bahanbaku/');
	}
	
	function save() {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			redirect(base_url().index_page().'/bahanbaku/');
			die;
		}
		$action = $this->input->post('action');
		$bahan_baku = $this->db->escape(trim($this->input->post('bahan_baku')));
		switch($action) {
			case "add" :
				$query = $this->db->query('select * from sim_bahanbaku');
				$row = $query->last_row('array');
				$no_id = $row['no_id'];
				$no_id = $no_id + 1;
				$query->free_result();
				$sql = "insert into sim_bahanbaku(no_id,bahan_baku) values($no_id,$bahan_baku)";
				$query = $this->db->query($sql);
				redirect(base_url().index_page().'/bahanbaku/');
				break;
			case "edit" :
				$no_id = $this->db->escape(trim($this->input->post('no_id')));
				$sql = "update sim_bahanbaku set bahan_baku = $bahan_baku where no_id = " . $no_id;
				$query = $this->db->query($sql);
				redirect(base_url().index_page().'/bahanbaku/');
				break;
			case "delete" :
				$no_id = $this->db->escape(trim($this->input->post('no_id')));
				$sql = "delete from sim_bahanbaku where no_id = " . $no_id;
				$query = $this->db->query($sql);
				redirect(base_url().index_page().'/bahanbaku/');
				break;
			case "jenis_warna" :
				$no_id_jenis = $this->input->post('no_id_jenis');
				$no_id_bahan_baku = $this->input->post('no_id_bahan_baku');
				$nama = $this->db->escape($this->input->post('jenis_warna'));
				$query = $this->db->query('select * from sim_bahanbaku_jenis');
				$row = $query->last_row('array');
				$no_id = $row['no_id'] + 1;
				$sql = "insert into sim_bahanbaku_jenis(no_id,jenis_bahanbaku,no_bahanbaku) values($no_id,$nama,$no_id_bahan_baku)";
				$query = $this->db->query($sql);
				redirect(base_url().index_page().'/bahanbaku/jeniswarna/'.$no_id_bahan_baku);
				break;
			case "edit_jenis_warna" :
				/*
					and now what 
					
				*/
				break;
		}
	}
}