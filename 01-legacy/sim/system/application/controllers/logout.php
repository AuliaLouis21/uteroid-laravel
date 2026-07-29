<?php
	class Logout extends Controller {
		function Logout() {
			parent::Controller();
		}
	
		function index() {
			if($this->session->userdata('islogin') == 'true') {
				$this->session->unset_userdata('islogin');
				$this->session->unset_userdata('user');
				$this->session->unset_userdata('isadmin');
				$this->session->unset_userdata('is_qc');
				$this->session->unset_userdata('is_sc');
				redirect(base_url().index_page());
		}
	}
}