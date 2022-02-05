<?php
	class Transport extends CI_Model{
        function GetAreaByDistrict($status='',$did,$lang='ar')
        {
            $this->db->select('tbl_area.*');
            $this->db->select('COUNT(tbl_transport.id) as total');
            $this->db->from('tbl_area');
            $this->db->join('tbl_transport', 'tbl_transport.area_id = tbl_area.id', 'left');
            if($status!='')
                $this->db->where('tbl_area.status',$status);
            if($did!='' and $did!=0)
                $this->db->where('tbl_area.district_id',$did);
            $this->db->group_by('tbl_transport.area_id');
            if($lang=='en')
                $this->db->order_by('tbl_area.label_en', 'ASC');
            else
                $this->db->order_by('tbl_area.label_ar', 'ASC');
            $query = $this->db->get();
            return $query->result();
        }
	function GetTransportsS($copy_res='',$is_adv='',$row,$limit)
	{
		$this->db->select('tbl_transport.*');
		//$this->db->select('tbl_company_type.label_en as type_en');
		//$this->db->select('tbl_company_type.label_ar as type_ar');
		$this->db->from('tbl_transport');
		//$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'inner');
		if($copy_res!='')
		$this->db->where('tbl_transport.copy_reservation',$copy_res);
		if($is_adv!='')
		$this->db->where('tbl_transport.is_adv',$is_adv);
		$this->db->order_by('tbl_transport.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}		
function GetTransportServices($status='')
	{
		$this->db->select('tbl_transport_services.*');
		$this->db->from('tbl_transport_services');
	//	if($status!=''){
	//	$this->db->where('tbl_importer_activities.status',$status);
	//	}
		$this->db->order_by('tbl_transport_services.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetServicesByIds($ids=array())
	{
		$this->db->select('tbl_transport_services.*');
		$this->db->from('tbl_transport_services');
		$this->db->where_in('tbl_transport_services.id',$ids);
		$this->db->order_by('tbl_transport_services.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
		
function GetTransportations($status='',$row,$limit)
	{
		$this->db->select('tbl_transport.*');
		$this->db->from('tbl_transport');
		if($status!='')
		$this->db->where('tbl_transport.online',$status);
		
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('tbl_transport.id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetTransportationById($id)
	{
		$this->db->select('tbl_transport.*');
		$this->db->from('tbl_transport');	
		$this->db->where('tbl_transport.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function SearchTransportations($id,$name,$phone,$status='',$gov,$district,$area, $row,$limit)
	{
		$this->db->select('tbl_transport.*');
        $this->db->select('tbl_governorates.label_ar as governorate_ar,tbl_governorates.label_en as governorate_en');
        $this->db->select('tbl_districts.label_ar as district_ar, tbl_districts.label_en as district_en');
        $this->db->select('tbl_area.label_ar as area_ar, tbl_area.label_en as area_en');

        $this->db->from('tbl_transport');
        $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_transport.governorate_id', 'left');
        $this->db->join('tbl_districts', 'tbl_districts.id = tbl_transport.district_id', 'left');
        $this->db->join('tbl_area', 'tbl_area.id = tbl_transport.area_id', 'left');
		if($id!='')
		{
		$this->db->where('tbl_transport.id',$id);	
		}
		if($name!=''){
		$where1 = "( tbl_transport.name_ar LIKE '%$name%' OR tbl_transport.name_en LIKE '%$name%')";
		//$this->db->like('tbl_company.name_ar',$name);
		//$this->db->or_like('tbl_company.name_en',$name);
		$this->db->where($where1);
		}
		
		if($phone!='')
		{
		$this->db->like('tbl_transport.phone',$phone);
		}
		if($gov!='' and $gov!='0')
		$this->db->where('tbl_transport.governorate_id',$gov);
		if($district!='' and $district!='0')
		$this->db->where('tbl_transport.district_id',$district);
        if($area!='' and $area!='0')
            $this->db->where('tbl_transport.area_id',$area);
		if($status!='all')
		$this->db->where('tbl_transport.online',$status);
		$this->db->order_by('tbl_transport.id', 'DESC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
        function GetAllTransportations($id,$name,$phone,$status='',$gov,$district,$area,$row,$limit)
        {
            $this->db->select('tbl_transport.*');
            $this->db->from('tbl_transport');
            if($id!='')
            {
                $this->db->where('tbl_transport.id',$id);
            }
            if($name!=''){
                $where1 = "( tbl_transport.name_ar LIKE '%$name%' OR tbl_transport.name_en LIKE '%$name%')";
                //$this->db->like('tbl_company.name_ar',$name);
                //$this->db->or_like('tbl_company.name_en',$name);
                $this->db->where($where1);
            }

            if($phone!='')
            {
                $this->db->like('tbl_transport.phone',$phone);
            }
            if($gov!='' and $gov!='0')
                $this->db->where('tbl_transport.governorate_id',$gov);
            if($district!='' and $district!='0')
                $this->db->where('tbl_transport.district_id',$district);
            if($area!='' and $area!='0')
                $this->db->where('tbl_transport.area_id',$area);
            if($status!='all')
                $this->db->where('tbl_transport.online',$status);
            $this->db->order_by('tbl_transport.id', 'DESC');
            if($limit!=0)
                $this->db->limit($limit,$row);
            $query = $this->db->get();
            return $query->result();
        }
function GetBranches($id)
	{
		$this->db->select('tbl_transport_branches.*');
		$this->db->from('tbl_transport_branches');
		$this->db->where('tbl_transport_branches.transport_id',$id);
		$this->db->order_by('tbl_transport_branches.name_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetBranchById($id)
	{
		$this->db->select('tbl_transport_branches.*');
		$this->db->from('tbl_transport_branches');
		$this->db->where('tbl_transport_branches.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
function GetTransportLineRepresented($id)
	{
		$this->db->select('tbl_transport_line_represented.*');
		$this->db->from('tbl_transport_line_represented');
		$this->db->where('tbl_transport_line_represented.transport_id',$id);
		$this->db->order_by('tbl_transport_line_represented.name_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetTransportPorts($id)
	{
		$this->db->select('tbl_transport_ports.*');
		$this->db->from('tbl_transport_ports');
		$this->db->where('tbl_transport_ports.transport_id',$id);
		$this->db->order_by('tbl_transport_ports.name_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	
		
				
}