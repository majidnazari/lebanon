<?php

class Settings extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('settings'); // restrict this controller to admins only
		$this->load->model('Administrator');
		$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
		$this->data['p_delete']=$p_delete;
		$this->data['p_edit']=$p_edit;
		$this->data['p_add']=$p_add;							
	}
	public function delete()
	{
		$get = $this->uri->uri_to_assoc();
		if((int)$get['id'] > 0){
			$this->General->delete('users',array('id'=>$get['id']));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('users');
		 } 
	}	
	public function index()
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Change Password');	
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password_conf]');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|min_length[6]|matches[password]');			
			if ($this->form_validation->run()) {
				
			$data = array(
				'password' => $this->ag_auth->salt(set_value('password')),
				'update_time' =>  date('Y-m-d'),
			);
				if($this->Administrator->edit('users',$data,$this->session->userdata('id')))
				{
					$this->session->set_userdata(array('admin_message'=>'Password Change successfully'));
					redirect('settings');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('settings');					
				}
				
			 }
			 	$row=$this->Administrator->GetUserById($this->session->userdata('id'));
				$this->data['u_id'] = $this->session->userdata('id');
				$this->data['username'] = $row['username'];
				$this->data['email'] = $row['email'];
				$this->data['subtitle'] = 'Change Password';
				$this->data['msg']=$this->session->userdata('admin_message');
				$this->session->unset_userdata('admin_message');	
				$this->data['title'] = "Inma Training System - Change Password";
				$this->template->load('_template', 'change_password', $this->data);	

	}
	public function details()
	{
		if(isset($_POST['save']))
		{
		//	echo "<pre>";
		//	var_dump($_POST['actions']);
		//	echo "</pre>";
			$actions=$this->input->post('actions');
			$array_g=array();
			$user_id=$this->input->post('user_id');
			foreach($actions as $key=>$value)
			{
				$data = array(
				'user_id' => $user_id,
				'group_id' => $key,
				'actions' => json_encode($value),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'admin_id' =>  $this->session->userdata('id'),
			);
				$row=$this->General->GetGroupPrivileges($user_id,$key);
				if(count($row)>0)
				{
					$this->Administrator->edit('privilege',$data,$row['id']);	
					}
				else{
					$this->Administrator->save('privilege',$data);	
					}					
				
				array_push($array_g,$key);
				}
				$group=implode(',',$array_g);
				$array_data=array('group_id'=>$group);
				$this->Administrator->edit('users',$array_data,$user_id);
			}
		$get = $this->uri->uri_to_assoc();
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Administrator->GetUserById($get['id']);
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Manage Users','users');
		$this->breadcrumb->add_crumb($this->data['query']['username']);			
		$this->data['title'] = "Inma Kingdom Training System  - User Info";
		$this->data['groups'] = $this->Administrator->GetGroups();
		$this->template->load('_template', 'details', $this->data);		
	}	
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Manage Users','users');
			$this->breadcrumb->add_crumb('Create New User');	
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|callback_field_exists');
			$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[6]|valid_email|callback_field_exists');
			$this->form_validation->set_rules('fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('phone', 'phone', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');		
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password_conf]');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|min_length[6]|matches[password]');
			
			if ($this->form_validation->run()) {

				$username = set_value('username');
				$password = $this->ag_auth->salt(set_value('password'));
				$email = set_value('email');
				$fullname = set_value('fullname');
				$phone = set_value('phone');
				$address = set_value('address');
				$status = set_value('status');
				$admin_id = $this->session->userdata('id');
				if($this->ag_auth->register($username, $password, $email, $fullname, $phone, $address, $admin_id, $status) === TRUE)
				{
					$this->session->set_userdata(array('admin_message'=>'User Added successfully'));	
					redirect('users');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('users/create');					
				}
				
			 }
				$this->data['u_id'] = '';
				$this->data['username'] = '';
				$this->data['fullname'] = '';
				$this->data['phone'] = '';
				$this->data['address'] = '';
				$this->data['email'] = '';
				$this->data['status'] = '';
				$this->data['admin_id'] = '';
				$conf_password = array(
						'name'	=> 'password_conf',
						'id'	=> 'password_conf',
						'class'	=> 'validate[required,minSize[6]]',
					);
				$password = array(
							'name'	=> 'password',
							'id'	=> 'password',
							'class'	=> 'validate[required,minSize[6]]',
						);
				$this->data['password_area']='<div class="row-form clearfix">
                        <div class="span3">Password:</div>
                        <div class="span4">'.form_password($password).'
                        <font color="#FF0000">'.form_error('password').'</font>
                        </div>                            
                    </div> 

                    <div class="row-form clearfix">
                        <div class="span3">Retype Password:</div>
                        <div class="span4">'.form_password($conf_password).'
						<font color="#FF0000">'.form_error('conf_password').'</font>
                        </div>
                    </div> ';
			$this->data['subtitle'] = 'Create New User';
			$this->data['title'] = "Inma Kingdom Training System - Create New";
			$this->template->load('_template', 'user_form', $this->data);	
	}
	public function edit()
	{
			$get = $this->uri->uri_to_assoc();
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
			$this->form_validation->set_rules('fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('phone', 'phone', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('group_id', 'group', 'trim');		
			$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[6]|valid_email');

			if ($this->form_validation->run()) {
				
				$data = array(
				'username' => $this->form_validation->set_value('username'),
				'email' => $this->form_validation->set_value('email'),
				'fullname' => $this->form_validation->set_value('fullname'),
				'phone' => $this->form_validation->set_value('phone'),
				'address' => $this->form_validation->set_value('address'),
				'group_id' => $this->form_validation->set_value('group_id'),
				'update_time' =>  date('Y-m-d H:i:s'),
			);
				if($this->Administrator->edit('users',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'User Updated successfully'));
					redirect('users/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('users/edit/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Administrator->GetUserById($get['id']);
				$this->data['u_id'] = $row['id'];
				$this->data['username'] = $row['username'];
				$this->data['fullname'] = $row['fullname'];
				$this->data['phone'] = $row['phone'];
				$this->data['address'] = $row['address'];
				$this->data['email'] = $row['email'];
				$this->data['group_id'] = $row['group_id'];
				$this->data['password_area']='';
				//$this->data['employer_id'] = $row['employer_id'];
				$this->data['subtitle'] = 'Edit User';
				$this->data['title'] = "Survey SAS - Edit User";
				$this->template->load('_template', 'user_form', $this->data);	
	}									
	public function change_password()
	{
			$get = $this->uri->uri_to_assoc();
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password_conf]');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|min_length[6]|matches[password]');			
			if ($this->form_validation->run()) {

				$data = array(
				'password' => $this->ag_auth->salt(set_value('password')),
				'update_time' =>  date('Y-m-d H:i:s'),
			);
				if($this->Administrator->edit('users',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Password Change successfully'));
					redirect('users/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('users/changepassword/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Administrator->GetUserById($get['id']);
				$this->data['u_id'] = $row['id'];
				$this->data['username'] = $row['username'];
				$this->data['email'] = $row['email'];
				$this->data['subtitle'] = 'Change Password';
				$this->data['title'] = "Survey SAS - Change Password";
				$this->template->load('_template', 'change_password', $this->data);	
	}
	public function status()
	{
			$get = $this->uri->uri_to_assoc();
			$this->form_validation->set_rules('status', 'status', 'trim');			
			if ($this->form_validation->run()) {

				$data = array(
				'status' => set_value('status'),
				'update_time' =>  date('Y-m-d H:i:s'),
			);
				if($this->Administrator->edit('users',$data,$get['id']))
				{
					$this->session->set_userdata(array('admin_message'=>'Status Changed successfully'));
					redirect('users/details/id/'.$get['id']);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('users/status/id/'.$get['id']);					
				}
				
			 }
			 	$row=$this->Administrator->GetUserById($get['id']);
				$this->data['u_id'] = $row['id'];
				$this->data['username'] = $row['username'];
				$this->data['email'] = $row['email'];
				$this->data['status'] = $row['status'];
				$this->data['subtitle'] = 'Change Status';
				$this->data['title'] = "Survey SAS - Change Status";
				$this->template->load('_template', 'change_status', $this->data);	
	}											

}

?>