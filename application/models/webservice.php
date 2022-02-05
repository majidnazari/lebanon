<?php
	class Webservice extends CI_Model{
	
	
	function GetHeadingOtherCountries()
	{
		$this->db->select('tbl_countries.*');
		$this->db->select('tbl_company_type.label_en as type_en');
		$this->db->select('tbl_company_type.label_ar as type_ar');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_company');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
		$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'left');

		$this->db->where('tbl_company.show_online',1);
		$this->db->where('tbl_company.is_adv',1);
		$query = $this->db->get();
		return $query->result();
	
	}	
	function GetCompanies()
	{
		$this->db->select('tbl_company.*');
		$this->db->select('tbl_company_type.label_en as type_en');
		$this->db->select('tbl_company_type.label_ar as type_ar');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_company');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
		$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'left');

		$this->db->where('tbl_company.show_online',1);
		$this->db->where('tbl_company.is_adv',1);
		$query = $this->db->get();
		return $query->result();
	
	}
	function GetSponsors()
	{
		$this->db->select('tbl_sponsors.*');
		$this->db->from('tbl_sponsors');
		$query = $this->db->get();
		return $query->result();
	}
	function GetBanks()
	{
		$this->db->select('tbl_bank.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_bank');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_bank.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_bank.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_bank.area_id', 'left');

		$this->db->where('tbl_bank.online',1);
		$this->db->where('tbl_bank.is_adv',1);
		$query = $this->db->get();
		return $query->result();
	
	}
	function GetImporters()
	{
		$this->db->select('tbl_importers.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_importers');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_importers.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_importers.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_importers.area_id', 'left');

		$this->db->where('tbl_importers.online',1);
		$this->db->where('tbl_importers.is_adv',1);
		$query = $this->db->get();
		return $query->result();
	
	}
function GetInsurances()
	{
		$this->db->select('tbl_insurances.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_insurances');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_insurances.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_insurances.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_insurances.area_id', 'left');

		$this->db->where('tbl_insurances.online',1);
		$this->db->where('tbl_insurances.is_adv',1);
		$query = $this->db->get();
		return $query->result();
	
	}
function GetTransport()
	{
		$this->db->select('tbl_transport.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_transport');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_transport.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_transport.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_transport.area_id', 'left');

		$this->db->where('tbl_transport.online',1);
		$this->db->where('tbl_transport.is_adv',1);
		$query = $this->db->get();
		return $query->result();
	
	}

