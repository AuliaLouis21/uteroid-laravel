<?php
class Transaksi extends Controller {
	function Transaksi() {
		parent::Controller();
		if($this->session->userdata('islogin') != 'true') {
			redirect(base_url().index_page().'/login/');
			die;
		}
	}
	
	function index() {
		$viewdata['user'] = $this->session->userdata('users');
		$this->load->view('transaksi/index',$viewdata);
	}
}