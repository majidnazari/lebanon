<?php

class Schedules extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('schedules'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Schedule','Registration','Course','Country','Provider','Hotel','Client'));
						
	}
	public function delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_schedules',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('schedules');
		 } 
	}
	public function remove()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('training_schedule_instructors',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('schedules/details/id/'.$get['sid']);
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
	public function delete_checked_majors()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('courses/majors');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('training_majors',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('courses/majors');
		}
	}
	public function delete_checked_courses()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('courses');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('training_courses',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('courses');
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
			$cat_title=$categories['title'];
			$cat_link='/cat/'.$cat;
			}
		else{
			$cat='';
			$cat_title='All Schedules';
			$cat_link='';
			}
		if(isset($get['cat'])){	
		if($get['cat']==1){
			$r=2;
		}
		else{
			$r=3;
			}
		}
		else{
			if($this->ag_auth->check_privilege($this->session->userdata('privileges'),1,2,'view'))
			redirect('schedules/index/cat/1');
			elseif($this->ag_auth->check_privilege($this->session->userdata('privileges'),1,3,'view'))
			redirect('schedules/index/cat/2');
			else
			redirect('schedules/create');
			}
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,$r,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,$r,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,1,'add');
		$this->data['class_delete']=$p_delete;
		$this->data['class_edit']=$p_edit;
		$this->data['p_add']=$p_add;								
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Class Schedules');
		$this->breadcrumb->add_crumb(ucfirst($cat_title).' Class Schedules','schedules/index'.$cat_link);
		if(isset($get['status'])){
			$status=$get['status'];
			$status_t='( '.ucfirst($status).' )';
			$this->breadcrumb->add_crumb(ucfirst($cat_title).' Class Schedules - '.$status);
			}
		else{
			$status='';
			$status_t='';
			}
		$this->data['cat_link']=$cat;
		$this->data['pending_schedules']=$this->Schedule->GetNumberOfSchedule($cat,'pending');	
		$this->data['canceled_schedules']=$this->Schedule->GetNumberOfSchedule($cat,'canceled');	
		$this->data['done_schedules']=$this->Schedule->GetNumberOfSchedule($cat,'done');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Schedule->GetSchedules($cat,$status);	
		$this->data['subtitle'] = ucfirst($cat_title).' Class Schedules '.$status_t;
		$this->data['title'] = "Inma Kingdom Training System - Class Schedules List";
		$this->template->load('_template', 'schedule', $this->data);		
	}
	
	public function details()
	{
		$get = $this->uri->uri_to_assoc();	
		$row=$this->Schedule->GetScheduleId($get['id']);
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,$row['category_id'],'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,$row['category_id'],'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),1,1,'add');
		$p_invoice=$this->ag_auth->check_privilege($this->session->userdata('privileges'),12,24,'add');
		$p_register=$this->ag_auth->check_privilege($this->session->userdata('privileges'),9,24,'add');
		$this->data['class_delete']=$p_delete;
		$this->data['class_edit']=$p_edit;	
		$this->data['p_add']=$p_add;
		$this->data['class_edit']=$p_edit;	
		$this->data['p_invoice']=$p_invoice;
		$this->data['p_register']=$p_register;							
		//var_dump($row);
		$tools=$this->Schedule->GetScheduleInstructionDetails($get['id']);
		$registrations=$this->Registration->GetRegistrationsInfoBySchedule($get['id']);
	//	if(count($tools))
			$this->data['tools']=$tools;
			$this->data['registrations']=$registrations;
	///	else
	/*		$this->data['tools']=array('id'=>0,
										'hotel'=>'N/A',
										'eveluation'=>'N/A',
										'visa'=>'N/A',
										'ticket'=>'N/A',
										'fullname'=>'N/A',
										'instructor_phone'=>'N/A',
										'instructor_email'=>'N/A',
										'provider'=>'N/A',
										'provider_phone'=>'N/A',
										'provider_email'=>'N/A',
										'contact_person'=>'N/A',										
										);	
										*/
		$this->data['query']=$row;
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Class Schedule','schedules');
		$this->breadcrumb->add_crumb($row['course'].'('.$row['start_date'].' To '.$row['end_date'].') '.$row['country'].' - '.$row['city']);
		$this->breadcrumb->add_crumb('Details');		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['title'] = "Inma Kingdom Training System - Course Info";
		$this->template->load('_template', 'schedule_details', $this->data);		
	}	
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Class Schedule','schedules');
			$this->breadcrumb->add_crumb('Create Class Schedule');		
			$this->form_validation->set_rules('course_id', 'Course', 'trim');
			$this->form_validation->set_rules('category_id', 'Category', 'trim');
			$this->form_validation->set_rules('client_id', 'Client', 'trim');
			$this->form_validation->set_rules('no_of_participants', 'No.of Participants', 'trim');
			$this->form_validation->set_rules('start_date', 'start date', 'trim');
			$this->form_validation->set_rules('end_date', 'end date', 'trim');
			$this->form_validation->set_rules('country_id', 'country', 'trim');
			$this->form_validation->set_rules('city_id', 'city', 'trim');
		//	$this->form_validation->set_rules('provider_id', 'provider', 'trim');
		//	$this->form_validation->set_rules('instructor_id', 'instructor', 'trim');
			$this->form_validation->set_rules('staff_open', 'staff open', 'trim');
			$this->form_validation->set_rules('staff_close', 'staff close', 'trim');
			$this->form_validation->set_rules('hotel_meeting_id', 'hotel meeting', 'trim');
			$this->form_validation->set_rules('outline', 'outline', 'trim');
			$this->form_validation->set_rules('material_word', 'material word', 'trim');
			$this->form_validation->set_rules('material_pp', 'material pp', 'trim');
			$this->form_validation->set_rules('comment', 'Comment', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');
			if ($this->form_validation->run()) {
				if($this->form_validation->set_value('no_of_participants')==''){
					$nb_p=0;
				}
				else{
					$nb_p=$this->form_validation->set_value('no_of_participants');
					}
				$data = array(
				'course_id' => $this->form_validation->set_value('course_id'),
				'category_id' => $this->form_validation->set_value('category_id'),
				'client_id' => $this->form_validation->set_value('client_id'),
				'no_of_participants' => $nb_p,
				'start_date' => $this->form_validation->set_value('start_date'),
				'end_date' => $this->form_validation->set_value('end_date'),
				'country_id' => $this->form_validation->set_value('country_id'),
				'city_id' => $this->form_validation->set_value('city_id'),
				'staff_open' => $this->form_validation->set_value('staff_open'),
				'staff_close' => $this->form_validation->set_value('staff_close'),
				'hotel_meeting_id' => $this->form_validation->set_value('hotel_meeting_id'),
				'outline' => $this->form_validation->set_value('outline'),
				'material_word' => $this->form_validation->set_value('material_word'),
				'material_pp' => $this->form_validation->set_value('material_pp'),
				'comment' => $this->form_validation->set_value('comment'),
				'status' => $this->form_validation->set_value('status'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save('training_schedules',$data))
				{
					$data_ins=array('schedule_id'=>$id,'instructor_id'=>$this->form_validation->set_value('instructor_id'));
					//$this->General->save('training_schedule_instructors',$data_ins);
					$this->session->set_userdata(array('admin_message'=>'Course Schedule Added successfully'));	
					redirect('schedules/details/id/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('schedules/create');					
				}
				
			 }
				$this->data['schedule_id'] = '';
				$this->data['course_id'] = '';
				$this->data['category_id'] = '';
				$this->data['client_id'] = '';
				$this->data['no_of_participants'] = '';
				$this->data['start_date'] = '';
				$this->data['end_date'] = '';
				$this->data['country_id'] = '';
				$this->data['city_id'] = '';
				$this->data['staff_open'] = '';
				$this->data['staff_close'] = '';
				$this->data['hotel_meeting_id'] = '';
				$this->data['outline'] = '';
				$this->data['material_word'] = '';
				$this->data['material_pp'] = '';
				$this->data['comment'] = '';
				$this->data['status'] = '';
				$this->data['subtitle'] = 'Add Class Schedule';
				$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['courses']   =$this->Course->GetCourses();
				$this->data['cities_data']=array();
				$this->data['hotels_data']=array();
				$this->data['instructors_data']=array();				
				$this->data['countries']   =$this->Country->GetCountries();
//				$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['clients']   =$this->Client->GetAllClients();
				$this->data['title'] = "Inma Kingdom training system - Add Class Schedule";
				$this->template->load('_template', 'schedule_form', $this->data);	
	}
	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Schedule->GetScheduleId($get['id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Class Schedule','schedules');
			$this->breadcrumb->add_crumb($row['course'].'('.$row['start_date'].' To '.$row['end_date'].') '.$row['country'].' - '.$row['city'],'schedules/details/id/'.$get['id'] );
			$this->breadcrumb->add_crumb('Edit');		
			$this->form_validation->set_rules('course_id', 'Course', 'trim');
			$this->form_validation->set_rules('category_id', 'Category', 'trim');
			$this->form_validation->set_rules('client_id', 'Category', 'trim');
			$this->form_validation->set_rules('no_of_participants', 'No.of Participants', 'trim');
			$this->form_validation->set_rules('start_date', 'start date', 'trim');
			$this->form_validation->set_rules('end_date', 'end date', 'trim');
			$this->form_validation->set_rules('country_id', 'country', 'trim');
			$this->form_validation->set_rules('city_id', 'city', 'trim');
			$this->form_validation->set_rules('provider_id', 'provider', 'trim');
			$this->form_validation->set_rules('instructor_id', 'instructor', 'trim');
			$this->form_validation->set_rules('staff_open', 'staff open', 'trim');
			$this->form_validation->set_rules('staff_close', 'staff close', 'trim');
			$this->form_validation->set_rules('hotel_meeting_id', 'hotel meeting', 'trim');
			$this->form_validation->set_rules('outline', 'outline', 'trim');
			$this->form_validation->set_rules('material_word', 'material word', 'trim');
			$this->form_validation->set_rules('material_pp', 'material pp', 'trim');
			$this->form_validation->set_rules('comment', 'Comment', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');

			if ($this->form_validation->run()) {

				$data = array(
				'course_id' => $this->form_validation->set_value('course_id'),
				'category_id' => $this->form_validation->set_value('category_id'),
				'client_id' => $this->form_validation->set_value('client_id'),
				'no_of_participants' => $this->form_validation->set_value('no_of_participants'),
				'start_date' => $this->form_validation->set_value('start_date'),
				'end_date' => $this->form_validation->set_value('end_date'),
				'country_id' => $this->form_validation->set_value('country_id'),
				'city_id' => $this->form_validation->set_value('city_id'),
				'provider_id' => $this->form_validation->set_value('provider_id'),
				'instructor_id' => $this->form_validation->set_value('instructor_id'),
				'staff_open' => $this->form_validation->set_value('staff_open'),
				'staff_close' => $this->form_validation->set_value('staff_close'),
				'hotel_meeting_id' => $this->form_validation->set_value('hotel_meeting_id'),
				'outline' => $this->form_validation->set_value('outline'),
				'material_word' => $this->form_validation->set_value('material_word'),
				'material_pp' => $this->form_validation->set_value('material_pp'),
				'comment' => $this->form_validation->set_value('comment'),
				'status' => $this->form_validation->set_value('status'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				if($this->Administrator->edit('training_schedules',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Class Schedule Updated successfully'));
					redirect('schedules/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('schedules/edit/id/'.$get['id']);					
				}
				
			 }
				$this->data['schedule_id'] = $row['id'];
				$this->data['course_id'] = $row['course_id'];
				$this->data['category_id'] = $row['category_id'];
				$this->data['client_id'] = $row['client_id'];
				$this->data['no_of_participants'] = $row['no_of_participants'];
				$this->data['start_date'] = $row['start_date'];
				$this->data['end_date'] = $row['end_date'];
				$this->data['country_id'] = $row['country_id'];
				$this->data['city_id'] = $row['city_id'];
				$this->data['provider_id'] = $row['provider_id'];
				$this->data['instructor_id'] = $row['instructor_id'];
				$this->data['staff_open'] = $row['staff_open'];
				$this->data['staff_close'] = $row['staff_close'];
				$this->data['hotel_meeting_id'] = $row['hotel_meeting_id'];
				$this->data['outline'] = $row['outline'];
				$this->data['material_word'] = $row['material_word'];
				$this->data['material_pp'] = $row['material_pp'];
				$this->data['comment'] = $row['comment'];
				$this->data['status'] = $row['status'];
				$this->data['subtitle'] = 'Edit Class Schedule';
				$this->data['categories']   =$this->Schedule->GetCategories();
				$this->data['majors']   =$this->Course->GetAllMajors();
				$this->data['clients']   =$this->Client->GetAllClients();
				$this->data['courses']   =$this->Course->GetCourses();
				$this->data['countries']   =$this->Country->GetCountries();
				$this->data['cities_data']=$this->Country->GetCitiesByCountryId($row['country_id']);
				$this->data['hotels_data']=$this->Hotel->GetHotelsByCityId($row['city_id']);
				
				$this->data['providers']   =$this->Provider->GetProviders();
				$this->data['title'] = "Inma Kingdom Training System - Edit Class Schedule ";
				$this->template->load('_template', 'schedule_form', $this->data);	
	}
	
	public function tools()
	{
			$get = $this->uri->uri_to_assoc();
			//if(isset($get['id']))
			//$row=$this->Schedule->GetScheduleSettingsBySId($get['id']);
			
			$schedules=$this->Schedule->GetScheduleId($get['id']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Class Schedules','schedules');
			$this->breadcrumb->add_crumb($schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'],'schedules/details/id/'.$schedules['id']);
			$this->breadcrumb->add_crumb('Manage Instructor Tools');		
			$this->form_validation->set_rules('schedule_id', 'Class Schedule', 'required');
			$this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
			$this->form_validation->set_rules('provider_id', 'Provider', 'required');
			$this->form_validation->set_rules('hotel_meeting_id', 'hotel', 'trim');
			$this->form_validation->set_rules('eveluation', 'Eveluation', 'trim');
			$this->form_validation->set_rules('visa', 'visa', 'trim');
			$this->form_validation->set_rules('ticket', 'ticket', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'provider_id' => $this->form_validation->set_value('provider_id'),
				'instructor_id' => $this->form_validation->set_value('instructor_id'),
				'hotel_id' => $this->form_validation->set_value('hotel_meeting_id'),
				'eveluation' => $this->form_validation->set_value('eveluation'),
				'visa' => $this->form_validation->set_value('visa'),
				'ticket' => $this->form_validation->set_value('ticket'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

			if($this->Administrator->save('training_schedule_instructors',$data))
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
				
				$this->data['schedule_id'] = $schedules['id'];
				$this->data['class_schedule'] = $schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'];

				$this->data['t_id'] = '';
				$this->data['provider_id'] = 0;
				$this->data['instructor_id'] = 0;
				$this->data['hotel_id'] = 0;
				$this->data['eveluation'] = '';
				$this->data['visa'] = '';
				$this->data['ticket'] = '';		
				$this->data['instructors_data']=array();	
				$this->data['hotels_data']   =$this->Hotel->GetHotelsByCityId($schedules['city_id']);
				$this->data['providers']   =$this->Provider->GetProviders();			
				$this->data['subtitle'] = 'Class Schedule - Instructor Tools';
				$this->data['title'] = "Inma Kingdom training system -Class Schedule - Instructor Tools";
				$this->template->load('_template', 'schedule_tools', $this->data);	
	}	
	public function update() //Edite Instructor Tools
	{
			$get = $this->uri->uri_to_assoc();
			$row=$this->Schedule->GetScheduleSettingsBySId($get['id']);			
			$schedules=$this->Schedule->GetScheduleId($get['sid']);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Class Schedules','schedules');
			$this->breadcrumb->add_crumb($schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'],'schedules/details/id/'.$schedules['id']);
			$this->breadcrumb->add_crumb('Manage Instructor Tools');		
			$this->form_validation->set_rules('schedule_id', 'Class Schedule', 'required');
			$this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
			$this->form_validation->set_rules('provider_id', 'Provider', 'required');
			$this->form_validation->set_rules('hotel_meeting_id', 'hotel', 'trim');
			$this->form_validation->set_rules('eveluation', 'Eveluation', 'trim');
			$this->form_validation->set_rules('visa', 'visa', 'trim');
			$this->form_validation->set_rules('ticket', 'ticket', 'trim');
			if ($this->form_validation->run()) {
				
				$data = array(
				'schedule_id' => $this->form_validation->set_value('schedule_id'),
				'provider_id' => $this->form_validation->set_value('provider_id'),
				'instructor_id' => $this->form_validation->set_value('instructor_id'),
				'hotel_id' => $this->form_validation->set_value('hotel_meeting_id'),
				'eveluation' => $this->form_validation->set_value('eveluation'),
				'visa' => $this->form_validation->set_value('visa'),
				'ticket' => $this->form_validation->set_value('ticket'),
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
					redirect('schedules/update/id/'.$get['id'].'/sid/'.$get['sid']);					
				}
				
			 
				
			 }
				
				$this->data['schedule_id'] = $schedules['id'];
				$this->data['class_schedule'] = $schedules['course'].'('.$schedules['start_date'].' To '.$schedules['end_date'].') '.$schedules['country'].' - '.$schedules['city'];

				$this->data['t_id'] = $row['id'];
				$this->data['provider_id'] = $row['provider_id'];
				$this->data['instructor_id'] = $row['instructor_id'];
				$this->data['hotel_id'] = $row['hotel_id'];
				$this->data['eveluation'] =  $row['eveluation'];
				$this->data['visa'] =  $row['visa'];
				$this->data['ticket'] =  $row['ticket'];		
				$this->data['instructors_data']=$this->Provider->GetInstructorByProviderId($row['provider_id']);	
				$this->data['hotels_data']   =$this->Hotel->GetHotelsByCityId($schedules['city_id']);
				$this->data['providers']   =$this->Provider->GetProviders();			
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