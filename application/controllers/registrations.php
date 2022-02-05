<?php

class Registrations extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('registrations'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Schedule','Course','Country','Provider','Registration','Client'));
						
	}
	public function delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_registrations',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			if($get['sid'])
				redirect('schedules/details/id/'.$get['sid']);					
			else	
				redirect('registrations');
		 } 
	}
	public function major_delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_schedules',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('courses/majors');
		 } 
	}
	public function delete_checked()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('registrations');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('training_registrations',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('registrtions');
		}
	}

function RetrieveTextLanguage( $text )
 {
  $language = "0";

  if ($text != "")
  {
   if (preg_match("/\p{Arabic}/u", $text))
   {
    $language = "ar";
   }
   else
   {
    $language = "en";
   }
  }

  return $language;
 }
		
	public function index()
	{
	$get = $this->uri->uri_to_assoc();
	if(isset($get['cat'])){
			$cat=$get['cat'];
			$categories=$this->Schedule->GetCategoryById($cat);
			$cat_title=$categories['title'].' Class Schedules';
			$cat_link='/cat/'.$cat;
			}
		else{
			$cat='';
			$cat_title='All Class Schedules';
			$cat_link='';
			}
		if($cat==1){
		$r=22;
		$sc=2;
		}
		if($cat==2){
		$r=23;
		$sc=3;
		}
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),9,$r,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),9,$r,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),9,24,'add');
		$p_schedule=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,$sc,'view');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;
		$this->data['p_schedule']=$p_schedule;				
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb($cat_title);
		$this->breadcrumb->add_crumb('Registrations List');
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb(ucfirst($cat_title).' - '.$status);
			}
		else{
			$status='';
			$status_t='';
			}
		$this->data['cat_link']=$cat;
		$this->data['pending_schedules']=$this->Registration->GetNumberOfRegistration($cat,'pending');	
		$this->data['canceled_schedules']=$this->Registration->GetNumberOfRegistration($cat,'canceled');	
		$this->data['done_schedules']=$this->Registration->GetNumberOfRegistration($cat,'done');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Registration->GetRegistrationsInfo($cat,$status);	
		$this->data['subtitle'] = ucfirst($cat_title).' '.$status_t.' - Registration List';
		$this->data['title'] = "Inma Kingdom Training System - Registered Trainees List";
		$this->template->load('_template', 'registrations', $this->data);		
	}

	public function schedules()
	{
		$get = $this->uri->uri_to_assoc();
		$schedule=$this->Schedule->GetScheduleId($get['id']);
		$cat=$get['cat'];
		$categories=$this->Schedule->GetCategoryById($cat);	
		$cat_title=$schedule['course'].' ( '.$schedule['country'].' - '.$schedule['city'].' / '.date("d-m-Y", strtotime($schedule['start_date'])).' to '.date("d-m-Y", strtotime($schedule['end_date'])).' )';
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb($categories['title'].' Class Schedules','registrations/index/cat/'.$cat);
		$this->breadcrumb->add_crumb($schedule['course'].' ( '.$schedule['country'].' - '.$schedule['city'].' / '.date("d-m-Y", strtotime($schedule['start_date'])).' to '.date("d-m-Y", strtotime($schedule['end_date'])).' )');
		$this->breadcrumb->add_crumb('Registrations List');
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb(ucfirst($cat_title).' - '.$status);
			}
		else{
			$status='';
			$status_t='';
			}
		$this->data['cat_link']=$cat;
		$this->data['pending_schedules']=$this->Registration->GetNumberOfRegistration($cat,'pending');	
		$this->data['canceled_schedules']=$this->Registration->GetNumberOfRegistration($cat,'canceled');	
		$this->data['done_schedules']=$this->Registration->GetNumberOfRegistration($cat,'done');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Registration->GetRegistrationsInfoBySchedule($get['id']);	
		$this->data['subtitle'] = ucfirst($cat_title).' '.$status_t.' - Registration List';
		$this->data['title'] = "Inma Kingdom Training System - Registered Trainees List";
		$this->template->load('_template', 'registrations', $this->data);		
	}

	public function company()
	{
		$get = $this->uri->uri_to_assoc();
		$company=$this->Client->GetClientById($get['id']);
		$cat=$get['cat'];
		$categories=$this->Schedule->GetCategoryById($cat);	
		$cat_title=$company['name'];
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb($categories['title'].' Class Schedules','registrations/index/cat/'.$cat);
		$this->breadcrumb->add_crumb($cat_title);
		$this->breadcrumb->add_crumb('Registrations List');
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb(ucfirst($cat_title).' - '.$status);
			}
		else{
			$status='';
			$status_t='';
			}
		$this->data['cat_link']=$cat;
		$this->data['pending_schedules']=$this->Registration->GetNumberOfRegistration($cat,'pending');	
		$this->data['canceled_schedules']=$this->Registration->GetNumberOfRegistration($cat,'canceled');	
		$this->data['done_schedules']=$this->Registration->GetNumberOfRegistration($cat,'done');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Registration->GetRegistrationsInfoByCompany($get['id']);	
		$this->data['subtitle'] = ucfirst($cat_title).' '.$status_t.' - Registration List';
		$this->data['title'] = "Inma Kingdom Training System - Registered Trainees List";
		$this->template->load('_template', 'registrations', $this->data);		
	}
	
	public function details()
	{
		
		$get = $this->uri->uri_to_assoc();
		$row=$this->Registration->GetRegisterInfoById($get['id']);
		$s=$this->Schedule->GetScheduleId($row['schedule_id']);
		$this->data['clients']=$this->Client->GetClientById($row['company_id']);
		$this->data['query']=$row;
		$r=0;
		if($s['category_id']==1){
		$r=22;
		$sc=2;
		}
		if($s['category_id']==2){
		$r=23;
		$sc=3;
		}
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),9,$r,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),9,$r,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),9,24,'add');
		$p_schedule=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,$sc,'view');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;
		$this->data['p_schedule']=$p_schedule;
		$this->data['genders']   =$this->Registration->GetGenders();
		$this->data['audiences']   =$this->Registration->GetAudiences();
		$this->data['experiences']   =$this->Registration->GetExperiences();
		$this->data['purposes']   =$this->Registration->GetPurposes();
		$this->data['recalls']   =$this->Registration->GetRecalls();		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Registrations','registrations');
		$this->breadcrumb->add_crumb('Registration info : '.$row['first_name'].' '.$row['last_name']);
		$this->breadcrumb->add_crumb('Details');		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');
		$this->data['subtitle'] = "Personal Information Form";		
		$this->data['title'] = "Inma Kingdom Training System - Course Info";
		$this->template->load('_template', 'registration_quick_details', $this->data);		
	}
	
	public function view()
	{
		$get = $this->uri->uri_to_assoc();
		$row=$this->Registration->GetRegisterInfoById($get['id']);
		$this->data['clients']=$this->Client->GetClientById($row['company_id']);
		$this->data['query']=$row;
		$this->data['genders']   =$this->Registration->GetGenders();
		$this->data['audiences']   =$this->Registration->GetAudiences();
		$this->data['experiences']   =$this->Registration->GetExperiences();
		$this->data['purposes']   =$this->Registration->GetPurposes();
		$this->data['recalls']   =$this->Registration->GetRecalls();		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Registrations','registrations');
		$this->breadcrumb->add_crumb('Registration info : '.$row['first_name'].' '.$row['last_name']);
		$this->breadcrumb->add_crumb('Details');		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');
		$this->data['subtitle'] = "Personal Information Form";		
		$this->data['title'] = "Inma Kingdom Training System - Course Info";
		$this->load->view('registration_view', $this->data);		
	}	
	public function GetSchedules()
	{
		$biding_id	= $_POST['id'];
		$schedule_id	= $_POST['schedule_id'];
		$client_id	= $_POST['client_id'];
		$schedules=$this->Schedule->GetSchedules($biding_id,'pending');
		$array_schedules['']='Select Class Schedule';
		foreach($schedules as $schedule)
			{
				$array_schedules[$schedule->id]=$schedule->course.'('.$schedule->start_date.' To '.$schedule->end_date.' / '.$schedule->city.')';
			}
		if($client_id=='')
		$client_id=0;	
		$city_class=' id="city_id"  class="validate[required]" onchange="getclients(this.value,'.$client_id.')"';	
		echo form_dropdown('schedule_id', $array_schedules,$schedule_id,$city_class);
		}
	
	
	public function GetClients()
	{
		$schedule_id	= $_POST['id'];
		$client_id	= $_POST['client_id'];
		$schedules=$this->Schedule->GetScheduleId($schedule_id);
		if($schedules['client_id']==0){
		$clients=$this->Client->GetAllClients($schedule_id);
		$array_clients['']='Select Client';
		$array_clients[0]='Private';
		foreach($clients as $client)
			{
				if($client->id!=0)
				$array_clients[$client->id]=$client->name;
			}		
		}
		else{
			$clients=$this->Client->GetClientById($schedules['client_id']);
			$array_clients[$clients['id']]=$clients['name'];
			}

		if($client_id=='')
		$client_id=0;		
		echo form_dropdown('company_id', $array_clients,$client_id);
		}				
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Registrations','registrations');
			$this->breadcrumb->add_crumb('Register New Trainee');		
			$this->form_validation->set_rules('code', 'code', 'trim');
			$this->form_validation->set_rules('s_code', 's_code', 'trim');
			$this->form_validation->set_rules('first_name', 'first_name', 'trim');
			$this->form_validation->set_rules('second_name', 'second_name', 'trim');
			$this->form_validation->set_rules('last_name', 'last_name', 'trim');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim');
			$this->form_validation->set_rules('country', 'country', 'trim');
			$this->form_validation->set_rules('city', 'city', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('pobox', 'pobox', 'trim');
			$this->form_validation->set_rules('phone', 'phone', 'trim');
			$this->form_validation->set_rules('fax', 'fax', 'trim');
			$this->form_validation->set_rules('mobile', 'mobile', 'trim');
			$this->form_validation->set_rules('email', 'email', 'trim');
			$this->form_validation->set_rules('job_title', 'job_title', 'trim');
			$this->form_validation->set_rules('business_type', 'business_type', 'trim');
			$this->form_validation->set_rules('audience', 'audience', 'trim');
			$this->form_validation->set_rules('experience', 'experience', 'trim');
			$this->form_validation->set_rules('birthdate', 'birthdate', 'trim');
			$this->form_validation->set_rules('training_recalls', 'training_recalls', 'trim');
			$this->form_validation->set_rules('others', 'others', 'trim');
			$this->form_validation->set_rules('sex', 'sex', 'trim');
			$this->form_validation->set_rules('schedule_id', 'schedule_id', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');
			if ($this->form_validation->run()) {
						
						
			$purpose_array=$this->input->post('purpose_training');
			$purpose=implode('-',$purpose_array);
				$data = array(
				'code' => $this->form_validation->set_value('code'),
				's_code' => $this->form_validation->set_value('s_code'),
				'first_name' => $this->form_validation->set_value('first_name'),
				'second_name' => $this->form_validation->set_value('second_name'),
				'last_name' => $this->form_validation->set_value('last_name'),
				'fullname' => $this->form_validation->set_value('fullname'),
				'country' => $this->form_validation->set_value('country'),
				'city' => $this->form_validation->set_value('city'),
				'address' => $this->form_validation->set_value('address'),
				'pobox' => $this->form_validation->set_value('pobox'),
				'phone' => $this->form_validation->set_value('phone'),
				'fax' => $this->form_validation->set_value('fax'),
				'mobile' => $this->form_validation->set_value('mobile'),
				'email' => $this->form_validation->set_value('email'),
				'job_title' => $this->form_validation->set_value('job_title'),
				'business_type' => $this->form_validation->set_value('business_type'),
				'audience' => $this->form_validation->set_value('audience'),
				'experience' => $this->form_validation->set_value('experience'),
				'birthdate' => $this->form_validation->set_value('birthdate'),
				'training_recalls' => $this->form_validation->set_value('training_recalls'),
				'purpose_training' => $purpose,
				'others' => $this->form_validation->set_value('others'),
				'sex' => $this->form_validation->set_value('sex'),
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'company_id' => $this->form_validation->set_value('company_id'),
				'status' => $this->form_validation->set_value('status'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_registrations',$data))
				{
					if($this->input->post('category_id')==2){
						$this->db->set('no_of_participants', 'no_of_participants+1', FALSE);
						$this->db->where('id', $this->form_validation->set_value('schedule_id'));
						$this->db->update('training_schedules');
					}
					$this->session->set_userdata(array('admin_message'=>'Trainee Registerd Successfully'));	
					redirect('registrations/details/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('registrations/create');					
				}
				
			 }
				$this->data['registration_id'] = '';
				$this->data['code'] = '';
				$this->data['s_code'] = '';
				$this->data['first_name'] = '';
				$this->data['second_name'] = '';
				$this->data['last_name'] = '';
				$this->data['fullname'] = '';
				$this->data['country'] = '';
				$this->data['city'] = '';
				$this->data['address'] = '';
				$this->data['pobox'] = '';
				$this->data['phone'] = '';
				$this->data['fax'] = '';
				$this->data['mobile'] = '';
				$this->data['email'] = '';
				$this->data['job_title'] = '';
				$this->data['business_type'] = '';
				$this->data['audience'] = '';
				$this->data['experience'] = '';
				$this->data['birthdate'] = '';
				$this->data['training_recalls'] = '';
				$this->data['purpose_training'] = '';
				$this->data['others'] = '';
				$this->data['sex'] = '';
				$this->data['schedule_id'] = 0;
				$this->data['company_id'] = 0;
				$this->data['status'] = '';
				$this->data['category_id']=0;
				$this->data['subtitle'] = 'Register New Trainee';
				$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
				$this->data['schedules']=array();
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['clients']   =$this->Client->GetAllClients();
				$this->data['genders']   =$this->Registration->GetGenders();
				$this->data['audiences']   =$this->Registration->GetAudiences();
				$this->data['experiences']   =$this->Registration->GetExperiences();
				$this->data['purposes']   =$this->Registration->GetPurposes();
				$this->data['recalls']   =$this->Registration->GetRecalls();
				$this->data['title'] = "Inma Kingdom training system - Register New Trainee";
				$this->template->load('_template', 'registartion_form', $this->data);	
	}
	public function add()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Registrations','registrations');
			$this->breadcrumb->add_crumb('Quick Registration');		
			//$this->form_validation->set_rules('code', 'code', 'trim');
		//	$this->form_validation->set_rules('s_code', 's_code', 'trim');
		//	$this->form_validation->set_rules('fullname', 'fullname', 'trim');
		//	$this->form_validation->set_rules('pif', 'pif', 'trim');
			$this->form_validation->set_rules('schedule_id', 'schedule_id', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
		//	$this->form_validation->set_rules('status', 'status', 'trim');
			if ($this->form_validation->run()) {
				$fullnames=$this->input->post('fullname');
				$s_code=$this->input->post('s_code');
				$code=$this->input->post('code');
				$status=$this->input->post('status');
				//$status=$this->input->post('status');
				for($i=0;$i<count($fullnames);$i++){
	
					
				//	$array=$this->Administrator->do_upload_pif($userfile[$i]);

			//	 	if($array['target_path']!=""){
			//		$path=$array['target_path'];
			//	}
			//	else{
			//		$path='';
			//		}		
				$path='';	
				$data = array(
				'code' => $code[$i],
				's_code' => $s_code[$i],
				'fullname' => $fullnames[$i],
				'pif' => $path,
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'company_id' => $this->form_validation->set_value('company_id'),
				'status' => $status[$i],
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_registrations',$data))
				{
					if($this->input->post('category_id')==2){
						$this->db->set('no_of_participants', 'no_of_participants+1', FALSE);
						$this->db->where('id', $this->form_validation->set_value('schedule_id'));
						$this->db->update('training_schedules');
					}
					
					}	
				}

				$this->session->set_userdata(array('admin_message'=>'Trainee Registerd Successfully'));	
				redirect('registrations/index/cat/'.$this->input->post('category_id'));
			 }
				$this->data['registration_id'] = '';
				$this->data['code'] = '';
				$this->data['s_code'] = '';
				$this->data['fullname'] = '';
				$this->data['pif'] = '';
				$this->data['schedule_id'] = 0;
				$this->data['company_id'] = 0;
				$this->data['status'] = '';
				$this->data['category_id']=0;
				$this->data['subtitle'] = 'Register New Trainee';
				$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
				$this->data['clients']   =$this->Client->GetAllClients();
				$this->data['schedules']=array();
				$this->data['title'] = "Inma Kingdom training system - Register New Trainee";
				$this->template->load('_template', 'registartion_add_quick', $this->data);	
	}

	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Registration->GetRegisterInfoById($get['id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Registrations','registrations');
			$this->breadcrumb->add_crumb('Registration info : '.$row['first_name'].' '.$row['last_name']);
			$this->breadcrumb->add_crumb('Edit');		
			$this->form_validation->set_rules('code', 'code', 'trim');
			$this->form_validation->set_rules('s_code', 's_code', 'trim');
			$this->form_validation->set_rules('first_name', 'first_name', 'trim');
			$this->form_validation->set_rules('second_name', 'second_name', 'trim');
			$this->form_validation->set_rules('last_name', 'last_name', 'trim');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim');
			$this->form_validation->set_rules('country', 'country', 'trim');
			$this->form_validation->set_rules('city', 'city', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('pobox', 'pobox', 'trim');
			$this->form_validation->set_rules('phone', 'phone', 'trim');
			$this->form_validation->set_rules('fax', 'fax', 'trim');
			$this->form_validation->set_rules('mobile', 'mobile', 'trim');
			$this->form_validation->set_rules('email', 'email', 'trim');
			$this->form_validation->set_rules('job_title', 'job_title', 'trim');
			$this->form_validation->set_rules('business_type', 'business_type', 'trim');
			$this->form_validation->set_rules('audience', 'audience', 'trim');
			$this->form_validation->set_rules('experience', 'experience', 'trim');
			$this->form_validation->set_rules('birthdate', 'birthdate', 'trim');
			$this->form_validation->set_rules('training_recalls', 'training_recalls', 'trim');
			$this->form_validation->set_rules('others', 'others', 'trim');
			$this->form_validation->set_rules('sex', 'sex', 'trim');
			$this->form_validation->set_rules('schedule_id', 'schedule_id', 'trim');
			$this->form_validation->set_rules('company_id', 'company_id', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');

			if ($this->form_validation->run()) {

				$data = array(
				'code' => $this->form_validation->set_value('code'),
				's_code' => $this->form_validation->set_value('s_code'),
				'first_name' => $this->form_validation->set_value('first_name'),
				'second_name' => $this->form_validation->set_value('second_name'),
				'last_name' => $this->form_validation->set_value('last_name'),
				'fullname' => $this->form_validation->set_value('fullname'),
				'country' => $this->form_validation->set_value('country'),
				'city' => $this->form_validation->set_value('city'),
				'address' => $this->form_validation->set_value('address'),
				'pobox' => $this->form_validation->set_value('pobox'),
				'phone' => $this->form_validation->set_value('phone'),
				'fax' => $this->form_validation->set_value('fax'),
				'mobile' => $this->form_validation->set_value('mobile'),
				'email' => $this->form_validation->set_value('email'),
				'job_title' => $this->form_validation->set_value('job_title'),
				'business_type' => $this->form_validation->set_value('business_type'),
				'audience' => $this->form_validation->set_value('audience'),
				'experience' => $this->form_validation->set_value('experience'),
				'birthdate' => $this->form_validation->set_value('birthdate'),
				'training_recalls' => $this->form_validation->set_value('training_recalls'),
				'purpose_training' => $purpose,
				'others' => $this->form_validation->set_value('others'),
				'sex' => $this->form_validation->set_value('sex'),
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'company_id' => $this->form_validation->set_value('company_id'),
				'status' => $this->form_validation->set_value('status'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				if($this->Administrator->edit('training_registrations',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Class Schedule Updated successfully'));
					if($get['sid'])
						redirect('schedules/details/id/'.$get['sid']);					
					else	
						redirect('registrations/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('registrations/edit/id/'.$get['id']);					
				}
				
			 }
				$this->data['registration_id'] = $row['id'];
				$this->data['code'] = $row['code'];
				$this->data['s_code'] = $row['s_code'];
				$this->data['first_name'] = $row['first_name'];
				$this->data['second_name'] = $row['second_name'];
				$this->data['last_name'] = $row['last_name'];
				$this->data['fullname'] = $row['fullname'];
				$this->data['country'] = $row['country'];
				$this->data['city'] = $row['city'];
				$this->data['address'] = $row['address'];
				$this->data['pobox'] = $row['pobox'];
				$this->data['phone'] = $row['phone'];
				$this->data['fax'] = $row['fax'];
				$this->data['mobile'] = $row['mobile'];
				$this->data['email'] = $row['email'];
				$this->data['job_title'] = $row['job_title'];
				$this->data['business_type'] = $row['business_type'];
				$this->data['audience'] = $row['audience'];
				$this->data['experience'] = $row['experience'];
				$this->data['birthdate'] = $row['birthdate'];
				$this->data['training_recalls'] = $row['training_recalls'];
				$this->data['purpose_training'] = $row['purpose_training'];
				$this->data['others'] = $row['others'];
				$this->data['sex'] = $row['sex'];
				$this->data['schedule_id'] = $row['schedule_id'];
				$this->data['company_id'] = $row['company_id'];
				$this->data['status'] = $row['status'];
				$this->data['subtitle'] = 'Register New Trainee';
				$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
				$schedules=$this->Schedule->GetScheduleId($row['schedule_id']);
				$this->data['category_id']=$schedules['category_id'];
				$this->data['schedules']=$this->Schedule->GetSchedules($schedules['category_id'],'pending');
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['clients']   =$this->Client->GetAllClients();
				$this->data['genders']   =$this->Registration->GetGenders();
				$this->data['audiences']   =$this->Registration->GetAudiences();
				$this->data['experiences']   =$this->Registration->GetExperiences();
				$this->data['purposes']   =$this->Registration->GetPurposes();
				$this->data['recalls']   =$this->Registration->GetRecalls();
				$this->data['title'] = "Inma Kingdom training system - Register New Trainee";
				$this->template->load('_template', 'registartion_form', $this->data);	
	}
	
	public function tools()
	{
			$get = $this->uri->uri_to_assoc();
			if(isset($get['id']))
			$row=$this->Schedule->GetScheduleInstructionDetailsById($get['id']);
			$schedules=$this->Schedule->GetScheduleId($row['schedule_id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Class Schedules','schedules');
			$this->breadcrumb->add_crumb($schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'],'schedules/details/id/'.$schedules['id']);
			$this->breadcrumb->add_crumb('Manage Instructor Tools');		
			$this->form_validation->set_rules('schedule_id', 'Class Schedule', 'required');
			$this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
			$this->form_validation->set_rules('hotel_meeting_id', 'hotel', 'trim');
			$this->form_validation->set_rules('eveluation', 'Eveluation', 'trim');
			$this->form_validation->set_rules('visa', 'visa', 'trim');
			$this->form_validation->set_rules('ticket', 'ticket', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'instructor_id' => $this->form_validation->set_value('instructor_id'),
				'hotel_id' => $this->form_validation->set_value('hotel_meeting_id'),
				'eveluation' => $this->form_validation->set_value('eveluation'),
				'visa' => $this->form_validation->set_value('visa'),
				'ticket' => $this->form_validation->set_value('ticket'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

			if($this->Administrator->edit('training_schedule_instructors',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Instructor Tools Updated successfully'));
					redirect('schedules/details/id/'.$this->form_validation->set_value('schedule_id'));
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('schedules/tools/id/'.$get['id']);					
				}
				
			 
				
			 }
				$this->data['t_id'] = $row['id'];
				$this->data['schedule_id'] = $row['schedule_id'];
				$this->data['class_schedule'] = $schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'];
				$this->data['instructor'] = $schedules['instructor'];
				$this->data['provider'] = $schedules['provider'];
				$this->data['instructor_id'] = $row['instructor_id'];
				$this->data['hotel_id'] = $row['hotel_id'];
				$this->data['eveluation'] = $row['eveluation'];
				$this->data['visa'] = $row['visa'];
				$this->data['ticket'] = $row['ticket'];
								
				$locations=$this->Hotel->GetHotelById($row['hotel_id']);	
				$this->data['country_id'] = $locations['country_id'];
				$this->data['city_id'] = $locations['city_id'];
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['cities_data']=$this->Country->GetCitiesByCountryId($locations['country_id']);
				$this->data['hotels_data']=$this->Hotel->GetHotelsByCityId($locations['city_id']);				
				$this->data['subtitle'] = 'Class Schedule - Instructor Tools';
				$this->data['title'] = "Inma Kingdom training system -Class Schedule - Instructor Tools";
				$this->template->load('_template', 'schedule_tools', $this->data);	
	}	
	public function edit_major()
	{
			$get = $this->uri->uri_to_assoc();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Courses','courses');
			$this->breadcrumb->add_crumb('Majors','courses/majors');
			$this->breadcrumb->add_crumb('Edit Major');		
			$this->form_validation->set_rules('major_title', 'Course Title', 'required');
			if ($this->form_validation->run()) {
				
				$data = array(
				'title' => $this->form_validation->set_value('major_title'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

			if($this->Administrator->edit('training_majors',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Course Updated successfully'));
					redirect('courses/majors');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('courses/edit_major/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Course->GetMajorId($get['id']);
				$this->data['major_id'] = $row['id'];
				$this->data['major_title'] = $row['title'];
				$this->data['subtitle'] = 'Edit Major';
				$this->data['title'] = "Inma Kingdom training system - Edit Major";
				$this->template->load('_template', 'major_form', $this->data);	
	}										
											
}

?>