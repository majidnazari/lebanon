<?php
	class Geo extends CI_Model{
		

	function GetCountries($status='')
	{
		$this->db->select('tbl_countries.*');
		$this->db->from('tbl_countries');
		if($status!='')
		$this->db->where('tbl_countries.status',$status);
		$this->db->where('tbl_countries.id !=',0);
		$this->db->order_by('tbl_countries.label_en', 'ASC');
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
				
}