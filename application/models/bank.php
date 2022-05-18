<?php
	class Bank extends CI_Model{

        function GetAreaByDistrict($status='',$did,$lang='ar')
        {
            $this->db->select('tbl_area.*');
            $this->db->select('COUNT(tbl_bank.id) as total');
            $this->db->from('tbl_area');
            $this->db->join('tbl_bank', 'tbl_bank.area_id = tbl_area.id', 'left');
            if($status!='')
                $this->db->where('tbl_area.status',$status);
            if($did!='' and $did!=0)
                $this->db->where('tbl_area.district_id',$did);
            $this->db->group_by('tbl_bank.area_id');
            if($lang=='en')
                $this->db->order_by('tbl_area.label_en', 'ASC');
            else
                $this->db->order_by('tbl_area.label_ar', 'ASC');
            $query = $this->db->get();
            return $query->result();
        }
        function GetBanksS($copy_res='',$is_adv='',$row,$limit)
	{
		$this->db->select('tbl_bank.*');
		//$this->db->select('tbl_company_type.label_en as type_en');
		//$this->db->select('tbl_company_type.label_ar as type_ar');
		$this->db->from('tbl_bank');
		//$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
		if($copy_res!='')
		$this->db->where('tbl_bank.copy_res',$copy_res);
		if($is_adv!='')
		$this->db->where('tbl_bank.is_adv',$is_adv);
		$this->db->order_by('tbl_bank.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}		
	function GetBanks($status='',$row,$limit)
	{
		$this->db->select('tbl_bank.*');
		$this->db->from('tbl_bank');
		if($status!='')
		$this->db->where('tbl_bank.online',$status);
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('tbl_bank.id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetBranches($status='', $id)
	{
		$this->db->select('tbl_bank_branch.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');
		$this->db->from('tbl_bank_branch');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_bank_branch.area_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_districts.governorate_id', 'left');
		$this->db->where('tbl_bank_branch.bank_id',$id);
		if($status!='')
		$this->db->where('tbl_bank_branch.status',$status);
		$this->db->order_by('governorate_ar', 'ASC');
		$this->db->order_by('district_ar', 'ASC');
		$this->db->order_by('area_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetDirectors($id)
	{
		$this->db->select('tbl_bank_director.*');
		$this->db->from('tbl_bank_director');
		$this->db->where('tbl_bank_director.bank_id',$id);
		$this->db->order_by('tbl_bank_director.ordering', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetDirectorById($id)
	{
		$this->db->select('tbl_bank_director.*');
		$this->db->from('tbl_bank_director');	
		$this->db->where('tbl_bank_director.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetSalesMen()
	{
		$this->db->select('tbl_sales_man.*');
		$this->db->from('tbl_sales_man');
		$query = $this->db->get();
		return $query->result();
	}
	function GetBankById($id)
	{
		$this->db->select('tbl_bank.*');
		$this->db->from('tbl_bank');	
		$this->db->where('tbl_bank.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetBranchById($id)
	{
		$this->db->select('tbl_bank_branch.*');
		$this->db->from('tbl_bank_branch');	
		$this->db->where('tbl_bank_branch.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function SearchBanks($id,$name,$phone,$whatsapp,$fax,$status='',$gov,$district,$area,$row,$limit)
	{
		$this->db->select('tbl_bank.*');
		$this->db->from('tbl_bank');
		if($name!=''){
		//$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
		//$this->db->or_like('tbl_section.label_ar',$description);
		$where = "( tbl_bank.name_en LIKE '%$name%' OR tbl_bank.name_ar LIKE '%$name%')";
   		$this->db->where($where);
		}
		if($id!=''){
			$this->db->like('tbl_bank.id',$id);
		}
		if($phone!=''){
			$this->db->like('tbl_bank.phone',$phone);
		}
		if($whatsapp!=''){
			$this->db->like('tbl_bank.whatsapp',$whatsapp);
		}
		if($fax!=''){
			$this->db->like('tbl_bank.fax',$fax);
		}
		if($gov!='' and $gov!=0)
		$this->db->where('tbl_bank.governorate_id',$gov);
		if($district!='' and $district!=0)
		$this->db->where('tbl_bank.district_id',$district);
        if($area!='' and $area!=0)
            $this->db->where('tbl_bank.area_id',$area);

        if($status!='all')
		$this->db->where('tbl_bank.online',$status);
		$this->db->order_by('tbl_bank.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
	             
        function GetAllBanks($id,$name,$phone,$whatsapp,$fax,$status='',$gov,$district,$area,$row,$limit)
        {
            $this->db->select('tbl_bank.*');
            $this->db->from('tbl_bank');
            if($name!=''){
                //$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
                //$this->db->or_like('tbl_section.label_ar',$description);
                $where = "( tbl_bank.name_en LIKE '%$name%' OR tbl_bank.name_ar LIKE '%$name%')";
                $this->db->where($where);
            }
            if($id!=''){
                $this->db->like('tbl_bank.id',$id);
            }
            if($phone!=''){
                $this->db->like('tbl_bank.phone',$phone);
            }
			if($whatsapp!=''){
                $this->db->like('tbl_bank.whatsapp',$whatsapp);
            }
            if($fax!=''){
                $this->db->like('tbl_bank.fax',$fax);
            }
            if($gov!='' and $gov!=0)
                $this->db->where('tbl_bank.governorate_id',$gov);
            if($district!='' and $district!=0)
                $this->db->where('tbl_bank.district_id',$district);
            if($area!='')
                $this->db->where('tbl_bank.area_id',$area);
            if($status!='all')
                $this->db->where('tbl_bank.online',$status);
            $this->db->order_by('tbl_bank.id', 'DESC');
            if($limit!=0)
                $this->db->limit($limit,$row);
            $query = $this->db->get();
            return $query->result();
        }
		
}