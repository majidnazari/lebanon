<?php
	class Client extends CI_Model{
	
	function getShowItemsClientStatus($client_id,$client_type)
	{
		$this->db->select('clients_status.*');
		$this->db->from('clients_status');
		$this->db->where('clients_status.client_id',$client_id);
		$this->db->where('clients_status.client_type',$client_type);
		$this->db->where('clients_status.status','active');
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		return $query->row();
	}	

	function GetClientById($id)
	{
		$this->db->select('training_companies.*');
		$this->db->select('countries.country as country');
		$this->db->select('countries.country_ar as country_ar');
		$this->db->select('cities.city as city');
		$this->db->select('cities.city_ar as city_ar');		
		$this->db->from('training_companies');
		$this->db->join('countries', 'countries.id = training_companies.country_id', 'inner');
		$this->db->join('cities', 'cities.id = training_companies.city_id', 'inner');		
		$this->db->where('training_companies.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}	
	function GetAllClients()
	{
		$this->db->select('training_companies.*');
		$this->db->from('training_companies');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}			
}