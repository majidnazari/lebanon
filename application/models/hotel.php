<?php
	class Hotel extends CI_Model{
		

	function GetHotels($status='')
	{
		$this->db->select('hotels.*');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->from('hotels');
		$this->db->join('countries', 'countries.id = hotels.country_id', 'inner');
		$this->db->join('cities', 'cities.id = hotels.city_id', 'inner');
		$this->db->where('hotels.id !=',0);
		$this->db->order_by('hotels.name', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function GetHotelById($id)
	{
		$this->db->select('hotels.*');
		$this->db->select('countries.country as country');
		$this->db->select('cities.city as city');
		$this->db->from('hotels');
		$this->db->join('countries', 'countries.id = hotels.country_id', 'inner');
		$this->db->join('cities', 'cities.id = hotels.city_id', 'inner');		
		$this->db->where('hotels.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function GetHotelsByCityId($id)
	{
		$this->db->select('hotels.*');
		$this->db->from('hotels');
		$this->db->where('hotels.city_id',$id);
		$query = $this->db->get();
		return $query->result();
	}		
				
}