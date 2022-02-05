<?php

	class Provider extends CI_Model{

		



	function GetProviders()

	{

		$this->db->select('training_providers.*');

		$this->db->from('training_providers');

		$this->db->where('training_providers.id !=',0);

		$this->db->order_by('id', 'DESC');

		$query = $this->db->get();

		return $query->result();

	}

	function GetProviderById($id)

	{

		$this->db->select('training_providers.*');

		$this->db->from('training_providers');	

		$this->db->where('training_providers.id',$id);

		$query = $this->db->get();

		return $query->row_array();

	}	

	function GetAllInstructors()

	{

		$this->db->select('training_instructors.*');

		$this->db->select('training_providers.title as provider');

		$this->db->from('training_instructors');

		$this->db->join('training_providers', 'training_providers.id = training_instructors.provider_id', 'inner');

		$this->db->where('training_instructors.id !=',0);

		$this->db->order_by('training_instructors.fullname', 'ASC');

		$query = $this->db->get();

		return $query->result();

	}

	function GetInstructorId($id)

	{

		$this->db->select('training_instructors.*');

		$this->db->select('training_providers.title as provider');

		$this->db->from('training_instructors');

		$this->db->join('training_providers', 'training_providers.id = training_instructors.provider_id', 'inner');	

		$this->db->where('training_instructors.id =',$id);

		$query = $this->db->get();

		return $query->row_array();

	}

	function GetInstructorByProviderId($provider_id)

	{

		$this->db->select('training_instructors.*');

		$this->db->from('training_instructors');

		$this->db->where('training_instructors.provider_id =',$provider_id);

		$query = $this->db->get();

		return $query->result();

	}					

}