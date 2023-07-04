<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

if ( ! function_exists('auth_api')){

    function auth_api($user_modal){		
		if(isset($_POST['session_key']) and empty($_POST['session_key'])){
			return array('status' => false, 'message' => 'Session is invalid');
		}elseif(isset($_POST['email']) and empty($_POST['email'])){
			return array('status' => false, 'message' => 'Email ID is missing');
		}else{
			$session_key = $_POST['session_key'];
			$email = $_POST['email'];
			
			$con['returnType'] = 'single';
			$con['conditions'] = array(
				'email' => $email,
				'running_session' => $session_key
			);
			$user = $user_modal->getRows($con);
			if($user){
				if($user['verified'] == 1){
					return array('status' => true, 'user' => $user);
				}else{
					return array('status' => false, 'message' => 'Account is not Verified');
				}
			}else{
				return array('status' => false, 'message' => 'Invalid Login');
			}
		}
    }
}