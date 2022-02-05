<?php

class Sponsors extends Application
{
	var $sponsors='tbl_sponsors';

	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('banks'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Sponsor'));
			$this->load->helper(array('url', 'email','form'));
		$this->data['Ctitle']='Industry';
						
	}
	
	public function delete($id)
	{
		if((int)$id > 0){
			
			$this->General->delete($this->sponsors,array('id'=>$id));
			$this->session->set_userdata(array('admin_message'=>'Deleted'));
		redirect($this->agent->referrer());				
			
		 } 
	}


	public function delete_checked()
	{
			$delete_array=$this->input->post('checkbox1');
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
			}
		else {
				foreach($delete_array as $d_id) {
					$this->General->delete($this->sponsors,array('id'=>$d_id));
					}
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('sponsors/');
			}

	}
public function DisplaySponsors()
{
    $this->data['category']=$category=$this->input->post('category');
    $this->data['lang']=$lang=$this->input->post('lang');
    $_sponsors=$this->Sponsor->GetSponsors('',$lang,$category);
    $array_sponsors=array();
        foreach($_sponsors as $_sponsor)
        {
            $array_sponsors[$_sponsor->position]=$_sponsor;
        }
        $this->data['sponsors']=$array_sponsors;
    if($category=='gold'){
        $this->load->view('sponsors/_gold_sponsors_'.$lang,$this->data);
    }
    else{
        $this->load->view('sponsors/_silver_sponsors_'.$lang,$this->data);
    }
}
public function save()
{
    $id=$this->input->post('id');
   $array=$this->Administrator->do_upload('../sponsors/');
				
				if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path=$this->input->post('logo');
					}

				$msg=$array['error'];	
				$data = array(
				'title_en'=> $this->input->post('title_en'),
				'category'=> $this->input->post('category'),
				'position'=> $this->input->post('position'),
				'logo'	=>$path,
				'website'=> $this->input->post('website'),
				'status'=> $this->input->post('status'),
				'language'=> $this->input->post('language'),
				'section'=> $this->input->post('section'),
				'section_id'=> $this->input->post('section_id'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		
			if($id>0)
			{
			    $this->Administrator->edit($this->sponsors,$data,$id);
			    $this->session->set_userdata(array('admin_message'=>'Sponsor Updated successfully'));	
			}
			else{
			    $data['create_time']=date('Y-m-d H:i:s');
			    $this->General->save($this->sponsors,$data);
			    $this->session->set_userdata(array('admin_message'=>'Sponsor Added successfully'));	
			}
            redirect($this->agent->referrer());
}
public function gold()
	{

		$this->data['p_delete']=TRUE;
		$this->data['p_edit']=TRUE;
		$this->data['p_add']=TRUE;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Sponsors Company');
		$this->data['title'] = $this->data['Ctitle']." - Sponsors - المؤسسات الراعية";;
		$this->data['subtitle'] = "Sponsors - المؤسسات الراعية";;
		$this->template->load('_template', 'sponsors/gold', $this->data);		
	}
	public function silver()
	{

		$this->data['p_delete']=TRUE;
		$this->data['p_edit']=TRUE;
		$this->data['p_add']=TRUE;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Sponsors Company');
		$this->data['title'] = $this->data['Ctitle']." - Sponsors - المؤسسات الراعية";;
		$this->data['subtitle'] = "Sponsors - المؤسسات الراعية";;
		$this->template->load('_template', 'sponsors/silver', $this->data);		
	}
	public function index()
	{
	/*	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
		*/
		$this->data['p_delete']=TRUE;
		$this->data['p_edit']=TRUE;
		$this->data['p_add']=TRUE;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Sponsors Company');
		$this->data['title'] = $this->data['Ctitle']." - Sponsors - المؤسسات الراعية";;
		$this->data['subtitle'] = "Sponsors - المؤسسات الراعية";;
		$this->data['query']=$this->Sponsor->GetSponsors('');
		$this->template->load('_template', 'sponsors', $this->data);		
	}
	
	public function details($id)
	{
	/*	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
		*/
		$query=$this->Company->GetCompanyById($id);
		$this->data['query']=$query;
	
		$this->data['p_delete']=TRUE;
		$this->data['p_edit']=TRUE;
		$this->data['p_add']=TRUE;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb('Companies');
		$this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";;
		$this->data['subtitle'] = "Companies - الشركات";
		$this->data['sectors']=$this->Item->GetSector('online',0,0);
		$this->data['sections']=$this->Item->GetSection('online',0,0);
		$this->data['governorates']=$this->Address->GetGovernorateById($query['governorate_id']);
		$this->data['districts']=$this->Address->GetDistrictById($query['district_id']);
		$this->data['area']=$this->Address->GetAreaById($query['are_code_office']);
		$this->data['items']=$this->Company->GetProductionInfo($id);
		$this->template->load('_template', 'company/details', $this->data);		
	}
	
	public function create()
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Sponsors','sponsors');
			$this->breadcrumb->add_crumb('Add New Sponsor');
					
			$this->form_validation->set_rules('title_en', 'Sponsor name in english', 'required');
			$this->form_validation->set_rules('website', 'website', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');
			

		if ($this->form_validation->run()) {
			
				$array=$this->Administrator->do_upload('../sponsors/');
				
				if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path=$this->input->post('logo');
					}

				$msg=$array['error'];	
				$data = array(
				'title_en'=> $this->form_validation->set_value('title_en'),
				'position'=> $this->input->post('position'),
				'logo'	=>$path,
				'website'=> $this->form_validation->set_value('website'),
				'status'=> $this->form_validation->set_value('status'),
				'language'=> $this->input->post('language'),
				'section'=> $this->input->post('section'),
				'section_id'=> $this->input->post('section_id'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->General->save($this->sponsors,$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Sponsor Added successfully'));	
					redirect('sponsors');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('sponsors/create');					
				}
				
			 }
				$this->data['s_id'] = '';
				$this->data['title_en'] = array('id'=>'title_en','name'=>'title_en');
				$this->data['website'] = array('id'=>'website','name'=>'website');
				$this->data['status'] = '';
				$this->data['position'] = '';
				$this->data['logo'] = '';
				$this->data['subtitle'] = 'Add New Sponsor';
				$this->data['title'] = $this->data['Ctitle']."- Add New Sponsor";
				$this->template->load('_template', 'sponsor_form', $this->data);	
	}
	
	public function edit($id)
	{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Sponsors','sponsors');
			$this->breadcrumb->add_crumb('Edit Sponsor');
					
			$this->form_validation->set_rules('title_en', 'Sponsor name in english', 'required');
			$this->form_validation->set_rules('website', 'website', 'trim');
			$this->form_validation->set_rules('status', 'status', 'trim');

			if ($this->form_validation->run()) {
			
				$array=$this->Administrator->do_upload('../sponsors/');
				
				if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path=$this->input->post('logo');
					}

				$msg=$array['error'];	
				$data = array(
				'title_en'=> $this->form_validation->set_value('title_en'),
				'position'=> $this->input->post('position'),
				'logo'	=>$path,
				'website'=> $this->form_validation->set_value('website'),
				'status'=> $this->form_validation->set_value('status'),
				'language'=> $this->input->post('language'),
				'section'=> $this->input->post('section'),
				'section_id'=> $this->input->post('section_id'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($id=$this->Administrator->edit($this->sponsors,$data,$id))
				{
					$this->session->set_userdata(array('admin_message'=>'Sponsor Updated successfully'));	
					redirect('sponsors');
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('sponsors/edit/'.$id);					
				}
				
			 }
			 	$row=$this->Sponsor->GetSponsorById($id);
				$this->data['s_id'] = '';
				$this->data['title_en'] = array('id'=>'title_en','name'=>'title_en','value'=>$row['title_en']);
				$this->data['website'] = array('id'=>'website','name'=>'website','value'=>$row['website']);
				$this->data['status'] = $row['status'];
				$this->data['position'] = $row['position'];
				$this->data['language'] = $row['language'];
				$this->data['section'] = $row['section'];
				$this->data['section_id'] = $row['section_id'];
				
				$this->data['logo'] = $row['logo'];
				$this->data['subtitle'] = 'Edit Sposor';
				$this->data['title'] = $this->data['Ctitle']."- Edit Sponsor";
				$this->template->load('_template', 'sponsor_form', $this->data);		
	}
	public function power($id,$item_id='')
	{
		
	/*	$p_delete=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'delete');
		$p_edit=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,17,'edit');
		$p_add=$this->ag_auth->check_privilege($this->session->userdata('privileges'),6,16,'add');
		*/
			$query=$this->Company->GetCompanyById($id);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Companies','companies');
			$this->breadcrumb->add_crumb($query['name_en'],'companies/details/'.$id);
			$this->breadcrumb->add_crumb('Electric Power','companies/power/'.$id);
					
			$this->form_validation->set_rules('fuel', 'fuel', 'required');
			$this->form_validation->set_rules('diesel', 'diesel', 'required');	
		if ($this->form_validation->run()) {
				if($_POST['action']=='add'){
				$data = array(
				'company_id'=> $id,
				'fuel'=> $this->form_validation->set_value('fuel'),
				'diesel'=> $this->form_validation->set_value('diesel'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($this->General->save($this->company_power,$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Electric Power Item Added successfully'));	
					redirect('companies/power/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('companies/power/'.$id.'/'.$item_id);					
				}
				}
			else{
				$data = array(
				'company_id'=> $id,
				'fuel'=> $this->form_validation->set_value('fuel'),
				'diesel'=> $this->form_validation->set_value('diesel'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($this->Administrator->edit($this->company_power,$data,$item_id))
				{
					$this->session->set_userdata(array('admin_message'=>'Electric Power Item Updated successfully'));	
					redirect('companies/power/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('companies/power/'.$id.'/'.$item_id);					
				}
				}	
			 }		
		if($item_id==''){
				
			$this->data['subtitle'] = 'Add';
			$this->data['action'] = 'add';
			$this->data['display']='';
			$fuel='';
			$diesel='';
			
			}
		else{
			
			$row=$this->Company->GetCompanyElectricPowerById($item_id);
		
			$this->data['subtitle'] = 'Edit';
			$this->data['action'] = 'edit';
			$this->data['display']=$row['fuel'].'<br><hr />'.$row['diesel'];
			$fuel=$row['fuel'];
			$diesel=$row['diesel'];
			}	
		$this->data['c_id'] = $id;
				
		$this->data['fuel'] = $fuel;
		$this->data['diesel'] = $diesel;	
		$this->data['query']=$query;
	
		$this->data['p_delete']=TRUE;
		$this->data['p_edit']=TRUE;
		$this->data['p_add']=TRUE;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['items']=$this->Company->GetCompanyElectricPowers($id);
		$this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
		$this->template->load('_template', 'company/electric_power', $this->data);		
	}	
	
											
}

?>