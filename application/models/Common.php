<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        $this->load->database();
    }

	
    function genrate_session_key($user_id){
        return $new_key = md5(microtime().rand().$user_id);
        
    }
    
    function get_session($session_key){
        $session = $this->db->where('session_key', $session_key)->get($this->db_session)->row_array();
        if(is_array($session)){
            return $session;
        }else{
            return false;
        }
    }

    public function insert($table,$data = array()){
        
        $query = $this->db->insert($table,$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function get_rows($table, $params = array()){
        $this->db->select('*');
        $this->db->from($table);

        if(array_key_exists("conditions", $params)){

            foreach ($params['conditions'] as $key => $value) {
                 $this->db->where($key,$value);
            }

            $query = $this->db->get();
            if($query->num_rows() > 0){

                return $query->result_array();
            }else{
                return false;
            }

        }else{
            return false;
        }
    }


    public function get_single_row($table_name, $params = array()){
        $this->db->select('*');
        $this->db->from($table_name);

        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }

            $query = $this->db->get();
            if($query->num_rows() > 0){

                return $query->row();

            }else{
                return false;
            }
            
        

        }else{
            return false;
        }
    }

    public function update($table, $data = array(), $params = array()){
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
            if($this->db->update($table, $data)){
                return true;
            }
        }else{

            return false;

        }
        
    }

    public function count_record($table_name , $params=array()){
        $this->db->select("*");
        $this->db->from($table_name);

        if(array_key_exists("conditions", $params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }

            $query = $this->db->get();
            return $query->num_rows();

        }else{
            return false;
        }
    }

    public function delete($table,$record){
        $query = $this->db->delete($table, $record);
        if($query){
            return true;
        }else{
            return false;
        } 
    }
    
	
	public function send_email($to_email, $subject, $html, $attachments = array()){
		$from_email = "no-reply@yooshaa.com"; 
		$this->load->library('email'); 
		$config = array('charset'=>'utf-8', 'wordwrap'=> TRUE, 'mailtype' => 'html');
		$this->email->initialize($config);
		$this->email->from($from_email, 'Yooshaa');
		$this->email->to($to_email);
		$this->email->subject($subject);
		foreach($attachments as $attach){
			$this->email->attach($attach);
		}
		$html = str_replace("[LOGO]","<img src='http://envosports.com/app/logo.jpg'>",$html);
	
		$this->email->message($html);
		
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}
}