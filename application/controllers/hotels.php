<?php

class Hotels extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('hotels'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Hotel','Country'));
						
	}
	public function delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('hotels',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('hotels');
		 } 
	}

	public function delete_checked()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('hotels');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('hotels',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('hotels');
		}
	}
	public function GetCities()
	{
		$country_id	= $_POST['id'];
		$city_id	= $_POST['city_id'];
		$cities=$this->Country->GetCitiesByCountryId($country_id);
		$array_cities['']='Select City';
		foreach($cities as $city)
			{
				$array_cities[$city->id]=$city->city;
			}
		$city_class=' id="city_id"  class="validate[required]"';	
		echo form_dropdown('city_id', $array_cities,$city_id,$city_class);
		}			
	public function index()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),5,15,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),5,15,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),5,14,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;			
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Hotel->GetHotels();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('View Hotels');
		$this->data['title'] = "Inma Kingdom Training System - Hotels List";
		$this->template->load('_template', 'hotels', $this->data);		
	}
	
	public function details()
	{
		$get = $this->uri->uri_to_assoc();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Courses','courses');
		$this->breadcrumb->add_crumb('Details');		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Course->GetCourseById($get['id']);
		$this->data['title'] = "Inma Kingdom Training System - Course Info";
		$this->template->load('_template', 'course_details', $this->data);		
	}	
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Hotels','hotels');
			$this->breadcrumb->add_crumb('Add Hotel');		
			$this->form_validation->set_rules('name', 'Hotel Name', 'required');
			$this->form_validation->set_rules('rating', 'Hotel rating', 'trim');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('city_id', 'City', 'trim');
			$this->form_validation->set_rules('country_id', 'Country', 'trim');
			$this->form_validation->set_rules('status', 'Status', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'name' => $this->form_validation->set_value('name'),
				'rating' => $this->form_validation->set_value('rating'),
				'phone' => $this->form_validation->set_value('phone'),
				'city_id' => $this->form_validation->set_value('city_id'),
				'country_id' => $this->form_validation->set_value('country_id'),
				'status' => $this->form_validation->set_value('status'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('hotels',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Hotel Added successfully'));	
					redirect('hotels');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('hotels/create');					
				}
				
			 }
				$this->data['hotel_id'] = '';
				$this->data['name'] = '';
				$this->data['rating'] = '';
				$this->data['phone'] = '';
				$this->data['city_id'] = '';
				$this->data['country_id'] = '';
				$this->data['status'] = '';
				$this->data['subtitle'] = 'Add New Hotel';
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['title'] = "Inma Kingdom training system - Create New Hotel";
				$this->template->load('_template', 'hotel_form', $this->data);	
	}
	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Hotels','hotels');
			$this->breadcrumb->add_crumb('Edit Hotel');		
			$this->form_validation->set_rules('name', 'Hotel Name', 'required');
			$this->form_validation->set_rules('rating', 'Hotel rating', 'trim');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('city_id', 'City', 'trim');
			$this->form_validation->set_rules('country_id', 'Country', 'trim');
			$this->form_validation->set_rules('status', 'Status', 'trim');

			if ($this->form_validation->run()) {

				$data = array(
				'name' => $this->form_validation->set_value('name'),
				'rating' => $this->form_validation->set_value('rating'),
				'phone' => $this->form_validation->set_value('phone'),
				'city_id' => $this->form_validation->set_value('city_id'),
				'country_id' => $this->form_validation->set_value('country_id'),
				'status' => $this->form_validation->set_value('status'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				if($this->Administrator->edit('hotels',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Hotel Updated successfully'));
					redirect('hotels');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('hotels/edit/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Hotel->GetHotelById($get['id']);
				$this->data['hotel_id'] = $row['id'];
				$this->data['name'] = $row['name'];
				$this->data['rating'] = $row['rating'];
				$this->data['phone'] = $row['phone'];
				$this->data['city_id'] = $row['city_id'];
				$this->data['country_id'] = $row['country_id'];
				$this->data['status'] = $row['status'];
				$this->data['subtitle'] = 'Edit Hotel';
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['title'] = "Inma Kingdom training system - Edit Hotel";
				$this->template->load('_template', 'hotel_form', $this->data);		
	}
	
											
}

?>