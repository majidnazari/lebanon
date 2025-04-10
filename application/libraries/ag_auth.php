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

ob_start();

class AG_Auth
{
	var $CI; // The CI object
	var $config; // The config items
	
	
	/**
	* @author Adam Griffiths
	* @param array
	*
	* The constructor public function loads the libraries dependancies and creates the 
	* login attempts cookie if it does not already exist.
	*/
	public function __construct($config)
	{
		log_message('debug', 'Auth Library Loaded');

		$this->config = $config;

		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->helper('email');
		$this->CI->load->model('ag_auth_model');

		$this->CI->lang->load('ag_auth', 'english');
		
		if($this->logged_in() == FALSE)
		{
			if(!array_key_exists('login_attempts', $_COOKIE))
			{
				setcookie("login_attempts", 0, time()+900, '/');
			}
		}
		
	}
	
	
	/** 
	* Restricts access to a page
	*
	* Takes a user level (e.g. admin, user etc) and restricts access to that user and above.
	* Example, users can access a profile page, but so can admins (who are above users)
	*
	* @access public
	* @param string
	* @return bool
	*/
	public function restrict($group = array(), $single = NULL)
	{
		if(empty($group))
		{
			if($this->logged_in() == TRUE)
			{
				
				return TRUE;
			}
			else
			{
				show_error($this->CI->lang->line('insufficient_privs'));
			}
		}
		elseif($this->logged_in() == TRUE)
		{
			$level = $this->config['auth_groups'][$group];
			$group_id=$this->CI->session->userdata('group_id');
			$privileges=$this->get_user_group($group_id);
			$array_p=json_decode($privileges[0]->permissions,TRUE);
			//$array_user_level=explode(',',$string_user_level);
			//$user_level = $this->CI->session->userdata('group_id');
			if(!in_array($level,array_keys($array_p)))
			{
				
				show_error($this->CI->lang->line('insufficient_privs'));
			}
			return TRUE;
		}
		else
		{
			
			redirect($this->config['auth_incorrect_login'], 'refresh');
		}
	} // public function restrict()
	
