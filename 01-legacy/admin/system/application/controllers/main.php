<?php
class Main extends Controller {
	function Main() {
		parent::Controller();	
		if($this->session->userdata('islogin') == '') {
			redirect(base_url().index_page().'/login/');
		}
	}
	
	function index(){
		$viewdata = array();
		$viewdata['user'] = $this->session->userdata('users');
		$this->load->view('main',$viewdata);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */