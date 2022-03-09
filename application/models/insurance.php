<?php
	class Insurance extends CI_Model{

        function GetAreaByDistrict($status='',$did,$lang='ar')
        {
            $this->db->select('tbl_area.*');
            $this->db->select('COUNT(tbl_insurances.id) as total');
            $this->db->from('tbl_area');
            $this->db->join('tbl_insurances', 'tbl_insurances.area_id = tbl_area.id', 'left');
            if($status!='')
                $this->db->where('tbl_area.status',$status);
            if($did!='' and $did!=0)
                $this->db->where('tbl_area.district_id',$did);
            $this->db->group_by('tbl_insurances.area_id');
            if($lang=='en')
                $this->db->order_by('tbl_area.label_en', 'ASC');
            else
                $this->db->order_by('tbl_area.label_ar', 'ASC');
            $query = $this->db->get();
            return $query->result();
        }
		
function GetInsurancesS($copy_res='',$is_adv='',$row,$limit)
	{
		$this->db->select('tbl_insurances.*');
		//$this->db->select('tbl_company_type.label_en as type_en');
		//$this->db->select('tbl_company_type.label_ar as type_ar');
		$this->db->from('tbl_insurances');
		//$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
		if($copy_res!='')
		$this->db->where('tbl_insurances.copy_res',$copy_res);
		if($is_adv!='')
		$this->db->where('tbl_insurances.is_adv',$is_adv);
		$this->db->order_by('tbl_insurances.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}		
	function GetActivityById($id)
	{
		$this->db->select('tbl_insurance_activities.*');
		$this->db->from('tbl_insurance_activities');
		$this->db->where('tbl_insurance_activities.id',$id);
		$this->db->order_by('tbl_insurance_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->row_array();
	}			
function GetInsuranceActivities($status='')
	{
		$this->db->select('tbl_insurance_activities.*');
		$this->db->from('tbl_insurance_activities');
		if($status!='')
		$this->db->where('tbl_insurance_activities.status',$status);
		$this->db->order_by('tbl_insurance_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetActivitiesByIds($ids=array())
	{
		$this->db->select('tbl_insurance_activities.*');
		$this->db->from('tbl_insurance_activities');
		$this->db->where_in('tbl_insurance_activities.id',$ids);
		$this->db->order_by('tbl_insurance_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
		
function GetInsurances($status='',$row,$limit)
	{
		$this->db->select('tbl_insurances.*');
		$this->db->from('tbl_insurances');
		if($status!='')
		$this->db->where('tbl_insurances.status',$status);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('tbl_insurances.id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
function GetOthersInsurance()
	{
		$this->db->select('tbl_insurances.*');
		$this->db->from('tbl_insurances');
		
		$this->db->where('tbl_insurances.activity_other_ar !=','');
		$this->db->or_where('tbl_insurances.activity_other_en !=','');
		
	
		$this->db->order_by('tbl_insurances.name_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetInsuranceById($id)
	{
		$this->db->select('tbl_insurances.*');
		$this->db->from('tbl_insurances');	
		$this->db->where('tbl_insurances.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function SearchInsurances($id,$name,$phone,$whatsapp,$status='',$gov,$district,$area,$row,$limit)
	{
		$this->db->select('tbl_insurances.*');
		$this->db->from('tbl_insurances');
		if($id!='')
		{
		$this->db->where('tbl_insurances.id',$id);	
		}
		if($name!=''){
		$where1 = "( tbl_insurances.name_ar LIKE '%$name%' OR tbl_insurances.name_en LIKE '%$name%')";
		//$this->db->like('tbl_company.name_ar',$name);
		//$this->db->or_like('tbl_company.name_en',$name);
		$this->db->where($where1);
		}
		
		if($phone!='')
		{
		$this->db->like('tbl_insurances.phone',$phone);
		}
		if($whatsapp!='')
		{
		$this->db->like('tbl_insurances.whatsapp',$whatsapp);
		}
		if($gov!='' and $gov!='0')
		$this->db->where('tbl_insurances.governorate_id',$gov);
		if($district!='' and $district!='0')
		$this->db->where('tbl_insurances.district_id',$district);
        if($area!='' and $area!='0')
            $this->db->where('tbl_insurances.area_id',$area);
		if($status!='all')
		$this->db->where('tbl_insurances.status',$status);
		$this->db->order_by('tbl_insurances.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
        function GetAllInsurances($id,$name,$phone,$whatsapp,$status='',$gov,$district,$area,$row,$limit)
        {
            $this->db->select('tbl_insurances.*');
            $this->db->from('tbl_insurances');
            if($id!='')
            {
                $this->db->where('tbl_insurances.id',$id);
            }
            if($name!=''){
                $where1 = "( tbl_insurances.name_ar LIKE '%$name%' OR tbl_insurances.name_en LIKE '%$name%')";
                //$this->db->like('tbl_company.name_ar',$name);
                //$this->db->or_like('tbl_company.name_en',$name);
                $this->db->where($where1);
            }

            if($phone!='')
            {
                $this->db->like('tbl_insurances.phone',$phone);
            }
			if($whatsapp!='')
            {
                $this->db->like('tbl_insurances.whatsapp',$whatsapp);
            }
            if($gov!='' and $gov!='0')
                $this->db->where('tbl_insurances.governorate_id',$gov);
            if($district!='' and $district!='0')
                $this->db->where('tbl_insurances.district_id',$district);
            if($area!='' and $area!='0')
                $this->db->where('tbl_insurances.area_id',$area);
            if($status!='all')
                $this->db->where('tbl_insurances.status',$status);
            $this->db->order_by('tbl_insurances.id', 'DESC');
            if($limit!=0)
                $this->db->limit($limit,$row);
            $query = $this->db->get();
            return $query->result();
        }
function GetInsuranceBranches($id)
	{
		$this->db->select('tbl_insurance_branches.*');
		
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');

		$this->db->from('tbl_insurance_branches');
		
		$this->db->join('tbl_area', 'tbl_area.id = tbl_insurance_branches.area_id', 'left');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_area.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');

		$this->db->where('tbl_insurance_branches.insurance_id',$id);
		$this->db->order_by('governorate_en', 'ASC');
		$this->db->order_by('district_en', 'ASC');
		$this->db->order_by('area_en', 'ASC');
		$this->db->order_by('tbl_insurance_branches.name_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
function GetInsuranceBranchById($id)
	{
		$this->db->select('tbl_insurance_branches.*');
		
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_governorates.id as governorate_id');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_districts.id as district_id');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');

		$this->db->from('tbl_insurance_branches');
		
		$this->db->join('tbl_area', 'tbl_area.id = tbl_insurance_branches.area_id', 'left');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_area.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');

		$this->db->where('tbl_insurance_branches.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
function GetInsuranceDirectors($id)
	{
		$this->db->select('tbl_insurance_directors.*');
		$this->db->from('tbl_insurance_directors');
		$this->db->where('tbl_insurance_directors.insurance_id',$id);
		$this->db->order_by('tbl_insurance_directors.ordering', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetInsuranceDirectorById($id)
	{
		$this->db->select('tbl_insurance_directors.*');
		$this->db->from('tbl_insurance_directors');
		$this->db->where('tbl_insurance_directors.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
function GetInsuranceExecutives($id)
	{
		$this->db->select('tbl_insurance_managers.*');
		$this->db->from('tbl_insurance_managers');
		$this->db->where('tbl_insurance_managers.insurance_id',$id);
		$this->db->order_by('tbl_insurance_managers.ordering', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetInsuranceExecutiveById($id)
	{
		$this->db->select('tbl_insurance_managers.*');
		$this->db->from('tbl_insurance_managers');
		$this->db->where('tbl_insurance_managers.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	
		
				
}