<?php
class Application extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
				
		log_message('debug', 'Application Loaded');
        ini_set('memory_limit','2048M');
		$this->load->library(array('form_validation','user_agent', 'ag_auth', 'pagination','cart','session','breadcrumb','export','hijridate'));
		$this->load->helper(array('url', 'email', 'ag_auth','form'));
		$this->load->model(array('General','ag_auth_model','Client'));
		$this->config->load('ag_auth');
		$this->data['Gtitle']='Lebanon-industry.com دليل الصادرات والمؤسسات الصناعية اللبنانية';
		//$js='onclick="return confirmation();"';
		$this->data['js_confirm'] ='onclick="return confirmation();"';
                $datetime = new DateTime('now', new DateTimeZone('Asia/Beirut') );
		$this->datetime = ($datetime->format("Y-m-d H:i:s"));	
		//var_dump($this->session->all_userdata());
		//echo $this->session->userdata('id');
		$this->data['navigations']=$this->ag_auth->build_navigations($this->session->userdata('group_id'));
	//$this->build_navigations($this->session->userdata('group_id'),$this->session->userdata('roles_id'));
		$array1=array('edit'=>'Edit','delete'=>'Delete','view'=>'View','franchises'=>'Franchises','ports'=>'Ports');
		//$array1=array(1=>array('add'=>'Add New Company'),2=>array('add','edit','delete'),3=>array('add','edit','delete'));
		//var_dump($this->data['navigations']);
	//echo '<font color="#FF0000">'.json_encode($array1).'</font>';
	//echo "<pre>";
	//var_dump($this->session->userdata('privileges'));
	//	echo "</pre>";
		function _show_delete($url,$p){
			if($p==FALSE)
				$style='style="display:none"';
				else
				$style='';
			$js='onclick="return confirmation();"';
			return anchor($url, '<i class="isb-delete" '.$style.'></i>',$js);
			
			}
	
		function _show_delete_checked($url,$p){
			$array_js=array(
				'onclick' =>'return fn_submit();',
				'id' =>'tet',
				);
			if($p==FALSE)
				$array_js['style']="color:#FFF; margin-right:10px;display:none";
				else
				$array_js['style']="color:#FFF; margin-right:10px;";				
			return '<h2 style="float:right; color:#000 !important">'.anchor($url, 'Delete Checked',$array_js).'</h2>';
			
			}
		function _show_add($url,$label,$p){
			if($p==FALSE)
				$array_js['style']="color:#FFF; margin-right:10px;display:none";
				else
				$array_js['style']="color:#FFF; margin-right:10px;";				
			return '<h2 style="float:right; color:#000 !important">'.anchor($url, $label,$array_js).'</h2>';
			
			}				
		function _show_add_pop($url,$label,$p){
			if($p==FALSE)
				$array_js['style']="color:#FFF; margin-right:10px;display:none";
				else
				$array_js['style']="color:#FFF; margin-right:10px;";
				$array_js['data-toggle']='modal';				
			return '<h2 style="float:right; color:#000 !important">'.anchor($url, $label,$array_js).'</h2>';
			
			}				
	
		function _show_edit($url,$p){
			if($p==FALSE)
				$style='style="display:none"';
				else
				$style='';			
			return anchor($url, '<i class="isb-edit" '.$style.'></i>');
			
			}
		function _show_new($url,$p){
			if($p==FALSE)
				$style='style="display:none"';
				else
				$style='';			
			return anchor($url, '<i class="isb-plus" '.$style.'></i>');
			
			}	
		function _show_edit_pop($url,$p){
			if($p==FALSE)
				$style='style="display:none"';
				else
				$style='';			
			return anchor($url, '<i class="isb-edit" '.$style.'></i>',array( "data-toggle"=>"modal"));
			
			}

		function _show_settings($url){
			
			return anchor($url, '<i class="isb-settings"></i>');
			
			}		
	}

	public function _navigations($user_id)
	{
		$privileges=$this->General->GetUserPrivileges($user_id);
		$array_menu=array();
		
		foreach($privileges as $privilege)
		{
			$_nav=$this->General->GetNavigations($privilege->group_id);
			$array_sub=json_decode($_nav['sub_nav']);
			$array_actions=array();
			$array_actions=json_decode($privilege->actions,true);
			$submenu=array();
			$array2=array();
			if(count($array_actions)){
			foreach($array_actions as $key => $item)
			{
				foreach($array_sub as $sub_item)
				{
					if($key==$sub_item->id)
					{
						array_push($submenu,$sub_item);
						}
				}

				}
			}
				$array2=array('id'=>$_nav['id'],'label'=>$_nav['label'],'url'=>$_nav['url'],'icon'=>$_nav['icon'],'submenu'=>$submenu);
				array_push($array_menu,$array2);
				
			}	
		sort($array_menu);	
		return	$array_menu;	
		
	} // public function _navigations($group_string,$role_string)

	public function build_navigations($user_id)
	{
		$navigation='<ul class="navigation">';
		$array_nav=$this->_navigations($user_id);
		if (!empty($array_nav))
		{
			foreach($array_nav as $item)
			{
				if(!empty($item['submenu'])){
					
					$navigation.= '<li class="openable">'.
						anchor('','<span class="'.$item['icon'].'"></span><span class="text">'.$item['label'].'</span>').
						'<ul>';
							foreach($item['submenu'] as $sub)
							{
								$navigation.='<li>'.anchor($sub->url,'<span class="'.$sub->icon.'"></span>
									  <span class="text">'.$sub->label.'</span>').'</li>';	
								}
						$navigation.='</ul></li>';		

					}
				else{
					$navigation.= '<li>'.
						anchor($item['url'],'<span class="'.$item['icon'].'"></span><span class="text">'.$item['label'].'</span>').'</li>';										
					}
					
				}
		}
	$navigation.='</ul>';	
	return $navigation;	
	} // public function _navigations($group_string,$role_string)

	public function field_exists($value)
	{
		$field_name  = (valid_email($value)  ? 'email' : 'username');
		
		$user = $this->ag_auth->get_user($value, $field_name);
		
		if(array_key_exists('id', $user))
		{
			$this->form_validation->set_message('field_exists', 'The ' . $field_name . ' provided already exists, please use another.');
			
			return FALSE;
		}
		else
		{			
			return TRUE;
			
		} // if($this->field_exists($value) === TRUE)
		
	} // public function field_exists($value)
	function number_pad($number,$n) {
		return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
		}

	public function register()
	{
		if(!logged_in())
		{
		$this->form_validation->set_rules('phone', 'phone', 'trim');
		$this->form_validation->set_rules('role_id', 'Role', 'trim');
		$this->form_validation->set_rules('address', 'address', 'trim');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|callback_field_exists');
		$this->form_validation->set_rules('fullname', 'Full Name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password_conf]');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|min_length[6]|matches[password]');
		$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[6]|valid_email|callback_field_exists');

		if($this->form_validation->run() == FALSE)
		{
			$this->data['title'] = "Hyatt Consultancy - Register";
			$this->load->view('register', $this->data);
		}
		else
		{
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$email = set_value('email');
			$fullname = set_value('fullname');
			$phone = set_value('phone');
			$address = set_value('address');
			$group_id = set_value('role_id');;
			if($this->ag_auth->register($username, $password, $email, $fullname, $group_id, $phone, $address) === TRUE)
			{
				$this->data['message'] = "The user account has now been created.";
				$field_type  = (valid_email($username)  ? 'email' : 'username');
				$user_data = $this->ag_auth->get_user($username, $field_type);
				$this->data['username'] = $username;
				$this->data['user_id'] = $user_data['id'];
				$this->General->edit('users',array('agent_code'=>'HE'.$this->number_pad($user_data['id'],6)),$user_data['id']);
				unset($user_data['password']);
				$this->ag_auth->login_user($user_data);
				if($user_data['group_id']!=1){
					$this->template->load('_template','message', $this->data);
				}
				else{
					redirect('admin');
					}
				//$this->template->load('_template', 'employers/create', $this->data);	
			} // if($this->ag_auth->register($username, $password, $email) === TRUE)
			else
			{
				//$this->ag_auth->view('_message', $data);
			}

		} // if($this->form_validation->run() == FALSE)
		}
		else{
			redirect('home');
			}
		
	} // public function register()
	
	public function p403()
	{
		$this->load->view('403', $this->data);		
	}	
	public function message()
	{
		
			if (isset($_POST['submit'])) {
				if($this->session->userdata('group_id')==3)
				redirect('employers');
				elseif($this->session->userdata('group_id')==4)
				redirect('candidates/home');
			 	}
				$this->data['group'] = $this->session->userdata('group_id');
				$this->load->view('_message', $this->data);		
	}	
	
	public function login($redirect = NULL)
	{
		
		if($redirect === NULL)
		{
			$redirect = $this->ag_auth->config['auth_login'];
		}
		if($this->session->userdata('reset_message')!=''){
			$this->data['reset_message']=$this->session->userdata('reset_message');
			$this->session->unset_userdata('reset_message');
		}
		else{
			$this->data['reset_message']='';
			}
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		if($this->form_validation->run() == FALSE)
		{
				$this->data['title'] = "Lebanon Industry - Login";
				$this->load->view('login', $this->data);
		}
		else
		{
			
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$field_type  = (valid_email($username)  ? 'email' : 'username');
			
			$user_data = $this->ag_auth->get_user($username, $field_type);
			//var_dump($user_data );
			if(array_key_exists('password', $user_data) AND $user_data['password'] === $password)
			{

				unset($user_data['password']);
				
				$this->data['user_id'] = $user_data['id'];
				$user_privilege = $this->ag_auth->get_user_prevelige($user_data['id']);
				$permissions=$this->General->GetGroupById($user_data['group_id']);
				//$user_group = $this->ag_auth->_navigations($user_data['group_id']);
				
				$this->ag_auth->login_user($user_data);
				$this->ag_auth->login_user_privilege($permissions['permissions']);
			//	die;
				
				if (strpos($user_data['group_id'],',') !== false)
					$array_permissions=explode(',',$user_data['group_id']);
				else
					$array_permissions=array($user_data['group_id']);

				if(in_array(100,$array_permissions)){
					redirect('dashboard');	
					}
				else{
					$redirect_page=$this->General->GetPage(min($array_permissions));
					redirect('dashboard');	
					// redirect($redirect_page['page']);
					}	

			} // if($user_data['password'] === $password)
			else
			{
				$this->data['message'] = "The username and password did not match.";
				$this->data['reset_message'] = "The username and password did not match.";
				$this->data['title'] = "Lebanon Industry - Login";
				$this->load->view('login', $this->data);
			}
		} // if($this->form_validation->run() == FALSE)
		
	} // login()
	
	public function logout()
	{
		$this->ag_auth->logout();
	}

	public function _reset_password($email)
	{
		$password=substr(md5(microtime()),rand(0,26),8);
		$this->ag_auth_model->edit_password($email, $this->ag_auth->salt($password)); 
		$send=$this->_send_reset_email($email, $password);

		return $send;
	}
		
	public function _send_reset_email($email, $password)
	{
			$this->load->library('email');
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
			$message='<h3>New password for '.$email.'</h3>
					  <p>Dear client,<br />
					  Your new password is : '.$password.'<br /><br />
					  You can change your password at any time by logging into your account.<br /><br /><br /><br />
					  Thank you,<br />
					  Lobnani';
			$this->email->from('info@Lobnani.com', 'Lobnani');
			$this->email->to($email);
			$this->email->subject('New password for '.$email);
			$this->email->message($message);
			$v=$this->email->send();
			if(!$v)
			{
				$msg='Error with sending email';	
				}
			else{
				$msg='A new password has been sent.';
				}	
		return $msg;
	}
	
	
	public function lostpassword()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[6]|valid_email');
		if($this->form_validation->run() == FALSE)
		{
			$this->data['title'] = "Lobnani - Forget Password";
			$this->template->load('_template', 'lost_password', $this->data);
		}
		else
		{
			$email = set_value('email');
			if($this->ag_auth->field_exists($email) == TRUE)
			{
	
				$msgs = $this->_reset_password($email);
				$this->session->set_userdata(array('reset_message'=>$msgs));
				redirect('login');	
			}
			else{
				$this->session->set_userdata(array('reset_message'=>'This email address was not found in our records.'));
				redirect('login');	
				}
		} // if($this->form_validation->run() == FALSE)		
	}	
}

/* End of file: MY_Controller.php */
/* Location: application/core/MY_Controller.php */