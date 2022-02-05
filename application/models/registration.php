<?php
	class Registration extends CI_Model{
		
	function GetGenders()
	{
		$this->db->select('genders.*');
		$this->db->from('genders');
		$query = $this->db->get();
		return $query->result();
	}

	function GetAudiences()
	{
		$this->db->select('training_audiences.*');
		$this->db->from('training_audiences');
		$query = $this->db->get();
		return $query->result();
	}
	function GetExperiences()
	{
		$this->db->select('training_experiences.*');
		$this->db->from('training_experiences');
		$query = $this->db->get();
		return $query->result();
	}
	
	function GetPurposes()
	{
		$this->db->select('training_purposes.*');
		$this->db->from('training_purposes');
		$query = $this->db->get();
		return $query->result();
	}
	function GetRecalls()
	{
		$this->db->select('training_recalls.*');
		$this->db->from('training_recalls');
		$query = $this->db->get();
		return $query->result();
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
	function GetRegistrationsInfo($cat='',$status='')
	{
		$this->db->select('training_registrations.*');
		$this->db->select('training_categories.title as category');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_schedules.start_date as start_date');
		$this->db->select('training_schedules.end_date as end_date');
		$this->db->select('cities.city as city');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_registrations');
		$this->db->join('training_schedules', 'training_schedules.id = training_registrations.schedule_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_registrations.company_id', 'inner');
		if($status!='')
			$this->db->where('training_schedules.status',$status);
		if($cat!='')
			$this->db->where('training_schedules.category_id',$cat);
		$this->db->order_by('training_registrations.id', 'DESC');	
		$query = $this->db->get();
		return $query->result();
	}	
	function GetRegistrationsInfoBySchedule($schedule_id)
	{
		$this->db->select('training_registrations.*');
		$this->db->select('training_categories.title as category');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_schedules.start_date as start_date');
		$this->db->select('training_schedules.end_date as end_date');
		$this->db->select('cities.city as city');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_registrations');
		$this->db->join('training_schedules', 'training_schedules.id = training_registrations.schedule_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_registrations.company_id', 'inner');
		$this->db->where('training_registrations.schedule_id',$schedule_id);
		$query = $this->db->get();
		return $query->result();
	}	
	function GetRegistrationsInfoByCompany($company_id)
	{
		$this->db->select('training_registrations.*');
		$this->db->select('training_categories.title as category');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_schedules.start_date as start_date');
		$this->db->select('training_schedules.end_date as end_date');
		$this->db->select('cities.city as city');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_registrations');
		$this->db->join('training_schedules', 'training_schedules.id = training_registrations.schedule_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_registrations.company_id', 'inner');
		$this->db->where('training_registrations.company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
	}
	function GetRegistrationsInfoByCAS($company_id,$schedule_id)
	{
		$this->db->select('training_registrations.*');
		$this->db->select('training_categories.title as category');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_schedules.start_date as start_date');
		$this->db->select('training_schedules.end_date as end_date');
		$this->db->select('cities.city as city');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_registrations');
		$this->db->join('training_schedules', 'training_schedules.id = training_registrations.schedule_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_registrations.company_id', 'inner');
		$this->db->where('training_registrations.company_id',$company_id);
		$this->db->where('training_registrations.schedule_id',$schedule_id);
		$query = $this->db->get();
		return $query->result();
	}			

	function GetRegisterInfoById($id)
	{
		$this->db->select('training_registrations.*');
		$this->db->select('training_categories.title as category');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_schedules.start_date as start_date');
		$this->db->select('training_schedules.end_date as end_date');
		$this->db->select('cities.city as city');
		$this->db->from('training_registrations');
		$this->db->join('training_schedules', 'training_schedules.id = training_registrations.schedule_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		
		$this->db->where('training_registrations.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetScheduleInstructionDetails($schedule_id,$instructor_id)
	{
		$this->db->select('training_schedule_instructors.*');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedule_instructors');
		$this->db->join('hotels', 'hotels.id = training_schedule_instructors.hotel_id', 'inner');
		$this->db->where('training_schedule_instructors.schedule_id',$schedule_id);
		$this->db->where('training_schedule_instructors.instructor_id',$instructor_id);
		$query = $this->db->get();
		return $query->row_array();
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
	function GetNumberOfRegistration($cat='',$status='')
	{
		$this->db->select('training_registrations.*');
		$this->db->select('training_categories.title as category');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_schedules.start_date as start_date');
		$this->db->select('training_schedules.end_date as end_date');
		
		$this->db->select('cities.city as city');
		$this->db->from('training_registrations');
		$this->db->join('training_schedules', 'training_schedules.id = training_registrations.schedule_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		
		if($status!='')
			$this->db->where('training_schedules.status',$status);
		if($cat!='')
			$this->db->where('training_schedules.category_id',$cat);
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