	public function check_privilege($id, $action)
	{
		$permissions=$this->CI->session->userdata('permissions');
		$permissions_array=json_decode($permissions);
		foreach($permissions_array as $key=>$value)
		{
			if($key==$id)
			{
				if(in_array($action,$value))
				{
					return TRUE;
					}
				else{
					return FALSE;
					}	
				}
			
	}
	return FALSE;	 	
}
// public function restrict()	
	/**
	* @author Adam Griffiths
	* @return bool
	*
	* Checks the session data as to whether or not a user is logged in.
	*/
	public function logged_in()
	{
		if($this->CI->session->userdata('logged_in') === TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function field_exists($email)
	{
		if($this->CI->ag_auth_model->field_exists($email) === TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}	
	/**
	* @author Adam Griffiths
	* @param string
	* @return string
	*
	* Uses the encryption key set in application/config/config.php to salt the password passed.
	*/
	public function salt($password)
	{
		return hash("haval256,5", $this->CI->config->item('encryption_key') . $password);
	}
	
	
	/**
	* @author Adam Griffiths
	* @param string
	* @param string
	* @return string / bool
	*
	* Takes a username & optional username type (email/username) and returns the user data
	*/
	public function get_user($username, $field_type = 'username')
	{
		$user = $this->CI->ag_auth_model->login_check($username, $field_type);
		return $user;
	}
	public function get_user_prevelige($user_id)
	{
		$user = $this->CI->ag_auth_model->get_prevelige($user_id);
		//echo '<pre>';
		//var_dump($user);
		//echo '</pre>';
		return $user;
	}	

	public function get_user_group($id)
	{
		$user = $this->CI->ag_auth_model->get_group($id);
		
		return $user;
	}	
	
	public function _navigations($group_id)
	{
		$menu=array();
		
		$privileges=$this->get_user_group($group_id);
		if(count($privileges)>0)
		{
		$array_p=json_decode($privileges[0]->permissions,TRUE);
		$nav=$this->CI->ag_auth_model->GetNavigationsByIds(array_keys($array_p));
		//echo '<pre>';
		//var_dump($nav);
		//echo '</pre>';
		foreach($nav as $item){
			array_push($menu,array('id'=>$item->id,'label'=>$item->label,'url'=>$item->url,'parent_id'=>$item->parent_id,'icon'=>$item->icon,'permissions'=>$array_p[$item->id]));
			}
		}
		return $menu;
	} // public function _navigations($group_string,$role_string)

	public function build_navigations($group_id)
	{
		
		$control= $this->CI->router->class;
		$method=$this->CI->router->method ;
		$menu_data=$this->_navigations($group_id);
		$permissions_data=array();
		//if()
		$permissions_data=$this->CI->session->userdata('permissions_data');
		//var_dump($permissions_data);
		if(is_array($permissions_data) and count($permissions_data)<=0){
		$this->CI->session->set_userdata('permissions_data',$menu_data);
		}
	
		$navigation=' <ul class="navigation">';
		if (!empty($menu_data))
		{
			foreach($menu_data as $item)
			{
				$sub_tag_open='';
				$sub_tag_close='';
				$sub_item='';
				$_css='';
				if($item['parent_id']==0){
					$current=explode('/',$item['url']);

					if($current[0]==$control)
					$css='active';
					else
					$css='';
					
					for($i=0;$i<count($menu_data);$i++){
							
							if($menu_data[$i]['parent_id']==$item['id']){
								$_css='openable';
								$current_m=explode('/',$menu_data[$i]['url']);
								if(count($current_m)==1){
									$current_m[1]='index';
									}
									if($current_m[1]==$method)
									$css_m='active';
									else
									$css_m='';
								$sub_tag_open= '<ul>';
								$sub_item.='<li class="'.$css_m.'">'.anchor($menu_data[$i]['url'],'<span class="'.$menu_data[$i]['icon'].'"></span><span class="text">'.$menu_data[$i]['label'].'</span>').'</li>';
								$sub_tag_close='</ul>';
								}
								
						}
						$navigation.= '<li class="'.$css.' '.$_css.'">'.anchor($item['url'],'<span class="'.$item['icon'].'"></span><span class="text">'.$item['label'].'</span>');
						$navigation.=$sub_tag_open.$sub_item.$sub_tag_close.'</li>';
					}
					
				}
		}
	$navigation.='</ul>';
					
	return $navigation;	
	//*/
	//echo 'tst';
	} // public function _navigations($group_string,$role_string)

	/**
	* @author Adam Griffiths
	* @param string
	* @param string
	* @param string
	* @return bool
	*
	* Creates a new user account
	*/
	public function register($username, $password, $email, $fullname, $phone, $address, $admin_id, $status, $group_id)
	{
		return $this->CI->ag_auth_model->register($username, $password, $email, $fullname, $phone, $address, $admin_id, $status, $group_id);
	}
	
	
	/**
	* @author Adam Griffiths
	* @param array
	*
	* Takes the user array, adds the logged_in portion and sets the session data from that.
	*/
	public function login_user($user)
	{
		$user['logged_in'] = TRUE;
		
		$this->CI->session->set_userdata($user);
	}
	public function login_user_privilege($permissions)
	{	
		$this->CI->session->set_userdata('permissions', $permissions);
	}	
	
	
	/** 
	* Destroys the user session.
	*
	* @access public
	*/
	public function logout()
	{
		$this->CI->session->sess_destroy();
		redirect($this->CI->config->item('auth_logout'));
	}
		
	/** 
	* Generate a new token/identifier from random.org
	*
	* @author Adam Griffiths
	* @access private
	* @param string
	*/
	private  function _generate()
	{
		$username = $this->CI->session->userdata('username');
	
		// No love either way, generate a random string ourselves
		$length = 20;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$token = "";    
		
		for ($i = 0; $i < $length; $i++)
		{
			$token .= $characters[mt_rand(0, strlen($characters)-1)];
		}
	
		$identifier = $username . $token;
		$identifier = $this->_salt($identifier);

		$this->CI->db->query("UPDATE `$this->user_table` SET `identifier` = '$identifier', `token` = '$token' WHERE `username` = '$username'");

		setcookie("logged_in", $identifier, time()+3600, '/');
	  
	}
	
	
	/** 
	* Verify that a user has a cookie, if not generate one. If the cookie doesn't match the database, log the user out and show them an error.
	*
	* @access private
	* @param string
	*/
	private function _verify_cookie()
	{
		if((array_key_exists('login_attempts', $_COOKIE)) && ($_COOKIE['login_attempts'] <= 5))
		{
			$username = $this->CI->session->userdata('username');
			$userdata = $this->CI->db->query("SELECT * FROM `$this->user_table` WHERE `username` = '$username'");
			
			$result = $userdata->row();

			$identifier = $result->username . $result->token;
			$identifier = $this->_salt($identifier);
			
			if($identifier !== $_COOKIE['logged_in'])
			{
				$this->CI->session->sess_destroy();
				
				show_error($this->CI->lang->line('logout_perms_error'));
			}
		}
		else
		{
			$this->_generate();
		}
	}
	
	
	/** 
	* Load an auth specific view
	*
	* @access private
	* @param string
	*/
	public function view($page, $params = NULL)
	{
		if($params !== NULL)
		{
			$data['data'] = $params;
		}
		
		$data['page'] = $page;
		$this->CI->load->view($this->config['auth_views_root'].'index', $data);
	}
	
}

/* End of file: AG_Auth.php */
/* Location: application/libraries/AG_Auth.php */