<?php

class Clients extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('clients'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Client','Country'));
						
	}
	public function delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_companies',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('clients');
		 } 
	}
	public function delete_checked()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('clients');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('training_companies',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('clients');
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
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),8,21,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),8,21,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),8,20,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Clients');
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Client->GetAllClients();
		$this->data['title'] = "Inma Kingdom training system - Clients List";
		$this->template->load('_template', 'clients', $this->data);		
	}
	public function details()
	{
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),8,21,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),8,21,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),8,20,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;			
		$get = $this->uri->uri_to_assoc();
		$this->data['query']=$this->Client->GetClientById($get['id']);
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Clients','clients');
		$this->breadcrumb->add_crumb($this->data['query']['name']);
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['title'] = "Inma Kingdom training system - Client Info";
		$this->template->load('_template', 'client_details', $this->data);		
	}	
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Clients','clients');
			$this->breadcrumb->add_crumb('Add Company');
			$this->form_validation->set_rules('name', 'Company Name', 'required');
			$this->form_validation->set_rules('name_ar', 'Company Name in arabic', 'required');
			$this->form_validation->set_rules('registration_number', 'Registration Number', 'trim');
			$this->form_validation->set_rules('country_id', 'country', 'trim');
			$this->form_validation->set_rules('city_id', 'city', 'trim');
			$this->form_validation->set_rules('address', 'Address', 'trim');
			$this->form_validation->set_rules('address_ar', 'Address in arabic', 'trim');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('fax', 'Fax', 'trim');
			$this->form_validation->set_rules('email', 'Email Address', 'min_length[6]|valid_email');
			$this->form_validation->set_rules('website', 'Website', 'trim');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim');		
			
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
				'name' => $this->form_validation->set_value('name'),
				'name_ar' => $this->form_validation->set_value('name_ar'),
				'registration_number' => $this->form_validation->set_value('registration_number'),
				'country_id' => $this->form_validation->set_value('country_id'),
				'city_id' => $this->form_validation->set_value('city_id'),
				'address' => $this->form_validation->set_value('address'),
				'address_ar' => $this->form_validation->set_value('address_ar'),
				'phone' => $this->form_validation->set_value('phone'),
				'fax' => $this->form_validation->set_value('fax'),
				'email' => $this->form_validation->set_value('email'),
				'website' => $this->form_validation->set_value('website'),
				'contact_person' => $this->form_validation->set_value('contact_person'),
				'logo' =>$path,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_companies',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Company Added successfully'));	
					redirect('clients/details/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('clients/create');					
				}
				
			 }
				$this->data['client_id'] = '';
				$this->data['name'] = '';
				$this->data['name_ar'] = '';
				$this->data['registration_number'] = '';
				$this->data['country_id'] = '';
				$this->data['city_id'] = '';
				$this->data['address'] = '';
				$this->data['address_ar'] = '';
				$this->data['phone'] = '';
				$this->data['fax'] = '';
				$this->data['email'] = '';
				$this->data['website'] = '';
				$this->data['contact_person'] = '';
				$this->data['logo'] = '';
				$this->data['countries']=$this->Country->GetCountries();
				$this->data['cities_data']=array();
				$this->data['subtitle'] = 'Add New Company';
				$this->data['title'] = "Inma Kingdom training system - Create New";
				$this->template->load('_template', 'client_form', $this->data);	
	}
	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Client->GetClientById($get['id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Clients','clients');
			$this->breadcrumb->add_crumb($row['name'],'clients/details/id/'.$row['id']);
			$this->breadcrumb->add_crumb('Edit Company');
			$this->form_validation->set_rules('name', 'Company Name', 'required');
			$this->form_validation->set_rules('name_ar', 'Company Name in arabic', 'required');
			$this->form_validation->set_rules('registration_number', 'Registration Number', 'trim');
			$this->form_validation->set_rules('country_id', 'country', 'trim');
			$this->form_validation->set_rules('city_id', 'city', 'trim');
			$this->form_validation->set_rules('address', 'Address', 'trim');
			$this->form_validation->set_rules('address_ar', 'Address in arabic', 'trim');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('fax', 'Fax', 'trim');
			$this->form_validation->set_rules('email', 'Email Address', 'min_length[6]|valid_email');
			$this->form_validation->set_rules('website', 'Website', 'trim');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim');

			if ($this->form_validation->run()) {
				
				$array=$this->Administrator->do_upload();

				 	if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path=$this->input->post('logo');
					}
	
				$msg=$array['error'];
				$data = array(
				'name' => $this->form_validation->set_value('name'),
				'name_ar' => $this->form_validation->set_value('name_ar'),
				'registration_number' => $this->form_validation->set_value('registration_number'),
				'country_id' => $this->form_validation->set_value('country_id'),
				'city_id' => $this->form_validation->set_value('city_id'),
				'address' => $this->form_validation->set_value('address'),
				'address_ar' => $this->form_validation->set_value('address_ar'),
				'phone' => $this->form_validation->set_value('phone'),
				'fax' => $this->form_validation->set_value('fax'),
				'email' => $this->form_validation->set_value('email'),
				'website' => $this->form_validation->set_value('website'),
				'contact_person' => $this->form_validation->set_value('contact_person'),
				'logo' =>$path,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				if($this->Administrator->edit('training_companies',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Company Updated successfully'));
					redirect('clients/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('clients/edit/id/'.$get['id']);					
				}
				
			 }
			 	
				$this->data['client_id'] = $row['id'];
				$this->data['name'] = $row['name'];
				$this->data['name_ar'] = $row['name_ar'];
				$this->data['registration_number'] = $row['registration_number'];
				$this->data['country_id'] = $row['country_id'];
				$this->data['city_id'] = $row['city_id'];
				$this->data['address'] = $row['address'];
				$this->data['address_ar'] = $row['address_ar'];
				$this->data['phone'] = $row['phone'];
				$this->data['fax'] = $row['fax'];
				$this->data['email'] = $row['email'];
				$this->data['website'] = $row['website'];
				$this->data['contact_person'] = $row['contact_person'];
				$this->data['logo'] = $row['logo'];
				$this->data['subtitle'] = 'Edit Company';
				$this->data['countries']=$this->Country->GetCountries();
				$this->data['cities_data']=$this->Country->GetCitiesByCountryId($row['country_id']);
				$this->data['title'] = "Inma Kingdom training system - Edit Client";
				$this->template->load('_template', 'client_form', $this->data);	
	}									
											
}

?>