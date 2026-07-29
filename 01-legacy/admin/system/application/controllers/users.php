<?php
	class Users extends Controller {
		function Users() {
			parent::Controller();
			if($this->session->userdata('islogin') != 'true') {
				redirect(base_url().index_page().'/login/');
				exit;
			}
		}
		function index() {
			$viewdata['user'] = $this->session->userdata('users');
			$viewdata['users'] = $this->_getUser();
			$this->load->view('users/index',$viewdata);
		}
		
		function edit($no_user = "") {
			$no_user = intval($no_user);
			if($no_user == "") {
				redirect(base_url().index_page().'/users/');
				die;
			}
			$query = $this->db->query('select * from sim_user where no_user='.$this->db->escape($no_user));
			if($query->num_rows() == 0) {
				redirect(base_url().index_page().'/users/');
				die;
			}
			$viewdata['user'] = $this->session->userdata('users');
			$viewdata['users'] = $query->row_array();
			$this->load->view('users/edit',$viewdata);
		}
		
		function delete($no_user = "") {
			if($no_user == "") {
				redirect(base_url().index_page().'/users/');
				die;
			}
			$query = $this->db->query('select * from sim_user where no_user='.$this->db->escape($no_user));
			if($query->num_rows() == 0) {
				redirect(base_url().index_page().'/users/');
				die;
			}
			$viewdata['user'] = $this->session->userdata('users');
			$viewdata['users'] = $query->row_array();
			$this->load->view('users/delete',$viewdata);
		}
		
		function save() {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$full_name = $this->input->post('fullname');
				$no_user = $this->input->post('no_user');
				$action = $this->input->post('action');
				switch($action) {
					case "edit" :
						$sql = "update sim_user set user_name=".$this->db->escape($username).
							   ",password=".$this->db->escape($password).
							   ",full_name=".$this->db->escape($full_name).
							   " where no_user=".$this->db->escape($no_user);
						$query = $this->db->query($sql);
						redirect(base_url().index_page().'/users/');
						$query->free_result();
						break;
					case "delete" :
						$sql = "delete from sim_user where no_user=".$this->db->escape($no_user);
						$query = $this->db->query($sql);
						redirect(base_url().index_page().'/users/');
						$query->free_result();
						break;
				}
			} 
		}
		
		private function _getUser() {
			$query = $this->db->query('select * from sim_user');
			return $query;
		}
	}