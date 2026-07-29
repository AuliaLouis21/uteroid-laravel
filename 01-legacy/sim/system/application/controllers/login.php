<?php
	class Login extends Controller {
		function Login() {
			parent::Controller();
			if($this->session->userdata('islogin') == 'true') {
				redirect(base_url().index_page().'/main/');
			}
		}
		
		function index() {
			$viewdata = array();
			$viewdata['posturl'] = base_url().index_page().'/login/check/';
			$this->load->view('login',$viewdata);
		}
		
		function check() {
			if($_SERVER['REQUEST_METHOD'] == 'GET') {
			
			}
			else {
				# jika yang request adalah administrator
				$query = $this->db->query('select * from sim_user where user_name='
						.$this->db->escape(trim($this->input->post('username'))).' and password='
						.$this->db->escape(trim($this->input->post('password'))));
				$this->session->set_userdata('flash_notice',array());
				if($query->num_rows() != 0) {
					$row = $query->row_array();
					if($row['status'] == 1) {
						/*$rows = $query->row_array();
						$this->session->set_userdata('islogin','true');
						$this->session->set_userdata('isadmin','true');
						$this->session->set_userdata('users',$rows['full_name']);																	
						$this->session->set_userdata($this->encrypt->encode('group'),$this->encrypt->encode($row['status']));
						redirect(base_url().index_page().'/main/');*/
						
						
						$flash_notice = $this->session->userdata('flash_notice');
						$flash_notice['error_login_notice'] = 'this account temporary disabled ... ';
						$this->session->set_userdata('flash_notice',$flash_notice);
						redirect(base_url().index_page().'/login/');
						
						
					}
					else {
						
						#$flash_notice = $this->session->userdata('flash_notice');
						#$flash_notice['error_login_notice'] = 'you not authorized to view this page';
						#$this->session->set_userdata('flash_notice',$flash_notice);
						#redirect(base_url().index_page().'/login/');
						$rows = $query->row_array();
						
						# check apakah user sudah off atau belum
						
						if($row['status'] == 6) {
							redirect(base_url().index_page().'/login');
							exit;
						}
						
						$this->session->set_userdata('islogin','true');
						if($rows['status'] == 2) {
							$this->session->set_userdata('is_qc','true');
						}
						if($rows['status'] == 3) {
							$this->session->set_userdata('is_sc','true');
						}
						$this->session->set_userdata('users',$rows['full_name']);
						$this->session->set_userdata('users_code',$rows['no_user']);
						redirect(base_url().index_page().'/main/');
						
						
						//$flash_notice = $this->session->userdata('flash_notice');
						//$flash_notice['error_login_notice'] = 'you dont have enough previlige to see this page ... ';
						//$this->session->set_userdata('flash_notice',$flash_notice);
						//redirect(base_url().index_page().'/login/');
					}
				}
				else {
					$flash_notice = $this->session->userdata('flash_notice');
					$flash_notice['error_login_notice'] = 'wrong combination username and password';
					$this->session->set_userdata('flash_notice',$flash_notice);
					redirect(base_url().index_page().'/login/');
				}
			}
		}
	}
