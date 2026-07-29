<?php
	class Test extends Controller {
		private $page_link = "";
		function Test() {
			parent::Controller();
			$this->load->library('pagination');
			$config['base_url'] = site_url().'/test/page/';
			$config['total_rows'] = $this->_get_total_rows();
			$config['per_page'] = '20'; 
			$this->pagination->initialize($config); 
			$this->page_link = $this->pagination->create_links();
		}
		
		function index() {
			echo $this->page_link;
		}
		
		function show_users() {
			$query = $this->db->query('select * from sim_user');
			foreach($query->result_array() as $row) {
				echo "username : " . $row['user_name'] . ' password : ' . $row['password'] . '<br/>';
			}
		}
		function test_encrypt($message) {
			echo $this->encrypt->encode($message);
		}
		function test_decrypt($message) {
			echo $this->encrypt->decode("UG1SNQM6Vj0PMQd9VW9ScAU+V2A=");
		}
		
		function page($page) {
			echo $this->page_link;
		}
		
		private function _get_total_rows() {
			return $this->db->query('select * from sim_nota_order')->num_rows();
		}
		
		function ajax() {
			$data = $this->input->post('data');
			$length = $this->input->post('length');
			$url = $this->input->post('url');
			$index = $this->input->post('index');
			if($index < ($length)) {
				$index++;
				echo "send('$url',data,$length,$index);";
				echo "console.log('data : ' + $data + ' index : ' + $index);";
			}
			else {
				echo "";
			}
		}
		
		private function createserial() {
			$query = $this->db->query("select max(id) as sno from test");
			$row = $query->row_array();
			$sno = $row['sno'];
			return $sno + 1;
		}
	}