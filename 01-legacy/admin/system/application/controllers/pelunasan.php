<?php 
class Pelunasan extends Controller {
	function Pelunasan() {
		parent::Controller();
		if($this->session->userdata('islogin') == '') {
			redirect(base_url().index_page().'/login/');
			die;
		}
	}
	
	function index() {
		$viewdata['user'] = $this->session->userdata('users');
		$this->load->view('pelunasan/index',$viewdata);
	}
}