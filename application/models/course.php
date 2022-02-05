<?php

	class Course extends CI_Model{

		



	function GetCourses()

	{

		$this->db->select('training_courses.*');

		$this->db->select('training_majors.title as major');

		$this->db->from('training_courses');

		$this->db->join('training_majors', 'training_majors.id = training_courses.major_id', 'inner');

		$this->db->where('training_courses.id !=',0);

		$this->db->order_by('code', 'ASC');

		$query = $this->db->get();

		return $query->result();

	}

	function GetCourseById($id)

	{

		$this->db->select('training_courses.*');

		$this->db->select('training_majors.title as major');

		$this->db->from('training_courses');

		$this->db->join('training_majors', 'training_majors.id = training_courses.major_id', 'inner');		

		$this->db->where('training_courses.id',$id);

		$query = $this->db->get();

		return $query->row_array();

	}	

	function GetAllMajors()

	{

		$this->db->select('training_majors.*');

		$this->db->from('training_majors');

		$this->db->order_by('title', 'ASC');

		$this->db->where('training_majors.id !=',0);

		$query = $this->db->get();

		return $query->result();

	}

	function GetMajorId($id)

	{

		$this->db->select('training_majors.*');

		$this->db->from('training_majors');

		$this->db->where('training_majors.id =',$id);

		$query = $this->db->get();

		return $query->row_array();

	}

					

}