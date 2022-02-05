<?php
	class Schedule extends CI_Model{
	
	function GetDashbordSchedule($fdate,$enddate)
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->where('training_schedules.start_date >=',$fdate);
		$this->db->where('training_schedules.start_date <=',$enddate);
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetNbrSchedulesPendingVisa($status='')
	{
		$this->db->select('training_schedule_instructors.*');
		$this->db->select('training_instructors.fullname as fullname');
		$this->db->from('training_schedule_instructors');
		$this->db->join('training_instructors', 'training_instructors.id = training_schedule_instructors.instructor_id', 'inner');
		if($status!=''){		
			$this->db->where('training_schedule_instructors.visa',$status);
		}
		$query = $this->db->get();
		return $query->result();
	}
		
	function GetNbrSchedules($cat='',$status='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($cat!=''){		
			$this->db->where('training_schedules.category_id',$cat);
		}
		if($status!=''){		
			$this->db->where('training_schedules.status',$status);
		}
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$query = $this->db->get();
		return $query->num_rows();
	}
	function GetSchedules($cat='',$status='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($cat!=''){		
			$this->db->where('training_schedules.category_id',$cat);
		}
		if($status!=''){		
			$this->db->where('training_schedules.status',$status);
		}
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetActiveSchedules($cat='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($cat!=''){		
			$this->db->where('training_schedules.category_id',$cat);
		}	
		$this->db->where('training_schedules.status !=','canceled');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetSchedulesByCompanyId($company_id)
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
	//	$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
//		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		$this->db->where('training_schedules.client_id',$company_id);
		$this->db->where('training_schedules.client_id !=',0);
		$this->db->where('training_schedules.status !=','canceled');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetSchedulesByCityId($city_id)
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
	//	$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
//		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		
		$this->db->where('training_schedules.status !=','canceled');		
		//$this->db->or_where('training_schedules.status','done'); 
		$this->db->where('training_schedules.city_id',$city_id);
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetScheduleId($id)
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_categories.title as category');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->select('cities.city as city');
		$this->db->select('cities.city_ar as city_ar');
		$this->db->select('hotels.name as hotel');
		$this->db->select('training_companies.name as client');
	//	$this->db->select('training_instructors.fullname as instructor');
	//	$this->db->select('training_providers.title as provider');
		$this->db->from('training_schedules');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_schedules.client_id', 'inner');
	//	$this->db->join('training_instructors', 'training_instructors.id = training_schedules.instructor_id', 'inner');
	//	$this->db->join('training_providers', 'training_providers.id = training_schedules.provider_id', 'inner');
		$this->db->where('training_schedules.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetScheduleSettingsBySId($id)
	{
		$this->db->select('training_schedule_instructors.*');
		$this->db->select('training_instructors.fullname as fullname');
		$this->db->select('training_instructors.phone as instructor_phone');
		$this->db->select('training_instructors.email as instructor_email');
		$this->db->select('training_providers.title as provider');
		$this->db->select('training_providers.phone as provider_phone');
		$this->db->select('training_providers.email as provider_email');
		$this->db->select('training_providers.contact_person as provider_contact_person');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedule_instructors');
		$this->db->join('hotels', 'hotels.id = training_schedule_instructors.hotel_id', 'inner');
		$this->db->join('training_instructors', 'training_instructors.id = training_schedule_instructors.instructor_id', 'inner');
		$this->db->join('training_providers', 'training_providers.id = training_schedule_instructors.provider_id', 'inner');
		$this->db->where('training_schedule_instructors.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetScheduleInstructionDetails($schedule_id)
	{
		$this->db->select('training_schedule_instructors.*');
		$this->db->select('training_instructors.fullname as fullname');
		$this->db->select('training_instructors.phone as instructor_phone');
		$this->db->select('training_instructors.email as instructor_email');
		$this->db->select('training_providers.title as provider');
		$this->db->select('training_providers.phone as provider_phone');
		$this->db->select('training_providers.email as provider_email');
		$this->db->select('training_providers.contact_person as provider_contact_person');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedule_instructors');
		$this->db->join('hotels', 'hotels.id = training_schedule_instructors.hotel_id', 'inner');
		$this->db->join('training_instructors', 'training_instructors.id = training_schedule_instructors.instructor_id', 'inner');
		$this->db->join('training_providers', 'training_providers.id = training_schedule_instructors.provider_id', 'inner');
		$this->db->where('training_schedule_instructors.schedule_id',$schedule_id);
		$query = $this->db->get();
		return $query->result();
	}
	function GetScheduleInstructionDetailsById($id)
	{
		$this->db->select('training_schedule_instructors.*');
		$this->db->from('training_schedule_instructors');
		$this->db->where('training_schedule_instructors.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}		
	function GetCategories()
	{
		$this->db->select('training_categories.*');
		$this->db->from('training_categories');
		$query = $this->db->get();
		return $query->result();
	}			
	function GetCategoryById($id)
	{
		$this->db->select('training_categories.*');
		$this->db->from('training_categories');
		$this->db->where('training_categories.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetNumberOfSchedule($cat='',$status='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($cat!=''){		
			$this->db->where('training_schedules.category_id',$cat);
		}
		if($status!=''){		
			$this->db->where('training_schedules.status',$status);
		}
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$query = $this->db->get();
		return $query->num_rows();
	}
	function GetMajorId($id)
	{
		$this->db->select('training_majors.*');
		$this->db->from('training_majors');
		$this->db->where('training_majors.id =',$id);
		$query = $this->db->get();
		return $query->row_array();
	}				
}