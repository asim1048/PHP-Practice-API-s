<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class Uploadimage{

	
	public function uploadfile($directory,$alowedtype,$filename){
		$CI =& get_instance();
		$CI->load->library('upload');
    	$CI->load->library('image_lib');
    	$dataInfo = array();
    	$files = $_FILES;

    	 $cpt = count($_FILES[$filename]['name']);
	    for($i=0; $i<$cpt; $i++)
	    {          
	        $_FILES['userfile']['name']= $files[$filename]['name'][$i]; 
	        $_FILES['userfile']['type']= $files[$filename]['type'][$i];
	        $_FILES['userfile']['tmp_name']= $files[$filename]['tmp_name'][$i];
	        $_FILES['userfile']['error']= $files[$filename]['error'][$i];
	        $_FILES['userfile']['size']= $files[$filename]['size'][$i];    

	        $CI->upload->initialize($this->set_upload_options($directory,$alowedtype));
	        $CI->upload->do_upload();
	       
	        $dataInfo[] = $CI->upload->data();
	    }

	    return $dataInfo;
	}

	private function set_upload_options($directory,$alowedtype )
	{   
	    $config = array();
	    
	    $config['upload_path'] = $directory;
	    $config['allowed_types'] = $alowedtype;
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;


	    return $config;
	}

	public function resizeimage($results,$width,$height){ 
		$CI =& get_instance();
		$CI->load->library('image_lib');
			foreach($results as $keys=>$row) {
			    $config['image_library'] = 'gd2';
			    $config['source_image'] = $results[$keys]['full_path'];
			    $config['create_thumb'] = TRUE;
			    $config['maintain_ratio'] = TRUE;
			    $config['width']     = $width;
			    $config['height']   = $height;

			    $CI->image_lib->clear();
			    $CI->image_lib->initialize($config);
			    $CI->image_lib->resize();
			}
			
	}



}
?>