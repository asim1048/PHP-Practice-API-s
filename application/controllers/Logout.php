<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller{

	public function __construct(){

		parent::__construct();
	}

	public function index(){
		$u_id = $this->session->userdata('user');
		$user = $this->db->query("select * from users where u_id='$u_id'")->result_array()[0];

		if($user['login_time']==$this->session->userdata('LoggedInTime')){
			$this->db->query("update users set login_time='0' where u_id='".$this->session->userdata('user')."'");
		}
		
		$this->session->sess_destroy();
		redirect(SURL.'Login');
	}
}
?>