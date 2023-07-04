<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
//http://localhost/practice/Api/endPoint
class Api extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('Common');
        $this->load->library('Uploadimage');
        //error_reporting(0);
    }
    public function registerUser_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $name = $data['name'];
        $number = $data['number'];
        $password = $data['password'];

        // Check if the number already exists
        $existingUser = $this->db->get_where('user', array('number' => $number))->row_array();

        if ($existingUser) {
            $this->response([
                'status' => false,
                'message' => 'Number already exists'
            ], 200);
        } else {
            // Create a new user
            $newUser = array(
                'name' => $name,
                'number' => $number,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            );

            // Insert the new user into the database
            $this->db->insert('user', $newUser);

            $this->response([
                'status' => true,
                'message' => 'User registered successfully'
            ], 200);
        }
    }
    public function login_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $number = $data['number'];
        $password = $data['password'];

        // Check if the user exists
        $user = $this->db->get_where('user', array('number' => $number))->row_array();

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                $this->response([
                    'status' => true,
                    'message' => 'Login successful',
                    'data' => $user
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Invalid password'
                ], 200);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'User not found'
            ], 200);
        }
    }
    public function updatePassword_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $number = $data['number'];
        $password = $data['password'];

        // Check if the user exists
        $user = $this->db->get_where('user', array('number' => $number))->row_array();

        if ($user) {
            // Update the password
            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->db->where('number', $number);
            $this->db->update('user', array('password' => $encryptedPassword));

            $this->response([
                'status' => true,
                'message' => 'Password updated successfully'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'User not found'
            ], 200);
        }
    }
    public function checkExistence_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $number = $data['number'];

        // Check if the user exists
        $user = $this->db->get_where('user', array('number' => $number))->row_array();

        if ($user) {
            $this->response([
                'status' => true,
                'message' => 'User exists'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'User does not exist'
            ], 200);
        }
    }
    public function userDetail_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $number = $data['number'];

        // Check if the user exists
        $this->db->select('*, CONCAT("http://localhost/practice/assets/images/dps/", image) AS image_path')
            ->from('user')
            ->where('number', $number);

        $query = $this->db->get();
        $user = $query->row_array();

        if ($user) {
            unset($user['password']); // Remove the 'password' field from the user array

            $this->response([
                'status' => true,
                'message' => 'User found',
                'data' => $user
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'User not found'
            ], 200);
        }
    }
    public function addDoctor_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $name = $data['name'];
        $specialization = $data['specialization'];
        $experience = $data['experience'];
        $fee = $data['fee'];

        // Create a new doctor
        $newDoctor = array(
            'name' => $name,
            'specialization' => $specialization,
            'experience' => $experience,
            'fee' => $fee
        );

        // Insert the new doctor into the database
        $this->db->insert('doctors', $newDoctor);

        $this->response([
            'status' => true,
            'message' => 'Doctor added successfully'
        ], 200);
    }
    public function addDoctorTiming_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $doctorId = $data['doctor_id'];
        $time = $data['time'];

        // Get the current date
        $currentDate = date('Y-m-d');

        // Check if the time already exists for the same date and doctor
        $existingTiming = $this->db->get_where('doctor_timing', array('doctor_id' => $doctorId, 'time' => $time, 'date' => $currentDate))->row_array();

        if ($existingTiming) {
            $this->response([
                'status' => false,
                'message' => 'Time already exists for the same date and doctor.'
            ], 200);
            return;
        }

        // Prepare the data for insertion
        $newTiming = array(
            'doctor_id' => $doctorId,
            'time' => $time,
            'date' => $currentDate
        );

        // Insert the data into the database
        $this->db->insert('doctor_timing', $newTiming);

        $this->response([
            'status' => true,
            'message' => 'Doctor timing added successfully'
        ], 200);
    }
    public function getDoctorTimings_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $doctorId = $data['doctor_id'];
        $date = $data['date'];

        // Perform validation on the input parameters (e.g., ensure they are not empty or null)

        // Query the database for the doctor timings
        $timings = $this->db->get_where('doctor_timing', array('doctor_id' => $doctorId, 'date' => $date))->result_array();

        if ($timings) {
            $this->response([
                'status' => true,
                'message' => 'Doctor timings found',
                'data' => $timings
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No doctor timings found for the given doctor ID and date'
            ], 200);
        }
    }
    public function addAppointment_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }
        $data = $_POST;
        $doctorId = $data['doctor_id'];
        $userId = $data['user_id'];
        $time = $data['time'];
        $fee = $data['fee'];

        // Get the current date
        $currentDate = date('Y-m-d');
        $selectedDate = $currentDate;

        // Check if the patient already has an appointment on the selected date
        $existingAppointment = $this->db->get_where('appoinment', array('user_id' => $userId, 'date' => $selectedDate))->row();

        if ($existingAppointment) {
            $this->response([
                'status' => false,
                'message' => 'You already have an appointment on this date'
            ], 200);
            return; // Stop further execution
        }

        // Check if there are any conflicting appointments for the selected time slot
        $conflictingAppointment = $this->db->get_where('appoinment', array('doctor_id' => $doctorId, 'time' => $time, 'date' => $selectedDate))->row();

        if ($conflictingAppointment) {
            $this->response([
                'status' => false,
                'message' => 'This time slot is already booked'
            ], 200);
            return; // Stop further execution
        }

        // Prepare the data for insertion
        $newAppointment = array(
            'doctor_id' => $doctorId,
            'user_id' => $userId,
            'time' => $time,
            'fee' => $fee,
            'date' => $selectedDate,
            'completed' => false
        );

        // Insert the data into the database
        $inserted = $this->db->insert('appoinment', $newAppointment);

        if ($inserted) {
            $this->response([
                'status' => true,
                'message' => 'Appointment added successfully'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to add appointment'
            ], 200);
        }
    }
    public function updateAppointmentCompletedStatus_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $appointmentId = $data['appointment_id'];

        // Check if the appointment exists
        $existingAppointment = $this->db->get_where('appoinment', array('id' => $appointmentId))->row();

        if ($existingAppointment) {
            // Prepare the data for update
            $updatedAppointment = array(
                'completed' => true
            );

            // Update the appointment in the database
            $this->db->where('id', $appointmentId);
            $updated = $this->db->update('appoinment', $updatedAppointment);

            if ($updated) {
                $this->response([
                    'status' => true,
                    'message' => 'Appointment completed status updated successfully'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Failed to update appointment completed status'
                ], 200);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Appointment not found'
            ], 200);
        }
    }
    public function getUsersByDoctor_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $doctorId = $data['doctor_id'];

        // Retrieve user details for the specific doctor
        $users = $this->db->distinct()
            ->select('user.id, user.name, user.number, CONCAT("http://localhost/practice/assets/images/dps/", image) AS image_path')
            ->from('appoinment')
            ->join('user', 'user.id = appoinment.user_id')
            ->where('appoinment.doctor_id', $doctorId)
            ->get()
            ->result();


        if (!empty($users)) {
            $this->response([
                'status' => true,
                'data' => $users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No users found for the specified doctor'
            ], 200);
        }
    }
    public function uploaddp_post()
    {
        $userData = array();
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST; {
            $id = $data['id'];
            $created_dt = date('Y-m-d');
            $status = "Started";


            if ($_FILES['attachment']['name'] != "") {
                $projects_folder_path = './assets/images/dps/';

                $orignal_file_name = $_FILES['attachment']['name'];

                $file_ext = ltrim(strtolower(strrchr($_FILES['attachment']['name'], '.')), '.');

                $rand_num = rand(1, 1000);

                $config['upload_path'] = $projects_folder_path;
                $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf';
                $config['overwrite'] = false;
                $config['encrypt_name'] = TRUE;
                //$config['file_name'] = $file_name;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment')) {
                    $error_file_arr = array('error' => $this->upload->display_errors());
                } else {
                    $data_image_upload = array('upload_image_data' => $this->upload->data());
                    $filename = $data_image_upload['upload_image_data']['file_name'];
                    $full_path =   $data_image_upload['upload_image_data']['full_path'];
                }
            }


            $udate['image'] = $filename;

            $con['conditions'] = array("id" => $id);
            $this->Common->update("user", $udate, $con);
            $record = $this->db->query("SELECT * from user where id='$id'")->row_array();
            if ($record) {
                $this->response([
                    'status' => True,
                    'message' => 'DP uploaded successfully. ',
                    'data' => $record
                ], 200);
            } else {
                $this->response([
                    'status' => False,
                    'message' => 'An Error Occur While Adding Query !',
                ], 200);
            }
        }
    }
    public function addSlider_post()
    {
        $userData = array();
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }
        $data = $_POST; {
            $status = $data['status'];
            if ($_FILES['attachment']['name'] != "") {
                $projects_folder_path = './assets/images/slider/';

                $orignal_file_name = $_FILES['attachment']['name'];

                $file_ext = ltrim(strtolower(strrchr($_FILES['attachment']['name'], '.')), '.');

                $rand_num = rand(1, 1000);

                $config['upload_path'] = $projects_folder_path;
                $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf';
                $config['overwrite'] = false;
                $config['encrypt_name'] = TRUE;
                //$config['file_name'] = $file_name;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment')) {
                    $error_file_arr = array('error' => $this->upload->display_errors());
                } else {
                    $data_image_upload = array('upload_image_data' => $this->upload->data());
                    $filename = $data_image_upload['upload_image_data']['file_name'];
                    $full_path =   $data_image_upload['upload_image_data']['full_path'];
                }
            }

            $udate['image'] = $filename;

            $udate['status'] = $status;
            $this->Common->insert("slider", $udate);
            $record = $this->db->query("SELECT * from slider")->row_array();
            if ($record) {
                $this->response([
                    'status' => True,
                    'message' => 'Slider uploaded successfully. ',
                    'data' => $record
                ], 200);
            } else {
                $this->response([
                    'status' => False,
                    'message' => 'An Error Occur While Adding Slider !',
                ], 200);
            }
        }
    }
    public function getAllSliders_get()
    {
        $this->load->helper('url');
        $sliders = $this->db->get('slider')->result_array();
        if ($sliders) {
            foreach ($sliders as &$slider) {
                $slider['image_url'] = "http://localhost/practice/assets/images/slider/" . $slider['image'];
            }
            $this->response([
                'status' => true,
                'message' => 'Sliders data retrieved successfully.',
                'data' => $sliders
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No sliders found.',
            ], 200);
        }
    }
    public function addChat_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        $data = $_POST;
        $sender_id = $data['sender_id'];
        $receiver_id = $data['receiver_id'];
        $message = $data['message'];
        $date = date("Y-m-d");
        $time = date("H:i:s");

        // Create a new chat record
        $newChat = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message,
            'date' => $date,
            'time' => $time
        );

        // Insert the new chat record into the database
        if ($this->db->insert('chat', $newChat)) {
            // Get the ID of the inserted record
            $insertedId = $this->db->insert_id();

            // Fetch the inserted record from the database
            $insertedRecord = $this->db->get_where('chat', array('id' => $insertedId))->row_array();

            $this->response([
                'status' => true,
                'message' => 'Chat added successfully',
                'data' => $insertedRecord
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to add chat'
            ], 500);
        }
    }
    public function getLastMessage_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
    
        if (is_array($obj)) {
            $_POST = (array)$obj;
        }
    
        // Get input data
        $senderId = $_POST['sender_id'];
        $receiverId = $_POST['receiver_id'];
    
        // Fetch the latest chat record with user name
        $this->db->select('chat.*, user.name AS sender_name');
        $this->db->from('chat');
        $this->db->join('user', 'chat.sender_id = user.id');
        $this->db->where("(chat.sender_id = $senderId AND chat.receiver_id = $receiverId) OR (chat.sender_id = $receiverId AND chat.receiver_id = $senderId)");
        $this->db->order_by('chat.date', 'desc');
        $this->db->order_by('chat.time', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
    
        // Check if a record is found
        if ($query->num_rows() > 0) {
            $record = $query->row_array();
    
            $this->response([
                'status' => true,
                'message' => 'Latest chat record retrieved successfully',
                'data' => $record
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No chat record found'
            ], 200);
        }
    }
    public function getAllMessages_post()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (is_array($obj)) {
            $_POST = (array)$obj;
        }

        // Get input data
        $senderId = $_POST['sender_id'];
        $receiverId = $_POST['receiver_id'];

        // Fetch all chat records
        $this->db->select('*');
        $this->db->from('chat');
        $this->db->where("(sender_id = $senderId AND receiver_id = $receiverId) OR (sender_id = $receiverId AND receiver_id = $senderId)");
        $this->db->order_by('date', 'asc');
        $this->db->order_by('time', 'asc');
        $query = $this->db->get();

        // Check if records are found
        if ($query->num_rows() > 0) {
            $records = $query->result_array();

            $this->response([
                'status' => true,
                'message' => 'Chat records retrieved successfully',
                'data' => $records
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No chat records found'
            ], 200);
        }
    }
    public function getUsersWithLastMessage_get()
    {
        // Fetch all users who have had chats
        $this->db->distinct();
        $this->db->select('user.*');
        $this->db->from('user');
        $this->db->join('chat', 'chat.sender_id = user.id OR chat.receiver_id = user.id');
        $query = $this->db->get();
        $users = $query->result_array();
    
        if ($query->num_rows() > 0) {
            // Fetch the last chat record for each user
            foreach ($users as &$user) {
                $userId = $user['id'];
                $this->db->select('*');
                $this->db->from('chat');
                $this->db->where("(sender_id = $userId OR receiver_id = $userId)");
                $this->db->order_by('date', 'desc');
                $this->db->order_by('time', 'desc');
                $this->db->limit(1);
                $query = $this->db->get();
    
                if ($query->num_rows() > 0) {
                    $record = $query->row_array();
                    $user['last_message'] = $record;
                } else {
                    $user['last_message'] = null;
                }
            }
    
            $this->response([
                'status' => true,
                'message' => 'Users with their last chat records retrieved successfully',
                'data' => $users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No users found with chat records'
            ], 200);
        }
    }
}
