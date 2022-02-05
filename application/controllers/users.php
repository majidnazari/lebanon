<?php

class Users extends Application
{
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('users'); // restrict this controller to admins only
		$this->load->model('Administrator');
		$this->data['p_delete']=$this->p_delete=$this->ag_auth->check_privilege(34,'delete');
		$this->data['p_edit']=$this->p_edit=$this->ag_auth->check_privilege(34,'edit');
		$this->data['p_add']=$this->p_add=$this->ag_auth->check_privilege(35,'add');
		$this->data['p_view']=$this->p_view=$this->ag_auth->check_privilege(34,'view');
		$this->data['Ctitle']='Industry';							
	}
	public function delete($id)
	{
		if((int)$id > 0){
			$this->General->delete('users',array('id'=>$id));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
			redirect('users');
		 } 
	}
	public function delete_checked()
	{
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				redirect('users');
    // No items checked
			}
		else {
    			foreach($delete_array as $d_id) {
				
				$this->General->delete('users',array('id'=>$d_id));
        // delete the item with the id $id
    		}
				$this->session->set_userdata(array('admin_message'=>'Deleted'));
				redirect('users');
		}
	}		
	public function index()
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Manage Users');	
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Administrator->GetAllUsers();
		$this->data['title'] = $this->data['Ctitle']." - Users List";
		$this->data['subtitle'] = "User management";
		$this->template->load('_template', 'users/users', $this->data);		
	}
public function groups()
	{

		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');	
		$this->data['done_msg']=$this->session->userdata('done_message');
		$this->session->unset_userdata('done_message');
		$this->data['error_msg']=$this->session->userdata('error_message');
		$this->session->unset_userdata('error_message');	
		$this->data['query']=$this->Administrator->GetAllGroups();
		$this->data['title'] = "Group management";
		$this->data['subtitle'] = "Group management";
		$this->template->load('_template', 'users/user_groups', $this->data);		
	}
public function group_create()
	{
				$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');	
		$this->data['done_msg']=$this->session->userdata('done_message');
		$this->session->unset_userdata('done_message');
		$this->data['error_msg']=$this->session->userdata('error_message');
		$this->session->unset_userdata('error_message');	
			$this->form_validation->set_rules('name', 'Group name', 'required|callback_field_exists');
			
			if ($this->form_validation->run()) {
				//echo "<pre>";
				//var_dump($_POST);
				//echo "</pre><br>";
				$permissions=$this->input->post('permissions');
				
				foreach($permissions as $key=>$value){
					//echo '<font color="#FF0000">'.$key.'</font>';
					$navs=$this->Administrator->GetPermissionById($key);
					//$parents=$this->Administrator->GetNavById($navs['parent_id']);
					//var_dump($parents);
					if(!array_key_exists($navs['parent_id'], $permissions))
						{
							$permissions[$navs['parent_id']] = array('view');
						}
					}
				//echo json_encode($permissions);

				$data=array(
					'name'=>set_value('name'),
					'permissions'=> json_encode($permissions),
					'create_time'=>  date('Y-m-d H:i:s'),
					'update_time'=>  date('Y-m-d H:i:s'),
					'user_id'=>$this->session->userdata('id'),
				
				);
				
				if($id=$this->General->save('groups',$data))
				{
					$this->session->set_userdata(array('done_message'=>'Group Added successfully'));	
					redirect('users/groups');
				}
				else
				{
					$this->session->set_userdata(array('error_message'=>'Error'));	
					redirect('users/create-group');					
				}
				
			 }
				$this->data['g_id'] = '';
				$this->data['name'] = '';
				$this->data['groups'] = array();
			$this->data['permissions'] = $this->Administrator->GetGroups();	
			$this->data['subtitle'] = 'Create New Group';
			$this->data['title'] = " Create New Group";
			$this->template->load('_template', 'users/group_form', $this->data);	
	}
