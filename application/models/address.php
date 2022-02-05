<?php
	class Address extends CI_Model{

        function GetAreas($gov='',$district,$area)
        {
            $this->db->select('tbl_area.*');
            $this->db->select('tbl_governorates.label_ar as governorate_ar');
            $this->db->select('tbl_governorates.label_en as governorate_en');
            $this->db->select('tbl_districts.label_ar as district_ar');
            $this->db->select('tbl_districts.label_en as district_en');
            $this->db->from('tbl_area');
            $this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_area.governorate_id', 'left');
            $this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');
            if($area!=''){
                $this->db->where('tbl_area.id',$area);
            }
            if($district!='' and $district!=0)
                $this->db->where('tbl_area.district_id',$district);
            if($gov!='' and $gov!=0)
                $this->db->where('tbl_area.governorate_id',$gov);

            $this->db->order_by('tbl_area.governorate_id', 'ASC');
            $this->db->order_by('tbl_area.district_id', 'ASC');
            $this->db->order_by('tbl_area.label_ar', 'ASC');
            $query = $this->db->get();
            return $query->result();
        }
	    function GetCountries($status='',$row,$limit)
	{
		$this->db->select('tbl_countries.*');
		$this->db->from('tbl_countries');
		if($status!='')
		$this->db->where('tbl_countries.status',$status);
		$this->db->order_by('tbl_countries.label_en', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}	
	

	function GetGovernorate($status='',$row,$limit)
	{
		$this->db->select('tbl_governorates.*');
		$this->db->from('tbl_governorates');
		if($status!='')
		$this->db->where('tbl_governorates.status',$status);
		$this->db->order_by('tbl_governorates.rank', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
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
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->from('tbl_districts');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_districts.governorate_id', 'left');
		if($status!='')
		$this->db->where('tbl_districts.status',$status);
		$this->db->order_by('tbl_districts.label_ar', 'ASC');
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

	function GetDistrictByGov($status='',$gid,$lang=false)
	{
		$this->db->select('tbl_districts.*');
		$this->db->from('tbl_districts');
		if($status!='')
		$this->db->where('tbl_districts.status',$status);
		if($gid!='')
		$this->db->where('tbl_districts.governorate_id',$gid);
		if($lang='ar')
		$this->db->order_by('tbl_districts.label_ar', 'ASC');
		else
		$this->db->order_by('tbl_districts.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetAreaByDistrict($status='',$did,$lang='ar')
	{
		$this->db->select('tbl_area.*');
		$this->db->from('tbl_area');
		if($status!='')
		$this->db->where('tbl_area.status',$status);
		$this->db->where('tbl_area.district_id',$did);
		if($lang=='en')
		$this->db->order_by('tbl_area.label_en', 'ASC');
		else
		$this->db->order_by('tbl_area.label_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
	function GetAreaById($id)
	{
		$this->db->select('tbl_area.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->from('tbl_area');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_area.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');
		$this->db->where('tbl_area.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
function SearchArea($area,$districtID,$govID,$status,$row,$limit)
	{
		$this->db->select('tbl_area.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->from('tbl_area');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_area.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');
		if($area!=''){
			$where = "( tbl_area.label_en LIKE '%$area%' OR tbl_area.label_ar LIKE '%$area%')";
   			$this->db->where($where);
		}
		if($districtID!='' and $districtID!=0)
		$this->db->where('tbl_area.district_id',$districtID);
		if($govID!='' and $govID!=0)
		$this->db->where('tbl_area.governorate_id',$govID);
		if($status!='')
		$this->db->like('tbl_area.status',$status);
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('tbl_area.governorate_id', 'ASC');
		$this->db->order_by('tbl_area.district_id', 'ASC');
		$this->db->order_by('tbl_area.label_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetArea($row,$limit)
	{
		$this->db->select('tbl_area.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->from('tbl_area');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_area.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_area.district_id', 'left');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$this->db->order_by('tbl_area.governorate_id', 'ASC');
		$this->db->order_by('tbl_area.district_id', 'ASC');
		$this->db->order_by('tbl_area.label_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
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


	function GetCountryById($id)
	{
		$this->db->select('tbl_countries.*');
		$this->db->from('tbl_countries');	
		$this->db->where('tbl_countries.id',$id);
		$query = $this->db->get();
		return $query->row_array();
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