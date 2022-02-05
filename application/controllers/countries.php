<?php

class Countries extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('countries'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Country','Hotel'));
						
	}
	public function GetCities()
	{
		$country_id	= $_POST['id'];
		$city_id	= $_POST['city_id'];
		$hotel_id	= $_POST['hotel_id'];
		$cities=$this->Country->GetCitiesByCountryId($country_id);
		$array_cities['']='Select City';
		foreach($cities as $city)
			{
				$array_cities[$city->id]=$city->city;
			}
		if($hotel_id=='')
		$hotel_id=0;	
		$city_class=' id="city_id"  class="validate[required]" onchange="gethotels(this.value,'.$hotel_id.')"';	
		echo form_dropdown('city_id', $array_cities,$city_id,$city_class);
		}
	public function GetHotels()
	{
		$city_id	= $_POST['id'];
		$hotel_id	= $_POST['hotel_id'];
		$hotels=$this->Hotel->GetHotelsByCityId($city_id);
		$array_hotels[0]='Select Hotel';
		foreach($hotels as $hotel)
			{
				$array_hotels[$hotel->id]=$hotel->name;
			}
		if($hotel_id=='')
		$hotel_id=0;	
		$hotel_class=' id="hotel_meeting_id"';	
		echo form_dropdown('hotel_meeting_id', $array_hotels,$hotel_id,$hotel_class);
		}
				
	public function delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('countries',array('id'=>$get['id']));
			$this->General->delete('cities',array('countryid'=>$get['id']));
			$this->General->delete('hotels',array('country_id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('countries');
		 } 
	}
	public function city_delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('cities',array('id'=>$get['id']));
			$this->General->delete('hotels',array('city_id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('countries/details/id/'.$get['country_id']);
		 } 
	}
	public function delete_checked_cities()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('countries/details/id/'.$this->input->post('country_id'));
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('cities',array('id'=>$d_id));
				$this->General->delete('hotels',array('city_id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('countries/details/id/'.$this->input->post('country_id'));
		}
	}
	public function delete_checked_countries()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('countries');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('countries',array('id'=>$d_id));
				$this->General->delete('cities',array('countryid'=>$d_id));
				$this->General->delete('hotels',array('country_id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('countries');
		}
	}		
	public function index()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),4,13,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),4,13,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),4,12,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;			
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Country->GetCountries();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('View Countries');
		$this->data['title'] = "Inma Kingdom Training System - Countries List";
		$this->template->load('_template', 'countries', $this->data);		
	}
	
	public function details()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),4,13,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),4,13,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),4,12,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;		
		$get = $this->uri->uri_to_assoc();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Countries','countries');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Country->GetCountryById($get['id']);
		$this->breadcrumb->add_crumb($this->data['query']['country']);
		$this->breadcrumb->add_crumb('Cities');			
		$this->data['cities']=$this->Country->GetCitiesByCountryId($get['id']);
		$this->data['title'] = "Inma Kingdom Training System - Country Details";
		$this->template->load('_template', 'country_details', $this->data);		
	}	
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Countries','countries');
			$this->breadcrumb->add_crumb('New Country');		
			$this->form_validation->set_rules('code', 'Country Code', 'trim');
			$this->form_validation->set_rules('country', 'Country Title in english', 'required');
			$this->form_validation->set_rules('country_ar', 'Country Title in arabic', 'required');
			$this->form_validation->set_rules('status', 'Status', 'trim');
			if ($this->form_validation->run()) {
				
				$array=$this->Administrator->do_upload();

				if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path='';
					}
	
				$msg=$array['error'];			
				$data = array(
				'code' => $this->form_validation->set_value('code'),
				'country' => $this->form_validation->set_value('country'),
				'country_ar' => $this->form_validation->set_value('country_ar'),
				'status' => $this->form_validation->set_value('status'),
				'flag' =>$path,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('countries',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Country Added successfully'));	
					redirect('countries/details/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('countries/create');					
				}
				
			 }
				$this->data['country_id'] = '';
				$this->data['code'] = '';
				$this->data['country'] = '';
				$this->data['country_ar'] = '';
				$this->data['status'] = '';
				$this->data['flag'] = '';
				$this->data['msg']=$this->session->userdata('admin_message');
				$this->session->unset_userdata('admin_message');					
				$this->data['subtitle'] = 'Add New Country';
				$this->data['title'] = "Inma Kingdom training system - Create New Country";
				$this->template->load('_template', 'country_form', $this->data);	
	}
	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Country->GetCountryById($get['id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Countries','countries');
			$this->breadcrumb->add_crumb($row['country']);
			$this->breadcrumb->add_crumb('Edit');				
			$this->form_validation->set_rules('code', 'Country Code', 'trim');
			$this->form_validation->set_rules('country', 'Country Title in english', 'required');
			$this->form_validation->set_rules('country_ar', 'Country Title in arabic', 'required');
			$this->form_validation->set_rules('status', 'Status', 'trim');

			if ($this->form_validation->run()) {
				
					$array=$this->Administrator->do_upload();
				 	if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path=$this->input->post('flag');
					}
				$data = array(
				'code' => $this->form_validation->set_value('code'),
				'country' => $this->form_validation->set_value('country'),
				'country_ar' => $this->form_validation->set_value('country_ar'),
				'status' => $this->form_validation->set_value('status'),
				'flag' =>$path,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				if($this->Administrator->edit('countries',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Country Updated successfully'));
					redirect('countries/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('countries/edit/id/'.$get['id']);					
				}
				
			 }
				$this->data['msg']=$this->session->userdata('admin_message');
				$this->session->unset_userdata('admin_message');			 	
				$this->data['country_id'] = $row['id'];
				$this->data['code'] = $row['code'];
				$this->data['country'] = $row['country'];
				$this->data['country_ar'] = $row['country_ar'];
				$this->data['status'] = $row['status'];
				$this->data['flag'] = $row['flag'];
				$this->data['subtitle'] = 'Edit Course';
				$this->data['title'] = "Inma Kingdom Training System - Edit Country";
				$this->template->load('_template', 'country_form', $this->data);	
	}
	
	public function create_cities()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Countries','countries');
			$this->breadcrumb->add_crumb('Create City');		
			$this->form_validation->set_rules('city', 'City Title in english', 'required');
			$this->form_validation->set_rules('city_ar', 'City Title in arabic', 'trim');
			$this->form_validation->set_rules('countryid', 'Country', 'trim');
			$this->form_validation->set_rules('status', 'Status', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'city' => $this->form_validation->set_value('city'),
				'city_ar' => $this->form_validation->set_value('city_ar'),
				'countryid' => $this->form_validation->set_value('countryid'),
				'status' => $this->form_validation->set_value('status'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('cities',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'City Added successfully'));	
					redirect('countries/details/id/'.$this->form_validation->set_value('countryid'));
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('countries/create_cities');					
				}
				
			 }
			 $get = $this->uri->uri_to_assoc();
			 if(isset($get['country'])){
				 $country_id=$get['country'];
				 }
				 else{
					 $country_id='';
					 }
				$this->data['city_id'] = '';
				$this->data['city'] = '';
				$this->data['city_ar'] = '';
				$this->data['countryid'] = $country_id;
				$this->data['status'] = '';
				$this->data['subtitle'] = 'Add New City';
				$this->data['countries']=$this->Country->GetCountries();
				$this->data['title'] = "Inma Kingdom training system - Create New City";
				$this->template->load('_template', 'cities_form', $this->data);	
	}	
	public function edit_city()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Country->GetCityId($get['id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Countries','countries');
			$this->breadcrumb->add_crumb($row['city']);
			$this->breadcrumb->add_crumb('Update');		
			$this->form_validation->set_rules('city', 'City Title in english', 'required');
			$this->form_validation->set_rules('city_ar', 'City Title in arabic', 'trim');
			$this->form_validation->set_rules('countryid', 'Country', 'trim');
			$this->form_validation->set_rules('status', 'Status', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'city' => $this->form_validation->set_value('city'),
				'city_ar' => $this->form_validation->set_value('city_ar'),
				'countryid' => $this->form_validation->set_value('countryid'),
				'status' => $this->form_validation->set_value('status'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

			if($this->Administrator->edit('cities',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Course Updated successfully'));
					redirect('countries/details/id/'.$this->form_validation->set_value('countryid'));
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('countries/edit_city/id/'.$get['id']);					
				}
				
			 }
				$this->data['city_id'] = $row['id'];
				$this->data['city'] = $row['city'];
				$this->data['city_ar'] = $row['city_ar'];
				$this->data['countryid'] = $row['countryid'];
				$this->data['status'] = $row['status'];
				$this->data['subtitle'] = 'Edit City';
				$this->data['countries']=$this->Country->GetCountries();
				$this->data['title'] = "Inma Kingdom training system - Edit City";
				$this->template->load('_template', 'cities_form', $this->data);	
	}										
											
}

?>