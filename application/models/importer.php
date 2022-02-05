<?php
	class Importer extends CI_Model{
        function GetAreaByDistrict($status='',$did,$lang='ar')
        {
            $this->db->select('tbl_area.*');
            $this->db->select('COUNT(tbl_importers.id) as total');
            $this->db->from('tbl_area');
            $this->db->join('tbl_importers', 'tbl_importers.area_id = tbl_area.id', 'left');
            if($status!='')
                $this->db->where('tbl_area.status',$status);
            if($did!='' and $did!=0)
                $this->db->where('tbl_area.district_id',$did);
            $this->db->group_by('tbl_importers.area_id');
            if($lang=='en')
                $this->db->order_by('tbl_area.label_en', 'ASC');
            else
                $this->db->order_by('tbl_area.label_ar', 'ASC');
            $query = $this->db->get();
            return $query->result();
        }

        function GetImportersS($copy_res='',$is_adv='',$row,$limit)
	{
		$this->db->select('tbl_importers.*');
		//$this->db->select('tbl_company_type.label_en as type_en');
		//$this->db->select('tbl_company_type.label_ar as type_ar');
		$this->db->from('tbl_importers');
		//$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
		if($copy_res!='')
		$this->db->where('tbl_importers.copy_reservation',$copy_res);
		if($is_adv!='')
		$this->db->where('tbl_importers.is_adv',$is_adv);
		$this->db->order_by('tbl_importers.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}		
		
function GetImporterActivities($status='')
	{
		$this->db->select('tbl_importer_activities.*');
		$this->db->from('tbl_importer_activities');
	//	if($status!=''){
	//	$this->db->where('tbl_importer_activities.status',$status);
	//	}
		$this->db->order_by('tbl_importer_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetActivitiesByIds($ids=array())
	{
		$this->db->select('tbl_importer_activities.*');
		$this->db->from('tbl_importer_activities');
		$this->db->where_in('tbl_importer_activities.id',$ids);
		$this->db->order_by('tbl_importer_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetActivityById($id)
	{
		$this->db->select('tbl_importer_activities.*');
		$this->db->from('tbl_importer_activities');
		$this->db->where('tbl_importer_activities.id',$id);
		$this->db->order_by('tbl_importer_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->row_array();
	}	
		
function GetOthersImporters()
	{
		$this->db->select('tbl_importers.*');
		$this->db->from('tbl_importers');
		
		$this->db->where('tbl_importers.activity_other_ar !=','');
		$this->db->or_where('tbl_importers.activity_other_en !=','');
		
	
		$this->db->order_by('tbl_importers.name_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

function GetImporters($status='',$row,$limit)
	{
		$this->db->select('tbl_importers.*');
		$this->db->from('tbl_importers');
		if($status!='')
		$this->db->where('tbl_importers.online',$status);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('tbl_importers.id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetImporterById($id)
	{
		$this->db->select('tbl_importers.*');
		$this->db->from('tbl_importers');	
		$this->db->where('tbl_importers.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function SearchImporters($id,$name,$phone,$status='',$gov,$district,$area,$row,$limit)
	{
		$this->db->select('tbl_importers.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');

        $this->db->from('tbl_importers');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_importers.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_importers.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_importers.area_id', 'left');
		if($id!='')
		{
		$this->db->where('tbl_importers.id',$id);	
		}
		if($name!=''){
		$where1 = "( tbl_importers.name_ar LIKE '%$name%' OR tbl_importers.name_en LIKE '%$name%')";
		//$this->db->like('tbl_company.name_ar',$name);
		//$this->db->or_like('tbl_company.name_en',$name);
		$this->db->where($where1);
		}
		
		if($phone!='')
		{
		$this->db->like('tbl_importers.phone',$phone);
		}
		if($gov!='' and $gov!='0')
		$this->db->where('tbl_importers.governorate_id',$gov);
		if($district!='' and $district!='0')
		$this->db->where('tbl_importers.district_id',$district);
        if($area!='' and $area!='0')
            $this->db->where('tbl_importers.area_id',$area);
		if($status!='all')
		$this->db->where('tbl_importers.online',$status);
		$this->db->order_by('tbl_importers.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
function GetForeignCompanies($id)
	{
		$this->db->select('tbl_importer_foreign_companies.*');
		$this->db->from('tbl_importer_foreign_companies');
		$this->db->where('tbl_importer_foreign_companies.importer_id',$id);
		$this->db->order_by('tbl_importer_foreign_companies.name_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetForeignCompanyById($id)
	{
		$this->db->select('tbl_importer_foreign_companies.*');
		$this->db->from('tbl_importer_foreign_companies');
		$this->db->where('tbl_importer_foreign_companies.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
function GetInsuranceDirectors($id)
	{
		$this->db->select('tbl_insurance_directors.*');
		$this->db->from('tbl_insurance_directors');
		$this->db->where('tbl_insurance_directors.insurance_id',$id);
		$this->db->order_by('tbl_insurance_directors.name_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
        function GetAllImporters($id,$name,$phone,$status='',$gov,$district,$area,$row,$limit)
        {
            $this->db->select('tbl_importers.*');
            $this->db->from('tbl_importers');
            if($id!='')
            {
                $this->db->where('tbl_importers.id',$id);
            }
            if($name!=''){
                $where1 = "( tbl_importers.name_ar LIKE '%$name%' OR tbl_importers.name_en LIKE '%$name%')";
                //$this->db->like('tbl_company.name_ar',$name);
                //$this->db->or_like('tbl_company.name_en',$name);
                $this->db->where($where1);
            }

            if($phone!='')
            {
                $this->db->like('tbl_importers.phone',$phone);
            }
            if($gov!='' and $gov!='0')
                $this->db->where('tbl_importers.governorate_id',$gov);
            if($district!='' and $district!='0')
                $this->db->where('tbl_importers.district_id',$district);
            if($area!='' and $area!='0')
                $this->db->where('tbl_importers.area_id',$area);
            if($status!='all')
                $this->db->where('tbl_importers.online',$status);
            $this->db->order_by('tbl_importers.id', 'DESC');
            if($limit!=0)
                $this->db->limit($limit,$row);
            $query = $this->db->get();
            return $query->result();
        }
		
				
}