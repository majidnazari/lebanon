<?php
/**
* Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://adamgriffiths.co.uk
* @version 2.0.3
* @copyright Adam Griffiths 2011
*
* Auth provides a powerful, lightweight and simple interface for user authentication .
*/

class AG_Auth_model extends CI_Model
{
	var $user_table; // The user table (prefix + config)
	var $group_table; // The group table (prefix + config)
	
	public function __construct()
	{
		parent::__construct();

		log_message('debug', 'Auth Model Loaded');
		
		$this->config->load('ag_auth');
		$this->load->database();

		$this->user_table = $this->config->item('auth_user_table');
		$this->group_table = $this->config->item('auth_group_table');
	}
	
	public function login_check($username, $field_type)
	{
		$query = $this->db->get_where($this->user_table, array($field_type => $username,'status' => 'online'));
		$result = $query->row_array();
		
		return $result;
	}
	public function get_prevelige($user_id)
	{
		$query = $this->db->get_where('privilege', array('user_id' => $user_id));
		$result = $query->result();
		
		return $result;
	}	
	
	public function register($username, $password, $email, $fullname, $phone, $address, $admin_id, $status)
	{
	if($this->db->set('username', $username)->set('password', $password)->set('email', $email)->set('fullname', $fullname)->set('phone',$phone)->set('address',$address)->set('admin_id', $admin_id)->set('status', $status)->set('create_time',date('Y-m-d'))->set('update_time',date('Y-m-d'))->insert($this->user_table))
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function field_exists($value)
	{
		
		$field_name = (valid_email($value)  ? 'email' : 'username');
		
		$query = $this->db->get_where($this->user_table, array($field_name => $value));
		
		if($query->num_rows() <> 0)
		{
			return FALSE;
		}
		
		return TRUE;
	}
	public function edit_password($email,$password){
		$this->db->where('email', $email);
        $this->db->update('users', array('password'=>$password));   
	}
}

/* End of file: ag_auth_model.php */
/* Location: application/models/auth_model.php */