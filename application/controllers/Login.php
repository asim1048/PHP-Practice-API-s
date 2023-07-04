<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->model('common');
		
	}

	public function index()
	{ 
		$this->session->unset_userdata('testuser');
		if($this->session->userdata('LoggedIn')){

			$con['conditions']=array("u_id"=>$this->session->userdata('user'));
			$user = $this->common->get_single_row("users",$con);
			if($user->login_time==$this->session->userdata('LoggedInTime')){
				redirect(SURL."/Dashboard");
			}else{
				redirect(SURL."/Logout");
			}
			
		}      
        
		if(isset($_POST['submit'])){

			$email = $_POST['email'];
			$pass  = sha1($_POST['password']); 

			$user_record = $this->db->query("select * from users where email='$email' and password='$pass' and user_status in('1','2')"); 
			if($user_record->num_rows() > 0){
				$result = $user_record->result_array()[0];

				if($result['login_time']!="0"){
					$this->session->set_userdata("testuser",$result['u_id']);
					$this->load->view("Login", $data);

				}else{
				
					$time = time();
					$this->session->set_userdata("user",$result['u_id']);
					$this->session->set_userdata('LoggedIn',TRUE);
					$this->session->set_userdata('LoggedInTime',$time);

					$con['conditions']=array("u_id"=>$result['u_id']);
					$this->common->update("users",array("login_time"=>$time),$con);
					redirect(SURL."Dashboard");
				
				}

			}else{
				$data['error'] = "Invalid Email/Password";
			}

			
		}


		$this->load->view("Login", $data);
		
	}

	public function setsession(){

		if($this->session->userdata('testuser')){
			$u_id = $this->session->userdata('testuser');
			$result = $this->db->query("select * from users where u_id='$u_id'")->result_array()[0];

			$time = time();
			$this->session->set_userdata("user",$result['u_id']);
			$this->session->set_userdata('LoggedIn',TRUE);
			$this->session->set_userdata('LoggedInTime',$time);

			$con['conditions']=array("u_id"=>$result['u_id']);
			$this->common->update("users",array("login_time"=>$time),$con);
			redirect(SURL."Dashboard");

		}else{
			redirect("Login");
		}
	}

	public function dessession(){
		$this->session->unset_userdata('testuser');
		redirect(SURL."Login");
	}
	

	
}
