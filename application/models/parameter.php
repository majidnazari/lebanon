<?php
	class Parameter extends CI_Model{		

	function GetPositions()
	{
		$this->db->select('tbl_positions.*');
		$this->db->from('tbl_positions');
		$this->db->order_by('tbl_positions.label_ar', 'ASC');
		$this->db->order_by('tbl_positions.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetPositionById($id)
	{
		$this->db->select('tbl_positions.*');
		$this->db->from('tbl_positions');
		$this->db->where('tbl_positions.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function GetCompanyMarkets()
	{
		$this->db->select('tbl_markets.*');
		$this->db->from('tbl_markets');
		//$this->db->order_by('tbl_markets.label_ar', 'ASC');
		//$this->db->order_by('tbl_markets.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetCompanyMarketById($id)
	{
		$this->db->select('tbl_markets.*');
		$this->db->from('tbl_markets');
		$this->db->where('tbl_markets.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetCountryById($id)
	{
		//die("this is runs get method id is : $id");
		$this->db->select('tbl_countries.*');
		$this->db->from('tbl_countries');
		$this->db->where('tbl_countries.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetInsuranceActivities()
	{
		$this->db->select('tbl_insurance_activities.*');
		$this->db->from('tbl_insurance_activities');
		$this->db->order_by('tbl_insurance_activities.label_ar', 'ASC');
		$this->db->order_by('tbl_insurance_activities.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetInsuranceActivityById($id)
	{
		$this->db->select('tbl_insurance_activities.*');
		$this->db->from('tbl_insurance_activities');
		$this->db->where('tbl_insurance_activities.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetImporterActivities()
	{
		$this->db->select('tbl_importer_activities.*');
		$this->db->from('tbl_importer_activities');
		$this->db->order_by('tbl_importer_activities.label_ar', 'ASC');
		$this->db->order_by('tbl_importer_activities.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetImporterActivityById($id)
	{
		$this->db->select('tbl_importer_activities.*');
		$this->db->from('tbl_importer_activities');
		$this->db->where('tbl_importer_activities.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetSalesManToReport($lang = 'ar') { 
        $this->db->select('tbl_sales_man.*');
        // $this->db->select('tbl_governorates.label_ar as governorate_ar');
        // $this->db->select('tbl_governorates.label_en as governorate_en');
        // $this->db->select('tbl_districts.label_ar as district_ar');
        // $this->db->select('tbl_districts.label_en as district_en');
        // $this->db->select('tbl_area.label_ar as area_ar');
        // $this->db->select('tbl_area.label_en as area_en');
        $this->db->from('tbl_sales_man');
        // $this->db->join('tbl_area', 'tbl_area.id = tbl_bank.area_id', 'left');
        // $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_bank.governorate_id', 'left');
        // $this->db->join('tbl_districts', 'tbl_districts.id = tbl_bank.district_id', 'left');

        if($lang == 'en') {
            $this->db->order_by('tbl_sales_man.fullname_en', 'ASC');
            //$this->db->order_by('governorate_en', 'ASC');
            //$this->db->order_by('district_en', 'ASC');
            //$this->db->order_by('area_en', 'ASC');
            
        }
        else {
            //$this->db->order_by('governorate_ar', 'ASC');
            $this->db->order_by('tbl_sales_man.fullname', 'ASC');
            //$this->db->order_by('district_ar', 'ASC');
           // $this->db->order_by('area_ar', 'ASC');
            
        }
        $query = $this->db->get();
        return $query->result();
    }

	function GetSalesmen()
	{
		$this->db->select('tbl_sales_man.*');
		$this->db->from('tbl_sales_man');
		$this->db->order_by('tbl_sales_man.fullname', 'ASC');
		$this->db->order_by('tbl_sales_man.fullname_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetSalesmanById($id)
	{
		$this->db->select('tbl_sales_man.*');
		$this->db->from('tbl_sales_man');
		$this->db->where('tbl_sales_man.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function GetIndustrialRooms()
	{
		$this->db->select('tbl_industrial_room.*');
		$this->db->from('tbl_industrial_room');
		$this->db->order_by('tbl_industrial_room.label_ar', 'ASC');
		$this->db->order_by('tbl_industrial_room.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetIndustrialRoomById($id)
	{
		$this->db->select('tbl_industrial_room.*');
		$this->db->from('tbl_industrial_room');
		$this->db->where('tbl_industrial_room.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function GetCompanyTypes()
	{
		$this->db->select('tbl_company_type.*');
		$this->db->from('tbl_company_type');
		$this->db->order_by('tbl_company_type.label_ar', 'ASC');
		$this->db->order_by('tbl_company_type.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetCompanyTypeById($id)
	{
		$this->db->select('tbl_company_type.*');
		$this->db->from('tbl_company_type');
		$this->db->where('tbl_company_type.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetEconomicalUnion()
	{
		$this->db->select('tbl_technical_union.*');
		$this->db->from('tbl_technical_union');
		$this->db->order_by('tbl_technical_union.label_ar', 'ASC');
		$this->db->order_by('tbl_technical_union.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetEconomicalUnionById($id)
	{
		$this->db->select('tbl_technical_union.*');
		$this->db->from('tbl_technical_union');
		$this->db->where('tbl_technical_union.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetIndustrialGroups()
	{
		$this->db->select('tbl_industrial_group.*');
		$this->db->from('tbl_industrial_group');
		$this->db->order_by('tbl_industrial_group.label_ar', 'ASC');
		$this->db->order_by('tbl_industrial_group.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetIndustrialGroupById($id)
	{
		$this->db->select('tbl_industrial_group.*');
		$this->db->from('tbl_industrial_group');
		$this->db->where('tbl_industrial_group.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function GetEconomicalAssembly()
	{
		$this->db->select('tbl_economical_assembly.*');
		$this->db->from('tbl_economical_assembly');
		$this->db->order_by('tbl_economical_assembly.label_ar', 'ASC');
		$this->db->order_by('tbl_economical_assembly.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetEconomicalAssemblyById($id)
	{
		$this->db->select('tbl_economical_assembly.*');
		$this->db->from('tbl_economical_assembly');
		$this->db->where('tbl_economical_assembly.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function GetLicenseSources()
	{
		$this->db->select('tbl_license_sources.*');
		$this->db->from('tbl_license_sources');
		$this->db->order_by('tbl_license_sources.label_ar', 'ASC');
		$this->db->order_by('tbl_license_sources.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetLicenseSourcesById($id)
	{
		$this->db->select('tbl_license_sources.*');
		$this->db->from('tbl_license_sources');
		$this->db->where('tbl_license_sources.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function SearchGovernorate($status='',$description)
	{
		$this->db->select('tbl_governorates.*');
		$this->db->from('tbl_governorates');
		if($description!=''){
		$this->db->like('tbl_governorates.label_en',$description);
		$this->db->or_like('tbl_governorates.label_ar',$description);
		}
		
		if($status!='')
		$this->db->like('tbl_governorates.status',$status);
		$this->db->order_by('tbl_governorates.rank', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetGovernorateById($id)
	{
		$this->db->select('tbl_governorates.*');
		$this->db->from('tbl_governorates');
		$this->db->where('tbl_governorates.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function GetDistrict($status='',$row,$limit)
	{
		$this->db->select('tbl_districts.*');
		$this->db->from('tbl_districts');
		if($status!='')
		$this->db->where('tbl_districts.status',$status);
		$this->db->order_by('tbl_districts.label_en', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
	function GetDistrictById($id)
	{
		$this->db->select('tbl_districts.*');
		$this->db->from('tbl_districts');
		$this->db->where('tbl_districts.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function GetDistrictByGov($status='',$gid)
	{
		$this->db->select('tbl_districts.*');
		$this->db->from('tbl_districts');
		if($status!='')
		$this->db->where('tbl_districts.status',$status);
		if($gid!='')
		$this->db->where('tbl_districts.governorate_id',$gid);
		$this->db->order_by('tbl_districts.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetAreaByDistrict($status='',$did)
	{
		$this->db->select('tbl_area.*');
		$this->db->from('tbl_area');
		if($status!='')
		$this->db->where('tbl_area.status',$status);
		$this->db->where('tbl_area.district_id',$did);
		$this->db->order_by('tbl_area.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetAreaById($id)
	{
		$this->db->select('tbl_area.*');
		$this->db->from('tbl_area');
		$this->db->where('tbl_area.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	

	function SearchDistrict($status,$description)
	{
		$this->db->select('tbl_districts.*');
		$this->db->from('tbl_districts');
		if($description!=''){
		$this->db->like('tbl_districts.label_en',$description);
		$this->db->or_like('tbl_districts.label_ar',$description);
		$this->db->or_like('tbl_districts.governorate_id',$description);

		}
		
		if($status!='')
		$this->db->like('tbl_districts.status',$status);
		$this->db->order_by('tbl_districts.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	function GetSection($status='',$row,$limit)
	{
		$this->db->select('tbl_section.*');
		$this->db->select('tbl_sectors.label_ar as sector_ar');
		$this->db->select('tbl_sectors.label_en as sector_en');
		$this->db->select('tbl_sectors.label_en as sector_en');
		$this->db->from('tbl_section');
		$this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
		if($status!='')
		$this->db->where('tbl_section.status',$status);
		$this->db->order_by('tbl_section.label_en', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
	function GetSectionsBySectorId($status='',$sector)
	{
		$this->db->select('tbl_section.*');
		$this->db->select('tbl_sectors.label_ar as sector_ar');
		$this->db->select('tbl_sectors.label_en as sector_en');
		$this->db->from('tbl_section');
		$this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
		if($status!='')
		$this->db->where('tbl_section.status',$status);
		if($sector!=0)
		$this->db->where('tbl_section.sector_id',$sector);
		$this->db->order_by('tbl_section.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function SearchSection($status,$description,$sector)
	{
		$this->db->select('tbl_section.*');
		$this->db->select('tbl_sectors.label_ar as sector_ar');
		$this->db->select('tbl_sectors.label_en as sector_en');
		$this->db->from('tbl_section');
		$this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
		if($sector!=0)
		$this->db->where('tbl_section.sector_id',$sector);
		if($description!=''){
		//$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
		//$this->db->or_like('tbl_section.label_ar',$description);
		$where = "( tbl_section.label_en LIKE '%$description%' OR tbl_section.label_ar LIKE '%$description%')";
   		$this->db->where($where);
		}
		
		if($status!='')
		$this->db->like('tbl_section.status',$status);

		$this->db->order_by('tbl_section.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetChapter($status='',$row,$limit)

	{
		$this->db->select('tbl_chapter.*');
		$this->db->select('tbl_section.label_ar as section_ar');
		$this->db->select('tbl_section.label_en as section_en');
		$this->db->select('tbl_section.sector_id as sector_id');
		$this->db->from('tbl_chapter');
		$this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
		if($status!='')
		$this->db->where('tbl_chapter.status',$status);
		$this->db->order_by('tbl_chapter.label_en', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
	function SearchChapter($status,$description,$section,$sector)
	{
		$this->db->select('tbl_chapter.*');
		$this->db->select('tbl_section.label_ar as section_ar');
		$this->db->select('tbl_section.label_en as section_en');
		$this->db->select('tbl_section.sector_id as sector_id');
		$this->db->from('tbl_chapter');
		$this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
		if($section!=0)
		$this->db->where('tbl_chapter.section_id',$section);
		if($sector!=0)
		$this->db->where('tbl_section.sector_id',$sector);

		if($description!=''){
		//$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
		//$this->db->or_like('tbl_section.label_ar',$description);
		$where = "( tbl_chapter.label_en LIKE '%$description%' OR tbl_chapter.label_ar LIKE '%$description%')";
   		$this->db->where($where);
		}
		
		if($status!='')
		$this->db->like('tbl_chapter.status',$status);

		$this->db->order_by('tbl_chapter.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetItems($status='',$row,$limit)
	{
		$this->db->select('tbl_heading.*');
		$this->db->select('tbl_chapter.label_ar as chapter_ar');
		$this->db->select('tbl_chapter.label_en as chapter_en');
		$this->db->select('tbl_subhead.title_en as subhead_en');
		$this->db->select('tbl_subhead.title_ar as subhead_ar');
		$this->db->from('tbl_heading');
		$this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'inner');
		$this->db->join('tbl_subhead', 'tbl_subhead.id = tbl_heading.subhead_id', 'inner');
		if($status!='')
		$this->db->where('tbl_heading.status',$status);
		$this->db->order_by('tbl_heading.label_en', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
	function SearchItems($status,$description,$section,$sector)
	{
		$this->db->select('tbl_chapter.*');
		$this->db->select('tbl_section.label_ar as section_ar');
		$this->db->select('tbl_section.label_en as section_en');
		$this->db->select('tbl_section.sector_id as sector_id');
		$this->db->from('tbl_chapter');
		$this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
		if($section!=0)
		$this->db->where('tbl_chapter.section_id',$section);
		if($sector!=0)
		$this->db->where('tbl_section.sector_id',$sector);

		if($description!=''){
		//$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
		//$this->db->or_like('tbl_section.label_ar',$description);
		$where = "( tbl_chapter.label_en LIKE '%$description%' OR tbl_chapter.label_ar LIKE '%$description%')";
   		$this->db->where($where);
		}
		
		if($status!='')
		$this->db->like('tbl_chapter.status',$status);

		$this->db->order_by('tbl_chapter.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}


	
	function GetCitiesByCountryId($country_id)
	{
		$this->db->select('cities.*');
		$this->db->from('cities');
		$this->db->order_by('city', 'ASC');
		$this->db->where('cities.countryid',$country_id);
		$query = $this->db->get();
		return $query->result();
	}
	function GetCityId($id)
	{
		$this->db->select('cities.*');
		$this->db->from('cities');
		$this->db->where('cities.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}				
}