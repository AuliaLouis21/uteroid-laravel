<?php
	class Laporan extends Controller {
		function Laporan() {
			parent::Controller();
			if($this->session->userdata('islogin') == '') {
				redirect(base_url().index_page().'/login');
			}
		}
		
		function index() {
			$viewdata = array();
			$viewdata['user'] = $this->session->userdata('users');
			$viewdata['salescounter'] = $this->_getSalesCounter();
			$this->load->view('laporan/laporan',$viewdata);
		}
		
		function show($par = '') {
			if($par == '') {
				redirect(base_url().index_page());
				exit;
			}
			else {
				$viewdata = array();
				$viewdata['user'] = $this->session->userdata('users');
				if($par == 'laporan-nota') {
					$viewdata['salescounter'] = $this->_getSalesCounter();
					$this->load->view('laporan/laporan-nota',$viewdata);
				}
				if($par == 'klien-order') {
					$viewdata['klien'] = $this->_getAllClient();
					$viewdata['tema'] = $this->_getTheme();
					$viewdata['perusahaan'] = $this->_getPerusahaan(); #didapat dari pemangginlan method $this->_getAllClient(); 
					$this->load->view('laporan/klien-order',$viewdata);
				}
				if($par == 'piutang-klien') {
					$viewdata['salescounter'] = $this->_getSalesCounter();
					$this->load->view('laporan/piutang-klien',$viewdata);
				}
			}
		}
		
		private function _getTheme() {
			$retval = array();
			$query = $this->db->query("select sim_slip_order_nota.tema from sim_slip_order_nota where tema <> '' order by tema asc");
			foreach($query->result_array() as $row) {
				$retval[$row['tema']] = $row['tema'];
			}
			$query->free_result();
			return $retval;
		}
		
		private function _getPerusahaan() {
			$retval = array();
			$this->perusahaan = array();
			$query = $this->db->query("select perusahaan from sim_client where perusahaan <> '-' and perusahaan <> '' order by perusahaan asc");
			foreach($query->result_array() as $row) {
				$retval[$row['perusahaan']] = $row['perusahaan'];
			}
			$query->free_result();
			return $retval;
		}
		
		
		private function _getAllClient() {
			$retval = array();
			$this->perusahaan = array();
			$query = $this->db->query('select * from sim_client order by nama');
			foreach($query->result_array() as $row) {
				$retval[$row['no_id']] = $row['nama'];
			}
			$query->free_result();
			return $retval;
		}
		
		private function _getSalesCounter() {
			$retval = array();
			$query = $this->db->query('select * from sim_salescounter order by nama asc');
			foreach($query->result_array() as $row) {
				$retval[$row['no_id']] = $row['nama'];
			}
			$query->free_result();
			return $retval;
		}
	}