function GetProductionInfo($company_id)
	{
		$this->db->select('tbl_company_heading.*');
		$this->db->select('tbl_heading.hs_code as hscode');
		$this->db->select('tbl_heading.hs_code_print as hscodeprint');
		$this->db->select('tbl_heading.label_ar as heading_ar');
		$this->db->select('tbl_heading.label_en as heading_en');

		$this->db->select('tbl_heading.description_ar as heading_description_ar');
		$this->db->select('tbl_heading.description_en as heading_description_en');
		$this->db->from('tbl_company_heading');
		$this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
		$this->db->where('tbl_company_heading.company_id',$company_id);
		$this->db->order_by('tbl_company_heading.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetProductionInfoById($id)
	{
		$this->db->select('tbl_company_heading.*');
		$this->db->select('tbl_heading.hs_code as hscode');
		$this->db->select('tbl_heading.label_ar as heading_ar');
		$this->db->select('tbl_heading.label_en as heading_en');
		$this->db->from('tbl_company_heading');
		$this->db->join('tbl_heading', 'tbl_heading.id = tbl_company_heading.heading_id', 'inner');
		$this->db->where('tbl_company_heading.id',$id);
		$this->db->order_by('tbl_company_heading.id', 'ASC');
		$query = $this->db->get();
		return $query->row_array();
	}		
	function GetCompanyBanks($company_id)
	{
		$this->db->select('tbl_banks_company.*');
		
		$this->db->select('tbl_bank.name_ar as bank_ar');
		$this->db->select('tbl_bank.name_en as bank_en');
		$this->db->from('tbl_banks_company');
		$this->db->join('tbl_bank', 'tbl_bank.id = tbl_banks_company.bank_id', 'inner');
		$this->db->where('tbl_banks_company.company_id',$company_id);
		$this->db->order_by('tbl_banks_company.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetCompanyBankById($id)
	{
		$this->db->select('tbl_banks_company.*');
		$this->db->select('tbl_bank.name_ar as bank_ar');
		$this->db->select('tbl_bank.name_en as bank_en');
		$this->db->from('tbl_banks_company');
		$this->db->join('tbl_bank', 'tbl_bank.id = tbl_banks_company.bank_id', 'inner');
		$this->db->where('tbl_banks_company.id',$id);
		$this->db->order_by('tbl_banks_company.id', 'ASC');
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetCompanyInsurances($company_id)
	{
		$this->db->select('tbl_insurances_company.*');
		
		$this->db->select('tbl_insurances.name_ar as insurance_ar');
		$this->db->select('tbl_insurances.name_en as insurance_en');
		$this->db->from('tbl_insurances_company');
		$this->db->join('tbl_insurances', 'tbl_insurances.id = tbl_insurances_company.insurance_id', 'inner');
		$this->db->where('tbl_insurances_company.company_id',$company_id);
		$this->db->order_by('tbl_insurances_company.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetCompanyInsuranceById($id)
	{
			$this->db->select('tbl_insurances_company.*');
		
		$this->db->select('tbl_insurances.name_ar as insurance_ar');
		$this->db->select('tbl_insurances.name_en as insurance_en');
		$this->db->from('tbl_insurances_company');
		$this->db->join('tbl_insurances', 'tbl_insurances.id = tbl_insurances_company.insurance_id', 'inner');
		$this->db->where('tbl_insurances_company.id',$id);
		$this->db->order_by('tbl_insurances_company.id', 'ASC');
		$query = $this->db->get();
		return $query->row_array();
	}
	



function GetCompanyById($id)
	{
		$this->db->select('tbl_company.*');
		$this->db->select('tbl_company_type.label_en as type_en');
		$this->db->select('tbl_company_type.label_ar as type_ar');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_company');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_company.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_company.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_company.area_id', 'left');
		$this->db->join('tbl_company_type', 'tbl_company_type.id = tbl_company.company_type_id', 'left');

		$this->db->where('tbl_company.show_online',1);
		$this->db->where('tbl_company.is_adv',1);
		$this->db->where('tbl_company.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
		
	function GetBankById($id)
	{
		$this->db->select('tbl_bank.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_bank');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_bank.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_bank.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_bank.area_id', 'left');

		$this->db->where('tbl_bank.online',1);
		$this->db->where('tbl_bank.is_adv',1);
		$this->db->where('tbl_bank.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function GetBankBranches($id)
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
		$this->db->where('tbl_bank_branch.status','online');
		$this->db->order_by('governorate_ar', 'ASC');
		$this->db->order_by('district_ar', 'ASC');
		$this->db->order_by('area_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetBankDirectors($id)
	{
		$this->db->select('tbl_bank_director.*');
		$this->db->from('tbl_bank_director');
		$this->db->where('tbl_bank_director.bank_id',$id);
		$this->db->order_by('tbl_bank_director.ordering', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetImporterById($id)
	{
		$this->db->select('tbl_importers.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_importers');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_importers.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_importers.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_importers.area_id', 'left');

		$this->db->where('tbl_importers.online',1);
		$this->db->where('tbl_importers.is_adv',1);
		$this->db->where('tbl_importers.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function GetImporterForeignCompanies($id)
	{
		$this->db->select('tbl_importer_foreign_companies.*');
		$this->db->from('tbl_importer_foreign_companies');
		$this->db->where('tbl_importer_foreign_companies.importer_id',$id);
		$this->db->order_by('tbl_importer_foreign_companies.name_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
function GetImporterForeignCompanyById($id)
	{
		$this->db->select('tbl_importer_foreign_companies.*');
		$this->db->from('tbl_importer_foreign_companies');
		$this->db->where('tbl_importer_foreign_companies.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function GetImporterActivitiesByIds($ids=array())
	{
		$this->db->select('tbl_importer_activities.*');
		$this->db->from('tbl_importer_activities');
		$this->db->where_in('tbl_importer_activities.id',$ids);
		$this->db->order_by('tbl_importer_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}			
function GetImporterInsuranceDirectors($id)
	{
		$this->db->select('tbl_insurance_directors.*');
		$this->db->from('tbl_insurance_directors');
		$this->db->where('tbl_insurance_directors.insurance_id',$id);
		$this->db->order_by('tbl_insurance_directors.name_ar', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
function GetInsuranceById($id)
	{
		$this->db->select('tbl_insurances.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_insurances');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_insurances.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_insurances.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_insurances.area_id', 'left');

		$this->db->where('tbl_insurances.online',1);
		$this->db->where('tbl_insurances.is_adv',1);
		$this->db->where('tbl_insurances.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
function GetInsuranceActivitiesByIds($ids=array())
	{
		$this->db->select('tbl_insurance_activities.*');
		$this->db->from('tbl_insurance_activities');
		$this->db->where_in('tbl_insurance_activities.id',$ids);
		$this->db->order_by('tbl_insurance_activities.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}	
		
function GetTransportById($id)
	{
		$this->db->select('tbl_transport.*');
		$this->db->select('tbl_governorates.label_ar as governorate_ar');
		$this->db->select('tbl_governorates.label_en as governorate_en');
		$this->db->select('tbl_districts.label_ar as district_ar');
		$this->db->select('tbl_districts.label_en as district_en');
		$this->db->select('tbl_area.label_ar as area_ar');
		$this->db->select('tbl_area.label_en as area_en');	
		$this->db->from('tbl_transport');
		$this->db->join('tbl_governorates', 'tbl_governorates.id = tbl_transport.governorate_id', 'left');
		$this->db->join('tbl_districts', 'tbl_districts.id = tbl_transport.district_id', 'left');
		$this->db->join('tbl_area', 'tbl_area.id = tbl_transport.area_id', 'left');

		$this->db->where('tbl_transport.online',1);
		$this->db->where('tbl_transport.is_adv',1);
		$this->db->where('tbl_transport.id',$id);
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
	function GetCompanyTypes($status='')
	{
		$this->db->select('tbl_company_type.*');
		$this->db->from('tbl_company_type');
		if($status!='')
		$this->db->where('tbl_company_type.status',$status);
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

	function SearchPosition($status='',$description)
	{
		$this->db->select('tbl_positions.*');
		$this->db->from('tbl_positions');
		if($description!=''){
		$this->db->like('tbl_positions.label_en',$description);
		$this->db->or_like('tbl_positions.label_ar',$description);
		}
		
		if($status!='')
		$this->db->like('tbl_positions.status',$status);
		
		$query = $this->db->get();
		return $query->result();
	}
	
		

	function GetSubHeading($status='',$row,$limit)
	{
		$this->db->select('tbl_subhead.*');
		$this->db->from('tbl_subhead');
		if($status!='')
		$this->db->where('tbl_subhead.status',$status);
		$this->db->order_by('tbl_subhead.code', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
	function SearchSubHeading($status,$code,$description)
	{
		$this->db->select('tbl_subhead.*');
		$this->db->from('tbl_subhead');
		if($description!=''){
		$this->db->like('tbl_subhead.title_en',$description);
		$this->db->or_like('tbl_subhead.title_ar',$description);
		}
		
		if($status!='')
		$this->db->like('tbl_subhead.status',$status);
		if($code!='')
		$this->db->like('tbl_subhead.code',$code);
		$this->db->order_by('tbl_subhead.code', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetSector($status='',$row,$limit)
	{
		$this->db->select('tbl_sectors.*');
		$this->db->from('tbl_sectors');
		if($status!='')
		$this->db->where('tbl_sectors.status',$status);
		$this->db->order_by('tbl_sectors.label_en', 'ASC');
		if($limit!=0)
		$this->db->limit($limit,$row);
		$query = $this->db->get();
		return $query->result();
	}
	function SearchSector($status,$description)
	{
		$this->db->select('tbl_sectors.*');
		$this->db->from('tbl_sectors');
		if($description!=''){
		$this->db->like('tbl_sectors.label_en',$description);
		$this->db->or_like('tbl_sectors.label_ar',$description);
		$this->db->or_like('tbl_sectors.intro_ar',$description);
		$this->db->or_like('tbl_sectors.intro_en',$description);

		}
		
		if($status!='')
		$this->db->like('tbl_sectors.status',$status);
		$this->db->order_by('tbl_sectors.label_en', 'ASC');
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
		function GetMarkets($status)
	{
		$this->db->select('tbl_markets.*');		
		$this->db->from('tbl_markets');
		$this->db->where('tbl_markets.status',$status);
		$this->db->order_by('tbl_markets.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetMarketByCountryId($status,$country_id)
	{
		$this->db->select('tbl_markets.*');		
		$this->db->from('tbl_markets');
		//$this->db->where('tbl_markets.country_id',$country_id);
		$this->db->where('tbl_markets.status',$status);
		$this->db->order_by('tbl_markets.label_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetCompanyMarkets($company_id)
	{
		$this->db->select('tbl_markets_company.*');		
//		$this->db->select('tbl_markets.label_ar as market_ar');
//		$this->db->select('tbl_markets.label_en as market_en');
		$this->db->from('tbl_markets_company');
	//	$this->db->join('tbl_markets', 'tbl_markets.id = tbl_markets_company.market_id', 'inner');
		$this->db->where('tbl_markets_company.company_id',$company_id);
		$this->db->order_by('tbl_markets_company.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetCompanyMarketsById($id)
	{
		$this->db->select('tbl_markets_company.*');		
	//	$this->db->select('tbl_markets.label_ar as market_ar');
	//	$this->db->select('tbl_markets.label_en as market_en');
		$this->db->from('tbl_markets_company');
	//	$this->db->join('tbl_markets', 'tbl_markets.id = tbl_markets_company.market_id', 'inner');
		$this->db->where('tbl_markets_company.id',$id);
		$this->db->order_by('tbl_markets_company.id', 'ASC');
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function GetCompanyElectricPowers($company_id)
	{
		$this->db->select('tbl_power_company.*');
		$this->db->from('tbl_power_company');
		$this->db->where('tbl_power_company.company_id',$company_id);
		$this->db->order_by('tbl_power_company.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetCompanyElectricPowerById($id)
	{
		$this->db->select('tbl_power_company.*');
		$this->db->from('tbl_power_company');
		$this->db->where('tbl_power_company.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetCompanyEPower($id)
	{
		$this->db->select('tbl_power_company.*');
		$this->db->from('tbl_power_company');
		$this->db->where('tbl_power_company.company_id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetCompanySponsors($status)
	{
		$this->db->select('tbl_sponsors.*');
		$this->db->from('tbl_sponsors');
		$this->db->where('tbl_sponsors.status',$status);
		$query = $this->db->get();
		return $query->result();
	}

	function GetCountries($status='',$row,$limit)
	{
		$this->db->select('tbl_countries.*');
		$this->db->from('tbl_countries');	
		if($status!='')
		$this->db->where('tbl_countries.status',$status);
		if($limit!=0)
		$this->db->limit($limit,$row);	
		$this->db->order_by('tbl_countries.label_ar', 'ASC');
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
	function GetIndustrialRooms()
	{
		$this->db->select('tbl_industrial_room.*');
		$this->db->from('tbl_industrial_room');
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
	function GetIndustrialGroups()
	{
		$this->db->select('tbl_industrial_group.*');
		$this->db->from('tbl_industrial_group');
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

	function GetEconomicalAssemblies()
	{
		$this->db->select('tbl_economical_assembly.*');
		$this->db->from('tbl_economical_assembly');
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
	function GetPositions()
	{
		$this->db->select('tbl_positions.*');
		$this->db->from('tbl_positions');
		$query = $this->db->get();
		return $query->result();
	}
	
	function GetSalesMan($id)
	{
		$this->db->select('tbl_sales_man.*');
		$this->db->from('tbl_sales_man');
		$this->db->where('tbl_sales_man.id',$id);
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
	function GetLicenseSourceById($id)
	{
		$this->db->select('tbl_license_sources.*');
		$this->db->from('tbl_license_sources');
		$this->db->where('tbl_license_sources.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetLicenseSources()
	{
		$this->db->select('tbl_license_sources.*');
		$this->db->from('tbl_license_sources');
		$query = $this->db->get();
		return $query->result();
	}
				

}