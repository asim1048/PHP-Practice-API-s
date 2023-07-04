<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Training extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user');
    }
	
	public function add_exercise_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('name'))){ $this->response(['status' => FALSE, 'message' => 'Enter Name'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('description'))){ $this->response(['status' => FALSE, 'message' => 'Enter Description'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('equipment'))){ $this->response(['status' => FALSE, 'message' => 'Enter Equipment'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('exercise_type'))){ $this->response(['status' => FALSE, 'message' => 'Enter Exercise Type'], REST_Controller::HTTP_OK); }
			
			$data_array = array(
				'creator_type' => $user['id'],
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'equipment' => $this->input->post('equipment'),
				'exercise_type' => $this->input->post('exercise_type'),
				'datetime' => time()
			);
			
			$id = $this->user->insert_data($data_array, 'exercise');
			
			if($id){
				$this->response([
					'status' => TRUE,
					'message' => 'Data inserted Successfully',
					'data' => array('id' => $id),
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => TRUE,
					'message' => 'Error',
					'data' => 'Something Went Wrong, Please try again Later',
				], REST_Controller::HTTP_OK);
			}
		}
	}

	public function get_exercise_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){ $this->response(['status' => FALSE, 'message' => 'ID is Missing'], REST_Controller::HTTP_OK); }
			
			$id = $this->input->post('id');
			
			$data = $this->user->get_data($id, 'exercise');
		
			if($data){
				$this->response([
					'status' => TRUE,
					'message' => 'Success',
					'data' => $data,
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => TRUE,
					'message' => 'Error',
					'data' => 'Something Went Wrong, Please try again Later',
				], REST_Controller::HTTP_OK);
			}
		}
    }
	
	public function delete_exercise_post(){
        $response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){
				$this->response([
				'status' => FALSE,
				'message' => 'Id Is Required',
				], REST_Controller::HTTP_OK);
			}
			
			$id = $this->input->post('id');
			
			$data = $this->user->delete_data($id, 'exercise');
			
			if($data){
				$this->response([
					'status' => TRUE,
					'message' => 'Data Deleted',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => TRUE,
					'message' => 'Something Went Wrong, Please try again Later',
				], REST_Controller::HTTP_OK);
			}
		}
	}
	
	public function update_exercise_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){ $this->response([ 'status' => FALSE, 'message' => 'ID is Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('name'))){ $this->response(['status' => FALSE,'message' => 'Name is Missing'], REST_Controller::HTTP_OK);}
			if(empty($this->input->post('description'))){ $this->response(['status' => FALSE,'message' => 'Description is Missing'], REST_Controller::HTTP_OK);}
			if(empty($this->input->post('equipment'))){ $this->response(['status' => FALSE,'message' => 'Equipment is Missing'], REST_Controller::HTTP_OK);}
			if(empty($this->input->post('exercise_type'))){ $this->response(['status' => FALSE,'message' => 'Exercise Type is Missing'], REST_Controller::HTTP_OK);}
			
			$id = $this->input->post('id');
		
			$data_array = array(
				'creator_type' => $user['id'],
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'equipment' => $this->input->post('equipment'),
				'exercise_type' => $this->input->post('exercise_type'),
				'datetime' => time(),
			);
			
			$data = $this->user->update_data($id,$data_array,'exercise');
			
			if($data){
				$this->response([
					'status' => TRUE,
					'message' => 'Success',
					'data' => 'data updated',
				], REST_Controller::HTTP_OK); 
			}else{
				$this->response([
					'status' => TRUE,
					'message' => 'Error',
					'data' => 'Something Went Wrong, Please try again Later',
				], REST_Controller::HTTP_OK);
			}
		}
    }
	
	public function get_all_exercise_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			$data = $this->user->get_all_data_by_user('exercise', array(0, $user['id']));
			if(is_array($data)){
				$this->response([
					'status' => TRUE,
					'message' => 'Success',
					'data' => $data,
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
                    'status' => TRUE,
                    'message' => 'Error',
                    'data' => 'Something Went Wrong, Please try again Later',
                ], REST_Controller::HTTP_OK);
			}   
		}
    }
	
	//Training plan
	public function add_training_plan_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
		    $user = $response['user'];
			$id = false;
			if(empty($this->input->post('name'))){ $this->response(['status' => FALSE, 'message' => 'Enter Name'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('description'))){ $this->response(['status' => FALSE, 'message' => 'Enter Description'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('from_date'))){ $this->response(['status' => FALSE, 'message' => 'Training Plan From Date is Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('exercise_type'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Type is Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('to_date'))){ $this->response(['status' => FALSE, 'message' => 'Training Plan To Dateis Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('exercise_id'))){ $this->response(['status' => FALSE, 'message' => 'Exercise IDs are Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('exercise_sets'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Sets are Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('rest_between_sets'))){ $this->response(['status' => FALSE, 'message' => 'Rest Between Sets are Missing'], REST_Controller::HTTP_OK); }
			
			$data_array = array(
				'creator_type' => $user['id'],
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'datetime' => time(),
				'type' => $this->input->post('exercise_type'),
				'from_date' => strtotime($this->input->post('from_date')),
				'to_date' => strtotime($this->input->post('to_date')),
			);
			if($this->input->post("exercise_type") == "cardio"){
				if(empty($this->input->post('resistance'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Resistance is Missing'], REST_Controller::HTTP_OK); }
				if(empty($this->input->post('duration'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Duration is Missing'], REST_Controller::HTTP_OK); }

				$id = $this->user->insert_data($data_array, 'training_plan');
				if(is_array($this->input->post('exercise_id')) and is_array($this->input->post('exercise_sets')) and is_array($this->input->post('rest_between_sets')) and is_array($this->input->post('resistance')) and is_array($this->input->post('duration'))){
					$exercise_id = $this->input->post('exercise_id');
					$rest_between_sets = $this->input->post('rest_between_sets');
					$exercise_sets = $this->input->post('exercise_sets');
					$resistance = $this->input->post('resistance');
					$duration = $this->input->post('duration');
				
					if(count($exercise_id) == count($rest_between_sets) and count($exercise_id) == count($exercise_sets) and count($exercise_id) == count($resistance) and count($exercise_id) == count($duration)){
						for($i = 0; $i < count($exercise_id); $i++){
							$data_array = array(
								'creator_type' => $user['id'],
								'plan_id' => $id,
								'exercise_sets' => $exercise_sets[$i],
								'exercise_id' => $exercise_id[$i],
								'rest_between_sets' => $rest_between_sets[$i],
								'resistance' => $resistance[$i],
								'duration' => $duration[$i],
								'datetime' => time()
							);
							$this->user->insert_data($data_array, 'training_plan_exercise');
						}
					}else{
						$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
					}
				}else{
					$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
				}
			}elseif($this->input->post("exercise_type") == "weight-lift"){
				if(empty($this->input->post('set_type'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Set Type is Missing'], REST_Controller::HTTP_OK); }
				if(empty($this->input->post('exercise_repeat'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Repeats is Missing'], REST_Controller::HTTP_OK); }
				if(empty($this->input->post('weight'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Weight is Missing'], REST_Controller::HTTP_OK); }
				
				$id = $this->user->insert_data($data_array, 'training_plan');
				if(is_array($this->input->post('exercise_id')) and is_array($this->input->post('exercise_sets')) and is_array($this->input->post('exercise_repeat'))){
					$exercise_id = $this->input->post('exercise_id');
					$rest_between_sets = $this->input->post('rest_between_sets');
					$exercise_sets = $this->input->post('exercise_sets');
					$exercise_repeat = $this->input->post('exercise_repeat');
					$set_type = $this->input->post('set_type');
					$weight = $this->input->post('weight');
					
					if(count($exercise_id) == count($rest_between_sets) and count($exercise_id) == count($exercise_sets) and count($exercise_id) == count($exercise_repeat) and count($exercise_id) == count($set_type)){
						for($i = 0; $i < count($exercise_sets); $i++){
							$data_array = array(
								'creator_type' => $user['id'],
								'plan_id' => $id,
								'exercise_id' => $exercise_id[$i],
								'rest_between_sets' => $rest_between_sets[$i],
								'exercise_sets' => $exercise_sets[$i],
								'exercise_repeat' => $exercise_repeat[$i],
								'weight' => $weight[$i],
								'set_type' => $set_type[$i],
								'datetime' => time()
							);
							$this->user->insert_data($data_array, 'training_plan_exercise');
						}
					}else{
						$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
					}
				}else{
					$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
				}
			}
			
			if($id){
				$this->response([
					'status' => TRUE,
					'message' => 'Data inserted Successfully',
					'data' => array('id' => $id),
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'message' => 'Error',
					'data' => 'Something Went Wrong, Please try again Later',
				], REST_Controller::HTTP_OK);
			}
		}
    }
	
	public function update_training_plan_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){ $this->response(['status' => FALSE, 'message' => 'ID is Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('name'))){ $this->response(['status' => FALSE, 'message' => 'Enter Name'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('description'))){ $this->response(['status' => FALSE, 'message' => 'Enter Description'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('from_date'))){ $this->response(['status' => FALSE, 'message' => 'Training Plan From Date is Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('to_date'))){ $this->response(['status' => FALSE, 'message' => 'Training Plan To Dateis Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('exercise_id'))){ $this->response(['status' => FALSE, 'message' => 'Exercise IDs are Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('exercise_sets'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Sets are Missing'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('rest_between_sets'))){ $this->response(['status' => FALSE, 'message' => 'Rest Between Sets are Missing'], REST_Controller::HTTP_OK); }
			
			$data_array = array(
				'creator_type' => $user['id'],
				'name' => $this->input->post('name'),
				'type' => $this->input->post('exercise_type'),
				'description' => $this->input->post('description'),
				'datetime' => time(),
				'from_date' => strtotime($this->input->post('from_date')),
				'to_date' => strtotime($this->input->post('to_date')),
			);
			
			$id = $this->input->post('id');
			$data = $this->user->update_data($id,$data_array,'training_plan');
			
			if($data){
				$this->user->delete_data_custom('training_plan_exercise', 'plan_id', $id);
				if($this->input->post("exercise_type") == "cardio"){ 
					if(empty($this->input->post('resistance'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Resistance is Missing'], REST_Controller::HTTP_OK); }
					if(empty($this->input->post('duration'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Duration is Missing'], REST_Controller::HTTP_OK); }
				   	if(empty($this->input->post('set_type'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Set Type is Missing'], REST_Controller::HTTP_OK); }
					
					$id = $this->user->insert_data($data_array, 'training_plan');
					if(is_array($this->input->post('exercise_id')) and is_array($this->input->post('exercise_sets')) and is_array($this->input->post('exercise_repeat')) and is_array($this->input->post('rest_between_sets')) and is_array($this->input->post('resistance')) and is_array($this->input->post('duration'))){
						 $exercise_id = $this->input->post('exercise_id');
						$rest_between_sets = $this->input->post('rest_between_sets');
						$exercise_sets = $this->input->post('exercise_sets');
						$resistance = $this->input->post('resistance');
						$duration = $this->input->post('duration');
						
						if(count($exercise_id) == count($rest_between_sets) and count($exercise_id) == count($exercise_sets) and count($exercise_id) == count($resistance) and count($exercise_id) == count($duration)){
							for($i = 0; $i < count($exercise_id); $i++){
								$data_array = array(
									'creator_type' => $user['id'],
									'plan_id' => $id,
									'exercise_sets' => $exercise_sets[$i],
									'exercise_id' => $exercise_id[$i],
									'rest_between_sets' => $rest_between_sets[$i],
									'resistance' => $resistance[$i],
									'duration' => $duration[$i],
									'datetime' => time()
								);
								$this->user->insert_data($data_array, 'training_plan_exercise');
							}
						}else{
							$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
						}
					}else{
						$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
					}
				}elseif($this->input->post("exercise_type") == "weight-lift"){
					if(empty($this->input->post('set_type'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Set Type is Missing'], REST_Controller::HTTP_OK); }
					if(empty($this->input->post('exercise_repeat'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Repeats is Missing'], REST_Controller::HTTP_OK); }
					if(empty($this->input->post('weight'))){ $this->response(['status' => FALSE, 'message' => 'Exercise Weight is Missing'], REST_Controller::HTTP_OK); }
					
					$id = $this->user->insert_data($data_array, 'training_plan');
					if(is_array($this->input->post('exercise_id')) and is_array($this->input->post('exercise_sets')) and is_array($this->input->post('exercise_repeat'))){
						$exercise_id = $this->input->post('exercise_id');
						$rest_between_sets = $this->input->post('rest_between_sets');
						$exercise_sets = $this->input->post('exercise_sets');
						$exercise_repeat = $this->input->post('exercise_repeat');
						$set_type = $this->input->post('set_type');
						$weight = $this->input->post('weight');
						
						if(count($exercise_id) == count($rest_between_sets) and count($exercise_id) == count($exercise_sets) and count($exercise_id) == count($exercise_repeat) and count($exercise_id) == count($set_type)){
							for($i = 0; $i < count($exercise_sets); $i++){
								$data_array = array(
									'creator_type' => $user['id'],
									'plan_id' => $id,
									'exercise_id' => $exercise_id[$i],
									'rest_between_sets' => $rest_between_sets[$i],
									'exercise_sets' => $exercise_sets[$i],
									'exercise_repeat' => $exercise_repeat[$i],
									'weight' => $weight[$i],
									'set_type' => $set_type[$i],
									'datetime' => time()
								);
								$this->user->insert_data($data_array, 'training_plan_exercise');
							}
						}else{
							$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
						}
					}else{
						$this->response(['status' => TRUE, 'message' => 'Currupted Data Found', 'data' => array()], REST_Controller::HTTP_OK);die();
					}
				}
				$this->response([
					'status' => TRUE,
					'message' => 'Success',
					'data' => 'data updated',
				], REST_Controller::HTTP_OK); 
			}else{
				$this->response([
					'status' => TRUE,
					'message' => 'Error',
					'data' => 'Something Went Wrong, Please try again Later',
				], REST_Controller::HTTP_OK);
			}
		}
    }
	
	public function send_email_cardio_post(){ $this->send_email_post("cardio"); }
	public function send_email_weightlift_post(){ $this->send_email_post("weight-lift"); }
	
	public function send_email_post($type = ""){
		if(empty($type)){ $this->response(['status' => FALSE, 'message' => 'You are using Older Version of API'], REST_Controller::HTTP_OK); }
        $response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){ $this->response(['status' => FALSE, 'message' => 'Id Is Required'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('client_email'))){ $this->response(['status' => FALSE, 'message' => 'Email Id Is Required'], REST_Controller::HTTP_OK); }
			
			$id = $this->input->post('id');
			$email = $this->input->post('client_email');
			$id = $this->input->post('id');
			$data = $this->user->get_data($id, 'training_plan')[0];
			$this->db->select('training_plan_exercise.*, exercise.image_url ,exercise.description, exercise.equipment, exercise.name as exercise_name, exercise.exercise_type, exercise.description as exercise_description');
			$this->db->where('training_plan_exercise.creator_type', $user['id']);
			$this->db->where('training_plan_exercise.dl', 0);
			$this->db->where('training_plan_exercise.plan_id', $data['id']);
			$this->db->join('exercise', 'exercise.id = training_plan_exercise.exercise_id');
			$result = $this->db->get('training_plan_exercise')->result_array();
			
			$exercise = array();
			foreach($result as $row){
				array_push($exercise, $row);
			}
			$html = "";
			$html .= "<h3>Training Plan Details : ".$data['name']."</h3>";
			$html .= "<h4>Date: From ".date('Y-m-d H:i:s', $data['from_date'])." To : ".date('Y-m-d H:i:s',$data['to_date']);
			$Subject = "Training Plan";
			if($data['type'] == "cardio"){
				$Subject = "Cardio Training Plan";
				$html .= "<table border='1'>";
					$html .= "<tr><td>Exercise</td><td>Equipment</td><td>Set Type</td><td>Number Of Sets</td><td>Number of Reps</td><td>Rest between sets</td><td>How to perform</td></tr>";
					foreach($exercise as $row){
						$exercise_name = $row['exercise_name'];
						if($row['image_url'] != ""){
							$exercise_name .= "<br><img src='".$row['image_url']."' width='250px'>";
						}
						$html .= "<tr>";
							$html .= "<td>$exercise_name</td>";
							$html .= "<td>".$row['equipment']."</td>";
							$html .= "<td>".$row['set_type']."</td>";
							$html .= "<td>".$row['exercise_sets']."</td>";
							$html .= "<td>".$row['exercise_repeat']."</td>";
							$html .= "<td>".$row['rest_between_sets']."</td>";
							$html .= "<td>".$row['description']."</td>";
						$html .= "</tr>";
					}
				$html .= "</table>";
			}elseif($data['type'] == "weight-lift"){
				$Subject = "Weight Lift Training Plan";
				$html .= "<table border='1'>"; 
					$html .= "<tr><td>Exercise</td><td>Equipment</td><td>Total Time</td><td>Resistance</td><td>How Many Sets</td><td>Set Duration</td><td>Rest between sets</td><td>How to perform</td></tr>";
					foreach($exercise as $row){
						$exercise_name = $row['exercise_name'];
						if($row['image_url'] != ""){
							$exercise_name .= "<br><img src='".$row['image_url']."' width='250px'>";
						}
						$html .= "<tr>";
							$html .= "<td>$exercise_name</td>";
							$html .= "<td>".$row['equipment']."</td>";
							$html .= "<td>".$row['duration']."</td>";
							$html .= "<td>".$row['resistance']."</td>";
							$html .= "<td>".$row['exercise_sets']."</td>";
							$html .= "<td>".$row['duration']."</td>";
							$html .= "<td>".$row['rest_between_sets']."</td>";
							$html .= "<td>".$row['description']."</td>";
						$html .= "</tr>";
					}
				$html .= "</table>";
			}
			$this->load->library('m_pdf');
			$this->data['title'] = "MY PDF TITLE 1.";
			$this->data['description'] = "Description";
			$pdfFilePath = "temp_pdfs/trainingplan-".time().".pdf";
			$pdf = $this->m_pdf->load();
			$pdf->WriteHTML($html);
			$pdf->Output($pdfFilePath, "F");
			
			$attachments = array(APPPATH ."../". $pdfFilePath);
			if($this->user->send_email($email, $Subject, 'Dear Customer, <br><br>Mr Sami has sent you a diet plan. Attached is your diet plan sent via Envo Sports application.<br>[LOGO]<br>Kind Regards,<br>Envo Sports Support Team', $attachments)){
				unlink($pdfFilePath);
				$this->response(['status' => TRUE, 'message' => 'Email Sent'], REST_Controller::HTTP_OK);
			}else{
				$this->response(['status' => TRUE, 'message' => 'Something Went Wrong, Please try again Later'], REST_Controller::HTTP_OK);
			}
		}
	}
	
	//mokshes shah
	public function delete_training_plan_post(){
        $response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){
				$this->response([
				'status' => FALSE,
				'message' => 'Id Is Required',
				], REST_Controller::HTTP_OK);
			}
			
			$id = $this->input->post('id');
			
			$data = $this->user->delete_data($id, 'training_plan');
			
			if($data){
				$this->response([
					'status' => TRUE,
					'message' => 'Data Deleted',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => TRUE,
					'message' => 'Something Went Wrong, Please try again Later',
				], REST_Controller::HTTP_OK);
			}
		}
	}
	
	public function get_all_training_plan_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			$data = $this->user->get_all_data_by_user('training_plan', $user['id']);
			if(is_array($data)){
				$TrainingPlans = array();
				foreach($data as $d){
					$this->db->select('training_plan_exercise.*, exercise.description, exercise.equipment, exercise.name as exercise_name, exercise.exercise_type, exercise.description as exercise_description, training_plan.name as training_name, training_plan.description as training_description');
					$this->db->where('training_plan_exercise.creator_type', $user['id']);
					$this->db->where('training_plan_exercise.dl', 0);
					$this->db->where('training_plan_exercise.plan_id', $d['id']);
					$this->db->join('exercise', 'exercise.id = training_plan_exercise.exercise_id');
					$this->db->join('training_plan', 'training_plan.id = training_plan_exercise.plan_id');
					$result = $this->db->get('training_plan_exercise')->result_array();
					$d['exercise'] = array();
					foreach($result as $row){
						array_push($d['exercise'], $row);
					}
					array_push($TrainingPlans, $d);
				}
				$this->response([
					'status' => TRUE,
					'message' => 'Success',
					'data' => $TrainingPlans,
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
                    'status' => TRUE,
                    'message' => 'Error',
                    'data' => 'Something Went Wrong, Please try again Later',
                ], REST_Controller::HTTP_OK);
			}   
		}
    }
	
	public function get_training_plan_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){
				$this->response([
				'status' => FALSE,
				'message' => 'Id Is Required',
				], REST_Controller::HTTP_OK);
			}
			$id = $this->input->post('id');
			$data = $this->user->get_data($id, 'training_plan')[0];
			$this->db->select('training_plan_exercise.*, exercise.description, exercise.equipment, exercise.name as exercise_name, exercise.exercise_type, exercise.description as exercise_description');
			$this->db->where('training_plan_exercise.creator_type', $user['id']);
			$this->db->where('training_plan_exercise.dl', 0);
			$this->db->where('training_plan_exercise.plan_id', $data['id']);
			$this->db->join('exercise', 'exercise.id = training_plan_exercise.exercise_id');
			$result = $this->db->get('training_plan_exercise')->result_array();
			$data['exercise'] = array();
			foreach($result as $row){
				array_push($data['exercise'], $row);
			}
			if(is_array($data)){
				$this->response(['status' => TRUE, 'message' => 'Success', 'data' => $data], REST_Controller::HTTP_OK);
			}else{
				$this->response(['status' => TRUE, 'message' => 'Error', 'data' => 'Something Went Wrong, Please try again Later'], REST_Controller::HTTP_OK);
			}
		}
	}
	
	public function add_session_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$id = false;
			$user = $response['user'];
			if(empty($this->input->post('session_date'))){ $this->response(['status' => FALSE, 'message' => 'Enter Session date'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('training_plan_id'))){ $this->response(['status' => FALSE, 'message' => 'Enter Training Plan Id'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('client_id'))){ $this->response(['status' => FALSE, 'message' => 'Enter Client Id'], REST_Controller::HTTP_OK); }
        	if(empty($this->input->post('muscle_group'))){ $this->response(['status' => FALSE, 'message' => 'Enter Muscle Group'], REST_Controller::HTTP_OK); }
        	
			$data_array = array(
				'creator_type' => $user['id'],
				'training_plan_id' => $this->input->post('training_plan_id'),
				'client_id' => $this->input->post('client_id'),
				'session_date' => strtotime($this->input->post('session_date')),
				'muscle_group' => ($this->input->post('muscle_group')),
				'datetime' => time()
			);
			$id = $this->user->insert_data($data_array, 'session');				

			if($id){
				$this->response(['status' => TRUE, 'message' => 'Data inserted Successfully', 'data' => array('id' => $id)], REST_Controller::HTTP_OK);
			}else{
				$this->response(['status' => TRUE, 'message' => 'Something Went Wrong, Please try again Later', 'data' => array()], REST_Controller::HTTP_OK);
			}
		}
	}
	
	public function end_session_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$id = false;
			$user = $response['user'];
			if(empty($this->input->post('session_id'))){ $this->response(['status' => FALSE, 'message' => 'Enter Session Id'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('remarks_by_trainer'))){ $this->response(['status' => FALSE, 'message' => 'Enter Session Id'], REST_Controller::HTTP_OK); }
			$Data = array('status' => 1, 'remarks_by_trainer' => $this->input->post('remarks_by_trainer'));
			
			$result = $this->db->where('id', $this->input->post('session_id'))->update('session', $Data);
			if($result){
				$this->response(['status' => TRUE, 'message' => 'Session Ended Successfully', 'data' => array()], REST_Controller::HTTP_OK);
			}else{
				$this->response(['status' => TRUE, 'message' => 'Something Went Wrong, Please try again Later', 'data' => array()], REST_Controller::HTTP_OK);
			}
		}
	}
	
	public function exercise_status_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$id = false;
			$user = $response['user'];
			if(empty($this->input->post('session_id'))){ $this->response(['status' => FALSE, 'message' => 'Enter Session Id'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('exercise_id'))){ $this->response(['status' => FALSE, 'message' => 'Enter Exercise Id'], REST_Controller::HTTP_OK); }
			if($this->input->post('exercise_status') == ""){ $this->response(['status' => FALSE, 'message' => 'Enter Exercise Status'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('sets_done'))){ $this->response(['status' => FALSE, 'message' => 'Enter Sets Done'], REST_Controller::HTTP_OK); }

			$data_array = array(
				'session_id' => $this->input->post('session_id'),
				'exercise_id' => $this->input->post('exercise_id'),
				'sets_done' => $this->input->post('sets_done'),
				'status' => $this->input->post('exercise_status'),
				'datetime' => time()
			);
			$this->db->select('*')->where('session_id', $this->input->post('session_id'))->where('exercise_id', $this->input->post('exercise_id'))->from('session_data');
			$query = $this->db->get();
			$Sessions = array();
			if ($query->num_rows() > 0){
				$Sessions = $query->result_array();
			}
			if(count($Sessions) > 0){
				$id = $Sessions[0]['id'];
				$id = $this->user->update_data($id ,$data_array, 'session_data');							
				if($id){
					$id = $Sessions[0]['id'];
					$Data = array('last_exercise_id' => $this->input->post('exercise_id'), 'last_exercise_status' => $this->input->post('exercise_status'));
					$result = $this->db->where('id', $this->input->post('session_id'))->update('session', $Data);
					$this->response(['status' => TRUE, 'message' => 'Data Updated Successfully', 'data' => array('id' => $id)], REST_Controller::HTTP_OK);
				}else{
					$this->response(['status' => TRUE, 'message' => 'Something Went Wrong, Please try again Later', 'data' => array()], REST_Controller::HTTP_OK);
				}
			}else{
				$id = $this->user->insert_data($data_array, 'session_data');	
				if($id){
					$Data = array('last_exercise_id' => $this->input->post('exercise_id'), 'last_exercise_status' => $this->input->post('exercise_status'));
					$result = $this->db->where('id', $this->input->post('session_id'))->update('session', $Data);
					$this->response(['status' => TRUE, 'message' => 'Data inserted Successfully', 'data' => array('id' => $id)], REST_Controller::HTTP_OK);
				}else{
					$this->response(['status' => TRUE, 'message' => 'Something Went Wrong, Please try again Later', 'data' => array()], REST_Controller::HTTP_OK);
				}				
			}
		}
	}
	
	public function get_session_post(){
		$response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			
			$this->db->select('*')->where('creator_type', $user['id'])->from('session');
		    $query = $this->db->get();
			$Sessions = array();
			if ($query->num_rows() > 0){
				$Session_results = $query->result_array();
				foreach($Session_results as $session_result){
					$session = $session_result;
					$this->db->select('*')->where('session_id', $session_result['id'])->from('session_data');
					$query = $this->db->get();
					$session_data = $query->result_array();
					$session['data'] = $session_data;
					
					$this->db->select('*')->where('id', $session_result['client_id'])->from('users');
					$query = $this->db->get();
					$client_data = $query->result_array();
					$session['client'] = $client_data;
					
					$session['training'] = array();
					$id = $session_result['training_plan_id'];
					$session['training'] = $this->user->get_data($id, 'training_plan')[0];
					$this->db->select('training_plan_exercise.*, exercise.name as exercise_name, exercise.description as exercise_description');
					$this->db->where('training_plan_exercise.creator_type', $user['id']);
					$this->db->where('training_plan_exercise.dl', 0);
					$this->db->where('training_plan_exercise.plan_id', $session['training']['id']);
					$this->db->join('exercise', 'exercise.id = training_plan_exercise.exercise_id');
					$result = $this->db->get('training_plan_exercise')->result_array();
					$session['training']['exercise'] = array();
					foreach($result as $row){
						array_push($session['training']['exercise'], $row);
					}
					array_push($Sessions, $session);
				}
				$this->response(['status' => TRUE, 'message' => 'Success', 'data' => $Sessions], REST_Controller::HTTP_OK);
			}else{
				$this->response(['status' => FALSE, 'message' => 'No Session Data is Availible', 'data' => array()], REST_Controller::HTTP_OK);
			}
		}
	}
	
	public function send_session_report_cardio_post(){ $this->send_session_report_post("cardio"); }
	public function send_session_report_weightlift_post(){ $this->send_session_report_post("weight-lift"); }
	
	public function send_session_report_post($type){
		if(empty($type)){ $this->response(['status' => FALSE, 'message' => 'You are using Older Version of API'], REST_Controller::HTTP_OK); }
        $response = auth_api($this->user);
		if(!$response['status']){
			$this->response($response, REST_Controller::HTTP_OK);
		}else{
			$user = $response['user'];
			if(empty($this->input->post('id'))){ $this->response(['status' => FALSE, 'message' => 'Id Is Required'], REST_Controller::HTTP_OK); }
			if(empty($this->input->post('client_email'))){ $this->response(['status' => FALSE, 'message' => 'Email Id Is Required'], REST_Controller::HTTP_OK); }
			$id = $this->input->post('id');
			$email = $this->input->post('client_email');
			
			$this->db->select('*')->where('creator_type', $user['id'])->where('id', $id)->from('session');
		    $query = $this->db->get();
			$Sessions = array();
			if($query->num_rows() == 0){
				$this->response(['status' => FALSE, 'message' => 'No Session Found'], REST_Controller::HTTP_OK);
			}
			$session = $query->result_array()[0];
			$trainer_name = $this->user->get_name($session['creator_type']);
			
			$session['training'] = array();
			$session['training'] = $this->user->get_data($session['training_plan_id'], 'training_plan')[0];
			
			$this->db->select('session_data.*, training_plan_exercise.resistance, training_plan_exercise.duration, training_plan_exercise.exercise_sets, training_plan_exercise.weight, training_plan_exercise.exercise_repeat, exercise.name as exercise_name, exercise.description as exercise_description');
			$this->db->where('training_plan_exercise.creator_type', $user['id']);
			$this->db->where('training_plan_exercise.dl', 0);
			$this->db->where('training_plan_exercise.plan_id', $session['training_plan_id']);
			$this->db->join('exercise', 'exercise.id = training_plan_exercise.exercise_id');
			$this->db->join('session_data', 'session_data.exercise_id = training_plan_exercise.id');
			$result = $this->db->get('training_plan_exercise')->result_array();
			$session['training']['exercise'] = array();
			$MaxSets = 0;
			foreach($result as $row){
				if($row['exercise_sets'] > $MaxSets){
					$MaxSets = $row['exercise_sets'];
				}
				array_push($session['training']['exercise'], $row);
			}
			$html = "";
			$html .= "<h3>Training Plan Name : ".$session['training']['name']."</h3>";
			$html .= "<p><h4>Date: From ".date('Y-m-d H:i:s', $session['training']['from_date'])." To : ".date('Y-m-d H:i:s',$session['training']['to_date'])."</h4></p>";
			$html .= "<p><h4><b>Muscle groups worked out : </b>______________________ </h4></p><p><h4>Session Name : ".$session['title']."</h4></p>";
			$Subject = "Session Report";
			if($session['training']['type'] == "cardio"){
				$Subject = "Session Report Cardio";
				$html .= "<table border='1'>";
					$html .= "<tr><td>Exercise</td>";
					for($i = 1; $i <= $MaxSets; $i++){
						$html .= "<td>Set $i</td>";
					}
					$html .= "</tr>";
					foreach($session['training']['exercise'] as $row){
						$exercise_name = $row['exercise_name'];
						$html .= "<tr>";
							$html .= "<td>$exercise_name</td>";
							for($i = 1; $i <= $MaxSets; $i++){
								$temp_result = 0;
								if($row['sets_done'] >= $i){
									$temp_result = $row['resistance'] / $row['duration'];
								}
								$html .= "<td>$temp_result</td>";
							}
						$html .= "</tr>";
					}
				$html .= "</table>";
			}elseif($session['training']['type'] == "weight-lift"){
				$Subject = "Session Report Weight Lift";
				$html .= "<table border='1'>";
					$html .= "<tr><td>Exercise</td>";
					for($i = 1; $i <= $MaxSets; $i++){
						$html .= "<td>Set $i</td>";
					}
					$html .= "</tr>";
					foreach($session['training']['exercise'] as $row){
						$exercise_name = $row['exercise_name'];
						$html .= "<tr>";
							$html .= "<td>$exercise_name</td>";
							for($i = 1; $i <= $MaxSets; $i++){
								$temp_result = 0;
								if($row['sets_done'] >= $i){
									$temp_result = $row['weight']." Kg(s) / ".$row['exercise_repeat'];
								}
								$html .= "<td>$temp_result</td>";
							}
						$html .= "</tr>";
					}
				$html .= "</table>";
			}
			$html .= "<p><b>Remarks on this session by $trainer_name : </b></p>";
			$html .= "<p>".$session['remarks_by_trainer']."</p>";
			$this->load->library('m_pdf');
			$this->data['title'] = "MY PDF TITLE 1.";
			$this->data['description'] = "Description";
			$pdfFilePath = "temp_pdfs/trainingplan-".time().".pdf";
			$pdf = $this->m_pdf->load();
			$pdf->WriteHTML($html);
			$pdf->Output($pdfFilePath, "F");
			
			$attachments = array(APPPATH ."../". $pdfFilePath);
			$MailBody = "Dear Customer, <br><br>$trainer_name has sent you a the session report executed on ".date('Y-m-d H:i:s', $session['datetime']).". Here is your session report in the attachment sent via Envo Sports application<br>[LOGO]<br>Kind Regards,<br>Envo Sports Support Team";
			
			if($this->user->send_email($email, $Subject, $MailBody, $attachments)){
				unlink($pdfFilePath);
				$this->response(['status' => TRUE, 'message' => 'Email Sent'], REST_Controller::HTTP_OK);
			}else{
				$this->response(['status' => TRUE, 'message' => 'Something Went Wrong, Please try again Later'], REST_Controller::HTTP_OK);
			}
		}
	}
}