<?php
	class Settings extends CI_Model{
		

	function GetNavigations($group_id)
	{
		$this->db->select('navigations.*');	
		$this->db->from('navigations');
		$this->db->order_by("id", "asc");			
		$query = $this->db->get();
		return $query->result();
	}
	function GetNavigationsByIds($ids=array())
	{
		$this->db->select('navigations.*');	
		$this->db->from('navigations');
		$this->db->where_in('id', $ids);
		$this->db->order_by("id", "asc");			
		$query = $this->db->get();
		return $query->result();
	}	
	function GetGroupById($group_id)
	{
		$this->db->select('groups.*');
		$this->db->from('groups');			
		$this->db->where('groups.id',$group_id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	/***********************************************************************/



	function GetPage($id)
	{
		$this->db->select('groups.*');	
		$this->db->from('groups');			
		$this->db->where('groups.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function GetNavigationsData($array_group)
	{
		$this->db->select('navigations.*');	
		$this->db->from('navigations');	
		$this->db->where_in('group_id', $array_group);	
		//$this->db->where('navigations.group_id',$group_id);			
		$query = $this->db->get();
		return $query->result();
	}		
	function GetUserPrivileges($user_id)
	{
		$this->db->select('privilege.*');
		$this->db->from('privilege');			
		$this->db->where('privilege.user_id',$user_id);
		$query = $this->db->get();
		return $query->result();
	}
	function GetGroupPrivileges($user_id,$group_id)
	{
		$this->db->select('privilege.*');
		$this->db->from('privilege');			
		$this->db->where('privilege.user_id',$user_id);
		$this->db->where('privilege.group_id',$group_id);
		$query = $this->db->get();
		return $query->row_array();
	}
		function GetGroups($id)
	{
		$this->db->select('groups.*');
		$this->db->from('groups');
		$this->db->where('groups.id !='.$id);
		$query = $this->db->get();
		return $query->result();
	}	
}