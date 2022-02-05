<?php

class Providers extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('providers'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Provider'));
						
	}
	public function GetInstructors()
	{
		$provider_id	= $_POST['id'];
		$instructor_id	= $_POST['instructor_id'];
		$instructors=$this->Provider->GetInstructorByProviderId($provider_id);
		$array_instructors[0]='Select Instructor';
		foreach($instructors as $instructor)
			{
				$array_instructors[$instructor->id]=$instructor->fullname;
			}
		$instructor_class=' id="instructor_id" ';	
		echo form_dropdown('instructor_id', $array_instructors,$instructor_id,$instructor_class);
		}	
	public function delete()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,9,'delete');
		if($p_delete){	
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_providers',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('providers');
		 } 
		}
		else{
			$this->data['subtitle'] = '403 Forbidden ';
			$this->load->view('403', $this->data);	 
		}		
	}
	public function delete_instructor()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,11,'delete');
		if($p_delete){			
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_instructors',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('providers/instructors');
		 } 
		}
		else{
			$this->data['subtitle'] = '403 Forbidden ';
			$this->load->view('403', $this->data);	 
		}		 
	}
	public function delete_checked_instructors()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,11,'delete');
		if($p_delete){				
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('providers/instructors');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('training_instructors',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('providers/instructors');
		}
			}
		else{
			$this->data['subtitle'] = '403 Forbidden ';
			$this->load->view('403', $this->data);	 
		}		
	}
	public function delete_checked_providers()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,9,'delete');
		if($p_delete){			
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('providers');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('training_providers',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('providers');
		}
		}
		else{
			$this->data['subtitle'] = '403 Forbidden ';
			$this->load->view('403', $this->data);	 
		}			
	}				
	public function index()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,9,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,9,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,8,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Provider->GetProviders();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Providers');
		$this->data['title'] = "Inma Kingdom Training System - Providers List";
		$this->template->load('_template', 'providers', $this->data);		
	}
	
	public function instructors()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,11,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,11,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),3,10,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;			
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Provider->GetAllInstructors();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Providers','providers');
		$this->breadcrumb->add_crumb('Instructors');
		$this->data['title'] = "Inma Kingdom Training System - Instructors List";
		$this->template->load('_template', 'instructors', $this->data);		
	}
	
	public function details()
	{
		$get = $this->uri->uri_to_assoc();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Providers','provider');
		$this->breadcrumb->add_crumb('Details');		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Provider->GetProviderById($get['id']);
		$this->data['title'] = "Inma Kingdom Training System - Provider Info";
		$this->template->load('_template', 'provider_details', $this->data);		
	}	
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Providers','providers');
			$this->breadcrumb->add_crumb('Add Provider');		
			$this->form_validation->set_rules('provider_title', 'title', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('email', 'Email', 'trim');
			$this->form_validation->set_rules('contact_person', 'Contact person', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'title' => $this->form_validation->set_value('provider_title'),
				'phone' => $this->form_validation->set_value('phone'),
				'email' => $this->form_validation->set_value('email'),
				'contact_person' => $this->form_validation->set_value('contact_person'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_providers',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Course Added successfully'));	
					redirect('providers/details/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('providers/create');					
				}
				
			 }
				$this->data['provider_id'] = '';
				$this->data['provider_title'] = '';
				$this->data['phone'] = '';
				$this->data['email'] = '';
				$this->data['contact_person'] = '';
				$this->data['subtitle'] = 'Add New Provider';
				$this->data['title'] = "Inma Kingdom training system - Create New Provider";
				$this->template->load('_template', 'provider_form', $this->data);	
	}
	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Providers','providers');
			$this->breadcrumb->add_crumb('Edit Provider');				
			$this->form_validation->set_rules('provider_title', 'title', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('email', 'Email', 'trim');
			$this->form_validation->set_rules('contact_person', 'Contact person', 'trim');

			if ($this->form_validation->run()) {

				$data = array(
				'title' => $this->form_validation->set_value('provider_title'),
				'phone' => $this->form_validation->set_value('phone'),
				'email' => $this->form_validation->set_value('email'),
				'contact_person' => $this->form_validation->set_value('contact_person'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				if($this->Administrator->edit('training_providers',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Provider Updated successfully'));
					redirect('providers/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('providers/edit/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Provider->GetProviderById($get['id']);
				$this->data['provider_id'] = $row['id'];
				$this->data['provider_title'] = $row['title'];
				$this->data['phone'] = $row['phone'];
				$this->data['email'] = $row['email'];
				$this->data['contact_person'] = $row['contact_person'];
				$this->data['subtitle'] = 'Edit Provider';
				$this->data['title'] = "Inma Kingdom Training System - Edit Provider";
				$this->template->load('_template', 'provider_form', $this->data);	
	}
	
	public function create_instructors()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Providers','providers');
			$this->breadcrumb->add_crumb('Instructors','providers/instructors');
			$this->breadcrumb->add_crumb('Create Instructor');		
			$this->form_validation->set_rules('fullname', 'Fullname', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('email', 'Email', 'trim');
			$this->form_validation->set_rules('provider_id', 'Provider', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'fullname' => $this->form_validation->set_value('fullname'),
				'phone' => $this->form_validation->set_value('phone'),
				'email' => $this->form_validation->set_value('email'),
				'provider_id' => $this->form_validation->set_value('provider_id'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_instructors',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Instructor Added successfully'));	
					redirect('providers/instructors');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('providers/create_instructors');					
				}
				
			 }
				$this->data['instructor_id'] = '';
				$this->data['fullname'] = '';
				$this->data['phone'] = '';
				$this->data['email'] = '';
				$this->data['provider_id'] = '';
				$this->data['subtitle'] = 'Add New Instructor';
				$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['title'] = "Inma Kingdom training system - Add New Instructor";
				$this->template->load('_template', 'instructor_form', $this->data);	
	}	
	public function edit_instructors()
	{
			$get = $this->uri->uri_to_assoc();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Providers','providers');
			$this->breadcrumb->add_crumb('Instructors','providers/instructors');
			$this->breadcrumb->add_crumb('Edit Instructor');		
			$this->form_validation->set_rules('fullname', 'Fullname', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('email', 'Email', 'trim');
			$this->form_validation->set_rules('provider_id', 'Provider', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'fullname' => $this->form_validation->set_value('fullname'),
				'phone' => $this->form_validation->set_value('phone'),
				'email' => $this->form_validation->set_value('email'),
				'provider_id' => $this->form_validation->set_value('provider_id'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

			if($this->Administrator->edit('training_instructors',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Course Updated successfully'));
					redirect('providers/instructors');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('providers/edit_instructors/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Provider->GetInstructorId($get['id']);
				$this->data['instructor_id'] = $row['instructor_id'];
				$this->data['fullname'] = $row['fullname'];
				$this->data['phone'] = $row['phone'];
				$this->data['email'] = $row['email'];
				$this->data['provider_id'] = $row['provider_id'];
				$this->data['subtitle'] = 'Edit Major';
				$this->data['title'] = "Inma Kingdom training system - Edit Major";
				$this->template->load('_template', 'instructor_form', $this->data);	
	}										
											
}

?>