public function group_edit($id)
	{
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');	
		$this->data['done_msg']=$this->session->userdata('done_message');
		$this->session->unset_userdata('done_message');
		$this->data['error_msg']=$this->session->userdata('error_message');
		$this->session->unset_userdata('error_message');	
			$this->form_validation->set_rules('name', 'Group name', 'required|callback_field_exists');
			
			if ($this->form_validation->run()) {
				//echo "<pre>";
				//var_dump($_POST);
				//echo "</pre><br>";
				$permissions=$this->input->post('permissions');
				foreach($permissions as $key=>$value){
					//echo '<font color="#FF0000">'.$key.'</font>';
					$navs=$this->Administrator->GetPermissionById($key);
					//$parents=$this->Administrator->GetNavById($navs['parent_id']);
					//var_dump($parents);
					if(!array_key_exists($navs['parent_id'], $permissions))
						{
							$permissions[$navs['parent_id']] = array('view');
						}
					}
				$data=array(
					'name'=>set_value('name'),
					'permissions'=> json_encode($permissions),
					'update_time'=>  date('Y-m-d H:i:s'),
					'user_id'=>$this->session->userdata('id'),
				
				);

				if($this->Administrator->edit('groups',$data,$id))
				{
					$this->session->set_userdata(array('done_message'=>'Group Updated successfully'));	
					redirect('users/groups');
				}
				else
				{
					$this->session->set_userdata(array('error_message'=>'Error'));	
					redirect('users/group-edit/'.$id);					
				}
				
			 }
			 $row = $this->General->GetGroupById($id);	
				$this->data['g_id'] = $id;
				$this->data['name'] = $row['name'];
				
			$this->data['groups'] = json_decode($row['permissions'],true);
			$this->data['permissions'] = $this->Administrator->GetGroups();	
			
			$this->data['subtitle'] = 'Edit Group';
			$this->data['title'] = "Edit Group";
			$this->template->load('_template', 'users/group_form', $this->data);	
	}
		
	public function details()
	{
		if(isset($_POST['save']))
		{

			$actions=$this->input->post('actions');
			$array_g=array();
			$user_id=$this->input->post('user_id');
			$this->General->delete('privilege',array('user_id'=>$user_id));
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
				$this->Administrator->save('privilege',$data);				
				array_push($array_g,$key);
				}
				$group=implode(',',$array_g);
				$array_data=array('group_id'=>$group);
				$this->Administrator->edit('users',$array_data,$user_id);
			//	die;
				redirect('users/details/id/'.$user_id);
			}
		$get = $this->uri->uri_to_assoc();
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['query']=$this->Administrator->GetUserById($get['id']);
		$this->data['privileges']=$this->General->GetUserPrivileges($get['id']);
		//var_dump($this->data['privileges']);
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
			$this->form_validation->set_rules('group_id', 'group', 'trim');		
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
				$group_id = set_value('group_id');
				$admin_id = $this->session->userdata('id');
				if($this->ag_auth->register($username, $password, $email, $fullname, $phone, $address, $admin_id, $status,$group_id) === TRUE)
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
				$this->data['group_id'] = '';
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
			$this->data['title'] = $this->data['Ctitle']." - Create New User";
			$this->data['groups']=$this->Administrator->GetAllGroups();
			$this->template->load('_template', 'users/user_form', $this->data);	
	}
	public function edit($id)
	{
			$this->form_validation->set_rules('fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('phone', 'phone', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('group_id', 'group', 'trim');	
			$this->form_validation->set_rules('status', 'status', 'trim');		

			if ($this->form_validation->run()) {
				
				$data = array(
				'fullname' => $this->form_validation->set_value('fullname'),
				'phone' => $this->form_validation->set_value('phone'),
				'address' => $this->form_validation->set_value('address'),
				'group_id' => $this->form_validation->set_value('group_id'),
				'status' => $this->form_validation->set_value('status'),
				'update_time' =>  date('Y-m-d H:i:s'),
			);
				if($this->Administrator->edit('users',$data,$id))
				{
					$this->session->set_userdata(array('admin_message'=>'User Updated successfully'));
					redirect('users');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('users/edit/'.$id);					
				}
				
			 }
			 	$row=$this->Administrator->GetUserById($id);
				$this->data['u_id'] = $row['id'];
				$this->data['username'] = $row['username'];
				$this->data['fullname'] = $row['fullname'];
				$this->data['phone'] = $row['phone'];
				$this->data['address'] = $row['address'];
				$this->data['email'] = $row['email'];
				$this->data['group_id'] = $row['group_id'];
				$this->data['status'] = $row['status'];
				$this->data['password_area']='';
				$this->data['groups']=$this->Administrator->GetAllGroups();
				$this->data['subtitle'] = 'Edit User';
				$this->data['readonly']=TRUE;
				$this->data['title'] = $this->data['Ctitle']." Edit User";
				$this->template->load('_template', 'users/user_form', $this->data);	
	}									
	public function change_password($id)
	{
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password_conf]');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|min_length[6]|matches[password]');
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');					
			if ($this->form_validation->run()) {

				$data = array(
				'password' => $this->ag_auth->salt(set_value('password')),
				'update_time' =>  date('Y-m-d'),
			);
				if($this->Administrator->edit('users',$data,$id))
				{
					$this->session->set_userdata(array('admin_message'=>'Password Change successfully'));
					redirect('users');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('users/changepassword/'.$id);					
				}
				
			 }
			 	$row=$this->Administrator->GetUserById($id);
				$this->data['u_id'] = $row['id'];
				$this->data['username'] = $row['username'];
				$this->data['email'] = $row['email'];
				$this->data['subtitle'] = 'Change Password';
				$this->data['title'] = $this->data['Ctitle']." - Change Password";
				$this->template->load('_template', 'users/change_password', $this->data);	
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