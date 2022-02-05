<?php
	class Invoice extends CI_Model{
		

	function GetNextInvoiceID()
	{
		$this->db->select_max('training_invoices.invoice_number');
		$this->db->from('training_invoices');
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function GetInvoiceByDate($year,$status)
	{
		$this->db->select('training_invoices.*');
		$this->db->from('training_invoices');	
		$this->db->where('training_invoices.status ',$status);		
		$this->db->where('training_invoices.create_time >=',$year.'-01-01');
		$this->db->where('training_invoices.create_time <=',$year.'-12-31');
		$this->db->order_by('training_invoices.id', 'DESC');
		return $this->db->get();		

	}
	
	function GetSumByDate($year,$status)
	{
		$this->db->select('SUM(training_invoices.total_net_amount) as subtotal');
		$this->db->from('training_invoices');	
		$this->db->where('training_invoices.status ',$status);		
		$this->db->where('training_invoices.create_time >=',$year.'-01-01');
		$this->db->where('training_invoices.create_time <=',$year.'-12-31');
		$this->db->order_by('training_invoices.id', 'DESC');
		$query=$this->db->get();		
		return $query->row_array();
	}		
	
	function GetNumberOfInvoiceByDate($year,$status)
	{
		$query=$this->GetInvoiceByDate($year,$status);
		return $query->num_rows();
	}
	function GetDataInvoiceByDate($year,$status)
	{
		$query=$this->GetInvoiceByDate($year,$status);
		return $query->result();
	}		
	
	function GetNumberOfInvoice($cat='',$status='')
	{
		$this->db->select('training_invoices.*');
		$this->db->from('training_invoices');
		if($status!='')
			$this->db->where('training_invoices.status',$status);
		if($cat!='')
			$this->db->where('training_invoices.category_id',$cat);
		$query = $this->db->get();
		return $query->num_rows();
	}
	function GetInvoices($cat='',$status='')
	{
		$this->db->select('training_invoices.*');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_invoices');
		$this->db->join('training_companies', 'training_companies.id = training_invoices.company_id', 'inner');
		if($status!='')
			$this->db->where('training_invoices.status',$status);
		if($cat!='')
			$this->db->where('training_invoices.category_id',$cat);
		$query = $this->db->get();
		return $query->result();
	}	
	function GetInvoiceById($id)
	{
		$this->db->select('training_invoices.*');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_invoices');
		$this->db->join('training_companies', 'training_companies.id = training_invoices.company_id', 'inner');
		$this->db->where('training_invoices.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
		
	function GetInvoiceByCompanyId($cid,$cat)
	{
		$this->db->select('training_invoices.*');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_invoices');
		$this->db->join('training_companies', 'training_companies.id = training_invoices.company_id', 'inner');
		$this->db->where('training_invoices.company_id',$cid);
		$this->db->where('training_invoices.category_id',$cat);
		$query = $this->db->get();
		return $query->result();
	}
		function GetInvoiceByCAS($cid,$sid)
	{
		$this->db->select('training_invoices.*');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_invoices');
		$this->db->join('training_companies', 'training_companies.id = training_invoices.company_id', 'inner');
		$this->db->where('training_invoices.company_id',$cid);
		$this->db->where('training_invoices.schedule_id',$sid);
		$query = $this->db->get();
		return $query->result();
	}
	function GetInvoiceByScheduleId($sid)
	{
		$this->db->select('training_invoices.*');
		$this->db->from('training_invoices');
		$this->db->where('training_invoices.schedule_id',$sid);
		$query = $this->db->get();
		return $query->result();
	}
	function GetClientByScheduleId($sid)
	{
		$this->db->select('training_registrations.*');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_registrations');
		$this->db->join('training_companies', 'training_companies.id = training_registrations.company_id', 'inner');
		$this->db->where('training_registrations.schedule_id',$sid);
		$query = $this->db->get();
		return $query->result();
	}					
	
	function GetScheduleByVisa($from='',$to='',$status)
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_schedule_instructors.visa as visa');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_schedule_instructors', 'training_schedule_instructors.schedule_id = training_schedules.id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		$this->db->where('training_schedule_instructors.visa',$status);
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		return $this->db->get();
	}

	function GetNumberOfScheduleByVisa($from='',$to='',$visa)
	{
		$query=$this->GetScheduleByVisa($from,$to,$visa);
		return $query->num_rows();
	}
	function GetDataScheduleByVisa($from='',$to='',$visa)
	{
		$query=$this->GetScheduleByVisa($from,$to,$visa);
		return $query->result();
	}
	
	
	function GetScheduleByCategory($from='',$to='',$status,$cat='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_categories.title as category');
		$this->db->select('cities.city as city');
		//$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		$this->db->where('training_schedules.status',$status);
		if($cat!='')
		$this->db->where('training_schedules.category_id',$cat);
		$this->db->order_by('training_schedules.category_id', 'ASC');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		return $this->db->get();
	}
	
	function GetNumberOfScheduleByCategory($from='',$to='',$visa,$cat)
	{
		$query=$this->GetScheduleByCategory($from,$to,$visa,$cat);
		return $query->num_rows();
	}
	function GetDataScheduleByCategory($from='',$to='',$visa,$cat='')
	{
		$query=$this->GetScheduleByCategory($from,$to,$visa,$cat='');
		return $query->result();
	}
		
	function GetCountScheduleByCompanies($from='',$to='',$status='',$cat='',$company_id='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_categories.title as category');
		$this->db->select('cities.city as city');
		$this->db->select('training_companies.name as company');
		$this->db->select('COUNT(training_schedules.id) as schedule_count');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_schedules.client_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		$this->db->where('training_schedules.status',$status);
		if($cat!='')
		$this->db->where('training_schedules.category_id',$cat);
		if($company_id!='')
		$this->db->where('training_schedules.client_id',$company_id);		
		$this->db->order_by('training_schedules.category_id', 'ASC');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$this->db->group_by('training_schedules.client_id');
		$query = $this->db->get();
		return $query->result();
	}
	function GetCountScheduleByHotels($from='',$to='',$status='',$cat='',$hotel_id='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_categories.title as category');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->select('COUNT(training_schedules.id) as schedule_count');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		$this->db->where('training_schedules.status',$status);
		if($cat!='')
		$this->db->where('training_schedules.category_id',$cat);
		if($hotel_id!='')
		$this->db->where('training_schedules.hotel_meeting_id',$hotel_id);		
		$this->db->order_by('training_schedules.category_id', 'ASC');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$this->db->group_by('training_schedules.hotel_meeting_id');
		$query = $this->db->get();
		return $query->result();
	}


	function GetCountScheduleByCourses($from='',$to='',$status='',$cat='',$course_id='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_categories.title as category');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->select('COUNT(training_schedules.id) as schedule_count');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		$this->db->where('training_schedules.status',$status);
		if($cat!='')
		$this->db->where('training_schedules.category_id',$cat);
		if($course_id!='')
		$this->db->where('training_schedules.course_id',$course_id);		
		$this->db->order_by('training_schedules.category_id', 'ASC');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		$this->db->group_by('training_schedules.course_id');
		$query = $this->db->get();
		return $query->result();
	}


	function GetScheduleByCompanies($from='',$to='',$status='',$cat='',$company_id='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_categories.title as category');
		$this->db->select('cities.city as city');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_schedules.client_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		if($status!='')
		$this->db->where('training_schedules.status',$status);
		else
		$this->db->where('training_schedules.status !=','canceled');
		if($cat!='')
		$this->db->where('training_schedules.category_id',$cat);
		if($company_id!='')
		$this->db->where('training_schedules.client_id',$company_id);		
		$this->db->order_by('training_schedules.category_id', 'ASC');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		return $this->db->get();
	}
	
	function GetNumberOfScheduleByCompany($from='',$to='',$status,$cat,$client)
	{
		$query=$this->GetScheduleByCompanies($from,$to,$status,$cat,$client);
		return $query->num_rows();
	}
	function GetDataScheduleByCompany($from='',$to='',$status,$cat='',$client)
	{
		$query=$this->GetScheduleByCompanies($from,$to,$status,$cat='',$client);
		return $query->result();
	}

	function GetScheduleByHotels($from='',$to='',$status='',$cat='',$hotel_id='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_categories.title as category');
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		if($status!='')
		$this->db->where('training_schedules.status',$status);
		else
		$this->db->where('training_schedules.status !=','canceled');
		if($cat!='')
		$this->db->where('training_schedules.category_id',$cat);
		if($hotel_id!='')
		$this->db->where('training_schedules.hotel_meeting_id',$hotel_id);		
		$this->db->order_by('training_schedules.category_id', 'ASC');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		return $this->db->get();
	}
	
	function GetNumberOfScheduleByHotel($from='',$to='',$status,$cat,$hotel)
	{
		$query=$this->GetScheduleByHotels($from,$to,$status,$cat,$hotel);
		return $query->num_rows();
	}
	function GetDataScheduleByHotel($from='',$to='',$status,$cat='',$hotel)
	{
		$query=$this->GetScheduleByHotels($from,$to,$status,$cat='',$hotel);
		return $query->result();
	}


	function GetScheduleByCourses($from='',$to='',$status='',$cat='',$course_id='')
	{
		$this->db->select('training_schedules.*');
		$this->db->select('training_courses.code as course_code');
		$this->db->select('training_courses.title as course');
		$this->db->select('countries.country as country');
		$this->db->select('training_categories.title as category');
		$this->db->select('cities.city as city');
		$this->db->select('training_companies.name as company');
		$this->db->from('training_schedules');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_schedules.client_id', 'inner');
		if($from!=''){		
			$this->db->where('training_schedules.start_date >=',$from);
		}
		if($to!=''){		
			$this->db->where('training_schedules.start_date <=',$to);
		}
		if($status!='')
		$this->db->where('training_schedules.status',$status);
		else
		$this->db->where('training_schedules.status !=','canceled');
		if($cat!='')
		$this->db->where('training_schedules.category_id',$cat);
		if($course_id!='')
		$this->db->where('training_schedules.course_id',$course_id);		
		$this->db->order_by('training_schedules.category_id', 'ASC');
		$this->db->order_by('training_schedules.start_date', 'ASC');
		$this->db->order_by('training_schedules.city_id', 'ASC');
		return $this->db->get();
	}
	
	function GetNumberOfScheduleByCourse($from='',$to='',$status,$cat,$course)
	{
		$query=$this->GetScheduleByCourses($from,$to,$status,$cat,$course);
		return $query->num_rows();
	}
	function GetDataScheduleByCourse($from='',$to='',$status,$cat='',$course)
	{
		$query=$this->GetScheduleByCourses($from,$to,$status,$cat='',$course);
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
		$this->db->where('training_schedules.status','pending');		
		$this->db->or_where('training_schedules.status','done'); 
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
		$this->db->select('cities.city as city');
		$this->db->select('hotels.name as hotel');
		$this->db->select('training_companies.name as client');
		$this->db->select('training_instructors.fullname as instructor');
		$this->db->select('training_providers.title as provider');
		$this->db->from('training_schedules');
		$this->db->join('training_categories', 'training_categories.id = training_schedules.category_id', 'inner');
		$this->db->join('training_courses', 'training_courses.id = training_schedules.course_id', 'inner');
		$this->db->join('countries', 'countries.id = training_schedules.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_schedules.city_id', 'inner');
		$this->db->join('hotels', 'hotels.id = training_schedules.hotel_meeting_id', 'inner');
		$this->db->join('training_companies', 'training_companies.id = training_schedules.client_id', 'inner');
		$this->db->join('training_instructors', 'training_instructors.id = training_schedules.instructor_id', 'inner');
		$this->db->join('training_providers', 'training_providers.id = training_schedules.provider_id', 'inner');
		$this->db->where('training_schedules.id',$id);
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
	function GetMajorId($id)
	{
		$this->db->select('training_majors.*');
		$this->db->from('training_majors');
		$this->db->where('training_majors.id =',$id);
		$query = $this->db->get();
		return $query->row_array();
	}				
}