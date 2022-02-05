<?php
	class Sponsor extends CI_Model{
	var $sponsors='tbl_sponsors';
		
	function GetSponsors($status='',$lang='',$category='')
	{
		$this->db->select($this->sponsors.'.*');
		$this->db->from($this->sponsors);
		if($status!='')
		$this->db->where($this->sponsors.'.status',$status);
		if($lang!=''){
        $this->db->where('tbl_sponsors.language', $lang);
        }
        if($lang!=''){
        $this->db->where('tbl_sponsors.category', $category);
        }
		$this->db->order_by($this->sponsors.'.title_en', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function GetSponsorById($id)
	{
		$this->db->select($this->sponsors.'.*');
		$this->db->from($this->sponsors);	
		$this->db->where($this->sponsors.'.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
				
}