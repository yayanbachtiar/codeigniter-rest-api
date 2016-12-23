<?php
/* 
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */
 require APPPATH . '/libraries/REST_Controller.php';

 
class Menu extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
    } 

    /*
     * Listing of menu
     */
    function index_get()
    {
        $data = $this->Menu_model->get_all_menu();
		$this->response($data, REST_Controller::HTTP_OK);
    }

    function makanan_get()
    {
        $data = $this->Menu_model->get_menu_by_parent_id(1);
		$this->response($data, REST_Controller::HTTP_OK);
    }

    function minuman_get()
    {
        $data = $this->Menu_model->get_menu_by_parent_id(1);
		$this->response($data, REST_Controller::HTTP_OK);
    }

    /*
     * Adding a new menu
     */
    function index_post()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('menu','Menu','required|max_length[100]');
		$this->form_validation->set_rules('is_parent','Is Parent','required');
		$this->form_validation->set_rules('parent_id','Parent Id','integer');
		$this->form_validation->set_rules('price','Price','required|integer');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'menu' => $this->input->post('menu'),
				'is_parent' => $this->input->post('is_parent'),
				'parent_id' => $this->input->post('parent_id'),
				'price' => $this->input->post('price'),
            );
            
            $this->Menu_model->add_menu($params);
			$message = ['message'=> "created", "code"=> true];            
			$this->set_response($message, REST_Controller::HTTP_CREATED);
        }
        else
        {
            $message = ['message'=> validation_errors(), 'code'=> false];
			$this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }  

    /*
     * Editing a menu
     */
    function index_put($id)
    {   
        // check if the menu exists before trying to edit it
        $menu = $this->Menu_model->get_menu($id);
        
        if(isset($menu['id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('menu','Menu','required|max_length[100]');
			$this->form_validation->set_rules('is_parent','Is Parent','required');
			$this->form_validation->set_rules('parent_id','Parent Id','integer');
			$this->form_validation->set_rules('price','Price','required|integer');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'menu' => $this->input->post('menu'),
					'is_parent' => $this->input->post('is_parent'),
					'parent_id' => $this->input->post('parent_id'),
					'price' => $this->input->post('price'),
                );

                $this->Menu_model->update_menu($id,$params);            
                $message = ['message'=> "updated", "code"=> true];            
			    $this->set_response($message, REST_Controller::HTTP_CREATED);
            }
            else
            {   
                $message = ['message'=> validation_errors(), 'code'=> false];
			    $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else
            $message = ['message'=> 'invalid ID', 'code'=> false];
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    } 

    /*
     * Deleting menu
     */
    function index_delete($id)
    {
        $menu = $this->Menu_model->get_menu($id);

        // check if the menu exists before trying to delete it
        $message = ["message"=>"data is not exist", "code" => false]; 

        if(isset($menu['id']))
        {
            $this->Menu_model->delete_menu($id);
            $message = ['message'=>'successfull deleted', "code" => true];
			$this->set_response($message, REST_Controller::HTTP_OK);
        }
        else
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND); 
    }
    
}
