<?php
	class Pengeluaran extends Controller {
		function Pengeluaran() {
			parent::Controller();
			if($this->session->userdata('is_login') != 'true') {
				redirect(base_url().index_page().'/login/');
				die;
			}
		}
		
		function index() {
		
		}
		
		function preview() {
			$kode_pengeluaran = intval($this->input->post('kode_pengeluaran'));
			if($kode_pengeluaran != "" and $kode_pengeluaran != 0) {
				$query = $this->db->query("select * from pengeluaran where kode_pengeluaran = $kode_pengeluaran");
				if($query->num_rows() != 0) {
				
				}
			}
		}
	}