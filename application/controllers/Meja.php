<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Meja extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Meja_model');
		
	}
	
	public function index_get() {
		$data = $this->Meja_model->get_all_meja();
		
		$this->response($data, REST_Controller::HTTP_OK);
	}
	
	function index_post()
				    {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('Nomor','Nomor','is_unique[meja.Nomor]');
		$this->form_validation->set_rules('Posisi','Posisi','max_length[100]');
		
		if($this->form_validation->run())     
								        {
			$params = array(
                'Nomor' => $this->input->post('Nomor'),
                'Posisi' => $this->input->post('Posisi'),
                'created_at' => $this->input->post('created_at'),
            );
			
			$this->Meja_model->add_meja($params);
			$message = ['message'=> "created", "code"=> true];            
			$this->set_response($message, REST_Controller::HTTP_CREATED);
		}
		else{
			$message = ['message'=> validation_errors(), 'code'=> false];
			$this->set_response($message, REST_Controller::HTTP_CREATED);
		}
	}
		
	function index_delete($id)
    {
        // $id = (int) $this->get('id');
		$meja = $this->Meja_model->get_meja($id);
		
		// 		check if the meja exists before trying to delete it
        $message = ["message"=>"data is not exist", "code" => false]; 
        if(isset($meja['id']))
        {
			$this->Meja_model->delete_meja($id);
            $message = ['message'=>'successfull deleted', "code" => true];
			$this->set_response($message, REST_Controller::HTTP_OK);
        }else{
			$this->set_response($message, REST_Controller::HTTP_NOT_FOUND);            
        }
        
	}
	
}
