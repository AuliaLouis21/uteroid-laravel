<?php 
class CancelNota extends Controller {
	function CancelNota() {
		parent::Controller();
		if($this->session->userdata('islogin') != 'true') {
			redirect(base_url().index_page().'/login/');
			die;
		}
	}
	
	function index() {
		$viewdata['user'] = $this->session->userdata('users');
		$this->load->view('cancelnota/index',$viewdata);
	}
}