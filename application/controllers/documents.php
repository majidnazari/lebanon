<?php

class Documents extends Application
{
	var $company='tbl_company';
	var $company_heading='tbl_company_heading';
	var $company_banks='tbl_banks_company';
	var $company_insurance='tbl_insurances_company';
	var $company_markets='tbl_markets_company';
	var $position='tbl_positions';
	var $company_power='tbl_power_company';
	var $p_delete=FALSE;
	var $p_edit=FALSE;
	var $p_add=FALSE;
	var $p_production=FALSE;
	var $p_export=FALSE;
	var $p_insurance=FALSE;
	var $p_banks=FALSE;
	var $p_power=FALSE;
	
	var $page_denied='';
	
	public function __construct()
	{

		parent::__construct();
		//$this->ag_auth->restrict('document'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Item','Address','Company','Bank','Insurance','Parameter','Transport','Importer'));
		$this->data['Ctitle']='Industry';
		/*
		$this->p_delete=$this->ag_auth->check_privilege(4,'delete');
		$this->p_edit=$this->ag_auth->check_privilege(4,'edit');
		$this->p_production=$this->ag_auth->check_privilege(4,'production');
		$this->p_export=$this->ag_auth->check_privilege(4,'export');
		$this->p_insurance=$this->ag_auth->check_privilege(4,'insurance');
		$this->p_banks=$this->ag_auth->check_privilege(4,'banks');
		$this->p_power=$this->ag_auth->check_privilege(4,'power');
		$this->p_add=$this->ag_auth->check_privilege(3,'add');
		$this->data['p_delete']=$this->p_delete;
		$this->data['p_edit']=$this->p_edit;
		$this->data['p_add']=$this->p_add;
		$this->data['p_production']=$this->p_production;
		$this->data['p_export']=$this->p_export;
		$this->data['p_insurance']=$this->p_insurance;
		$this->data['p_banks']=$this->p_banks;
		$this->data['p_power']=$this->p_power;
		*/
		
						
	}
		
	public function delete($id,$company,$type)
	{
		if((int)$id > 0){
			
					$this->General->delete('documents',array('id'=>$id));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('documents/index/'.$company.'/'.$type);	

		 } 
	}


	public function delete_checked()
	{
		
		$delete_array=$this->input->post('checkbox1');
		//var_dump()
			if(empty($delete_array)) {
				$this->session->set_userdata(array('admin_message'=>'No Item Checked'));
				
			//if(isset($this->input->post('p')))
	
    		
				
				//redirect($_SEREVER['']);
    // No items checked
			}
		else {
			//if(isset($this->input->post('p')))
			switch($this->input->post('p'))
			{
				case 'company':
				if($this->p_delete){
				foreach($delete_array as $d_id) {
					$this->General->delete($this->company,array('id'=>$d_id));
					}
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('companies/'.$get['st']);
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect('companies');	
					}		
				break;
				
				case 'sector':
					foreach($delete_array as $d_id) {
					$this->General->delete($this->sector,array('id'=>$d_id));
					}
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/items/sector/'.$get['st']);			
				break;
				
				case 'section':
					foreach($delete_array as $d_id) {
					$this->General->delete($this->section,array('id'=>$d_id));
					}
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/items/section/'.$get['st']);				
				break;
				case 'chapter':
					foreach($delete_array as $d_id) {
					$this->General->delete($this->chapter,array('id'=>$d_id));
					}
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/items/chapter/'.$get['st']);				
				break;
				
				case 'position':
				foreach($delete_array as $d_id) {
					$this->General->delete($this->position,array('id'=>$d_id));
					}
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/items/position/'.$get['st']);
				
				break;

				}

    		}
		

	}
	
	public function index($itemid,$type)
	{
		$query=$this->Administrator->GetDocumentsByItemId($itemid,$type);
		$this->data['query']=$query;
		
		switch($type)
			{
				case 'company':
					$row=$this->Company->GetCompanyById($itemid);
					$subtitle=$row['name_ar'];	
					$controller='companies';
					$nav='company/_navigation';
					$this->data['p_delete']=$this->p_delete=$this->ag_auth->check_privilege(4,'delete');
					$this->data['p_edit']=$this->p_edit=$this->ag_auth->check_privilege(4,'edit');
					$this->data['p_production']=$this->p_production=$this->ag_auth->check_privilege(4,'production');
					$this->data['p_export']=$this->p_export=$this->ag_auth->check_privilege(4,'export');
					$this->data['p_insurance']=$this->p_insurance=$this->ag_auth->check_privilege(4,'insurance');
					$this->data['p_banks']=$this->p_banks=$this->ag_auth->check_privilege(4,'banks');
					$this->data['p_power']=$this->p_power=$this->ag_auth->check_privilege(4,'power');
					$this->data['p_add']=$this->p_add=$this->ag_auth->check_privilege(3,'add');
                    $this->data['p_app']=$this->p_app = $this->ag_auth->check_privilege(4, 'app');
				break;
				case 'bank':
					$row=$this->Bank->GetBankById($itemid);
					$subtitle=$row['name_ar'];	
					$controller='banks';
					$nav='banks/_navigation';
					$this->data['p_delete']=$this->p_delete=$this->ag_auth->check_privilege(8,'delete');
					$this->data['p_edit']=$this->p_edit=$this->ag_auth->check_privilege(8,'edit');
					$this->data['p_branches']=$this->p_branches=$this->ag_auth->check_privilege(8,'branches');
					$this->data['p_branch_add']=$this->p_branch_add=$this->ag_auth->check_privilege(8,'branch_add');
					$this->data['p_branch_edit']=$this->p_branch_edit=$this->ag_auth->check_privilege(8,'branch_edit');
					$this->data['p_branch_delete']=$this->p_branch_delete=$this->ag_auth->check_privilege(8,'branch_delete');
					$this->data['p_directors']=$this->p_directors=$this->ag_auth->check_privilege(8,'directors');
					$this->data['p_add']=$this->p_add=$this->ag_auth->check_privilege(7,'add');
				break;
				case 'insurance':
					$row=$this->Insurance->GetInsuranceById($itemid);
					$subtitle=$row['name_ar'];	
					$controller='insurances';
					$nav='insurance/_navigation';
							$this->p_add=$this->ag_auth->check_privilege(11,'add');
							$this->p_delete=$this->ag_auth->check_privilege(12,'delete');
							$this->p_edit=$this->ag_auth->check_privilege(12,'edit');
							
							$this->p_directors=$this->ag_auth->check_privilege(12,'directors');
							$this->p_directors_add=$this->ag_auth->check_privilege(12,'directors_add');
							$this->p_directors_edit=$this->ag_auth->check_privilege(12,'directors_edit');
							$this->p_directors_delete=$this->ag_auth->check_privilege(12,'directors_delete');
							
							$this->p_branches=$this->ag_auth->check_privilege(12,'branches');
							$this->p_branches_add=$this->ag_auth->check_privilege(12,'branches_add');
							$this->p_branches_edit=$this->ag_auth->check_privilege(12,'branches_edit');
							$this->p_branches_delete=$this->ag_auth->check_privilege(12,'branches_delete');
							
							$this->p_executive=$this->ag_auth->check_privilege(12,'executive');
							$this->p_executive_add=$this->ag_auth->check_privilege(12,'executive_add');
							$this->p_executive_edit=$this->ag_auth->check_privilege(12,'executive_edit');
							$this->p_executive_delete=$this->ag_auth->check_privilege(12,'executive_delete');
							
							$this->data['p_delete']=$this->p_delete;
							$this->data['p_edit']=$this->p_edit;
							$this->data['p_add']=$this->p_add;
							
							$this->data['p_directors']=$this->p_directors;
							$this->data['p_directors_add']=$this->p_directors_add;
							$this->data['p_directors_edit']=$this->p_directors_edit;
							$this->data['p_directors_delete']=$this->p_directors_delete;
							
							$this->data['p_branches']=$this->p_branches;
							$this->data['p_branches_add']=$this->p_branches_add;
							$this->data['p_branches_edit']=$this->p_branches_edit;
							$this->data['p_branches_delete']=$this->p_branches_delete;
							
							$this->data['p_executive']=$this->p_executive;
							$this->data['p_executive_add']=$this->p_executive_add;
							$this->data['p_executive_edit']=$this->p_executive_edit;
							$this->data['p_executive_delete']=$this->p_executive_delete;

				break;
				case 'importer':
					$this->p_view=$this->ag_auth->check_privilege(14,'view');
					$this->p_delete=$this->ag_auth->check_privilege(14,'delete');
					$this->p_edit=$this->ag_auth->check_privilege(14,'edit');
					$this->p_foreign_companies=$this->ag_auth->check_privilege(14,'foreign_companies');
					$this->p_add=$this->ag_auth->check_privilege(16,'add');
					$this->data['p_delete']=$this->p_delete;
					$this->data['p_edit']=$this->p_edit;
					$this->data['p_add']=$this->p_add;
					$this->data['p_view']=$this->p_view;
					$this->data['p_foreign_companies']=$this->p_foreign_companies;
					$row=$this->Importer->GetImporterById($itemid);
					$subtitle=$row['name_ar'];	
					$controller='importers';
					$nav='importer/_navigation';
				break;
				case 'transportation':
					$row=$this->Transport->GetTransportationById($itemid);
					$this->data['p_delete']=$this->p_delete=$this->ag_auth->check_privilege(18,'delete');
					$this->data['p_edit']=$this->p_edit=$this->ag_auth->check_privilege(18,'edit');
					$this->data['p_add']=$this->p_add=$this->ag_auth->check_privilege(19,'add');
					$this->data['p_view']=$this->p_view=$this->ag_auth->check_privilege(18,'view');
					
					$this->data['p_edit_branch']=$this->p_edit_branch=$this->ag_auth->check_privilege(18,'branch_edit');
					$this->data['p_add_branch']=$this->p_add_branch=$this->ag_auth->check_privilege(18,'branch_add');
					$this->data['p_delete_branch']=$this->p_delete_branch=$this->ag_auth->check_privilege(18,'branch_delete');
					$this->data['p_view_branch']=$this->p_view_branch=$this->ag_auth->check_privilege(18,'branch_view');
			
					$this->data['p_edit_port']=$this->p_edit_port=$this->ag_auth->check_privilege(18,'ports_edit');
					$this->data['p_add_port']=$this->p_add_port=$this->ag_auth->check_privilege(18,'ports_add');
					$this->data['p_delete_port']=$this->p_delete_port=$this->ag_auth->check_privilege(18,'ports_delete');
					$this->data['p_view_port']=$this->p_view_port=$this->ag_auth->check_privilege(18,'ports_view');

					$subtitle=$row['name_ar'];	
					$controller='transportations';
					$nav='transportation/_navigation';				
				break;

				}
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Dashboard','dashboard');
		$this->breadcrumb->add_crumb($subtitle,$controller.'/details/'.$itemid);
		$this->breadcrumb->add_crumb('Documents','documents/index/'.$itemid.'/'.$type);
		$this->data['title'] = $this->data['Ctitle']." - ".$subtitle;
		$this->data['subtitle'] = $subtitle;
		$this->data['nav'] = $nav;
		$this->data['id'] = $itemid;
		$this->data['type'] = $type;
		$this->template->load('_template', 'documents/index', $this->data);		
	}

	public function create()
	{	
			
			if (isset($_POST['save'])) {
				
				$array=$this->Administrator->do_upload('uploads/');
				
				if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path='';
					}

				$msg=$array['error'];	

				$data = array(
				'title'=> $this->input->post('title'),
				'url'=> $path,
				'item_id'=> $this->input->post('item_id'),
				'item_type'=> $this->input->post('item_type'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
			
				if($id=$this->General->save('documents',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Company Added successfully'));	
					redirect('documents/index/'.$this->input->post('item_id').'/'.$this->input->post('item_type'));
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('documents/index/'.$this->input->post('item_id').'/'.$this->input->post('item_type'));
				}
			}			
	}
	
	public function edit($id)
	{
			if($this->p_edit)
			{
			
			$this->data['nave']=TRUE;

			$query=$this->Company->GetCompanyById($id);
			$this->data['query']=$query;
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Companies','companies');
			$this->breadcrumb->add_crumb($query['name_en'],'companies/details/'.$id);
			$this->breadcrumb->add_crumb('Edit Company');
					
			$this->form_validation->set_rules('name_ar', 'company name in arabic', 'required');
			
			if ($this->form_validation->run()) {
				//echo $this->input->post('display_exhibition');
				//die;
				$array=$this->Administrator->do_upload('uploads/');
				
				if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path=$this->input->post('adv_pic');
					}
				$x1=$this->input->post('x1');	
				$x2=$this->input->post('x2');	
				$x3=$this->input->post('x3');	
				$x=$x1.'°'.$x2."'".$x3.'"';
				
				$y1=$this->input->post('y1');	
				$y2=$this->input->post('y2');	
				$y3=$this->input->post('y3');	
				$y=$y1.'°'.$y2."'".$y3.'"';
				
				$data = array(
				'ref'=> $this->input->post('ref'),
				'name_ar'=> $this->input->post('name_ar'),
				'name_en'=> $this->input->post('name_en'),
				'sector_id'=> $this->input->post('sector_id'),
				'establish_date'=> $this->input->post('establish_date'),
				'start_date'=> $this->input->post('start_date'),
				'commercial_register_ar'=> $this->input->post('commercial_register_ar'),
				'commercial_register_en'=> $this->input->post('commercial_register_en'),
				'activity_ar'=> $this->input->post('activity_ar'),
				'activity_en'=> $this->input->post('activity_en'),
				'com_capital'=> $this->input->post('com_capital'),
				'company_type_id'=> $this->input->post('company_type_id'),
				
				'governorate_id'=> $this->input->post('governorate_id'),
				'district_id'=> $this->input->post('district_id'),
				'area_id'=> $this->input->post('area_id'),
				'street_ar'=> $this->input->post('street_ar'),
				'street_en'=> $this->input->post('street_en'),
				'bldg_ar'=> $this->input->post('bldg_ar'),
				'bldg_en'=> $this->input->post('bldg_en'),
				'fax'=> $this->input->post('fax'),
				'phone'=> $this->input->post('phone'),
				'pobox_ar'=> $this->input->post('pobox_ar'),
				'pobox_en'=> $this->input->post('pobox_en'),
				'email'=> $this->input->post('email'),
				'website'=> $this->input->post('website'),
				'x_location'=> $x,
				'y_location'=> $y,

				
				'rep_person_ar'=> $this->input->post('rep_person_ar'),
				'rep_person_en'=> $this->input->post('rep_person_en'),
				'position_id'=> $this->input->post('position_id'),
				
				'iro_code'=> $this->input->post('iro_code'),
				'igr_code'=> $this->input->post('igr_code'),
				'leb_ind_group'=> $this->input->post('leb_ind_group'),
				'sales_man_id'=> $this->input->post('sales_man_id'),
				'auth_no'=> $this->input->post('auth_no'),
				'owner_name'=> $this->input->post('owner_name'),
				
				'eas_code'=> $this->input->post('eas_code'),
				'tun_code'=> $this->input->post('tun_code'),
				'beside_en'=> $this->input->post('beside_en'),
				'beside_ar'=> $this->input->post('beside_ar'),
				'show_online'=> $this->input->post('show_online'),

				'owner_name_en'=> $this->input->post('owner_name_en'),
				'copy_res'=> $this->input->post('copy_res'),
				'is_adv'=> $this->input->post('is_adv'),
				'entry_date'=> $this->input->post('entry_date'),
				'ref'=> $this->input->post('ref'),
				'trade_license'=> $this->input->post('trade_license'),
				'auth_person_ar'=> $this->input->post('auth_person_ar'),
				'auth_person_en'=> $this->input->post('auth_person_en'),
				
				
				'license_date'=> $this->input->post('license_date'),
				'license_source_ar'=> $this->input->post('license_source_ar'),
				'license_source_en'=> $this->input->post('license_source_en'),
				'license_type'=> $this->input->post('license_type'),
				'app_fill_date'=> $this->input->post('app_fill_date'),
				'exp_dest_ar'=> $this->input->post('exp_dest_ar'),
				'exp_dest_en'=> $this->input->post('exp_dest_en'),
				'personal_notes'=> $this->input->post('personal_notes'),
				'adv_pic'=> $path,
				'ind_association'=> $this->input->post('ind_association'),
				'license_source_id'=> $this->input->post('license_source_id'),
				'is_exporter'=> $this->input->post('is_exporter'), 
				
				'display_directory'=> ($this->input->post('display_directory')  != false) ? 1 : 0, 
				'directory_interested'=> $this->input->post('directory_interested'), 
				'display_exhibition'=> ($this->input->post('display_exhibition')  != false) ? 1 : 0, 
				'exhibition_interested'=> $this->input->post('exhibition_interested'), 
				
				'update_time' =>  date('Y-m-d H:i:s'),
				'status' => $this->input->post('status'),
				'user_id' =>  $this->session->userdata('id'),
			);
			
				if($this->Administrator->edit($this->company,$data,$id))
				{
					$this->session->set_userdata(array('admin_message'=>'Company Updated successfully'));	
					redirect('companies/details/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('companies/edit/'.$id);					
				}
				
			 }
			 /**********************General Info************************/
			 	$this->data['c_id'] = $id;
				$this->data['id'] = $id;
				$this->data['ref'] = $query['ref'];
				$this->data['name_ar'] = $query['name_ar'];
				$this->data['name_en'] = $query['name_en'];
				$this->data['owner_name'] = $query['owner_name'];
				$this->data['owner_name_en'] = $query['owner_name_en'];
				$this->data['auth_person_ar'] = $query['auth_person_ar'];
				$this->data['auth_person_en'] = $query['auth_person_en'];
				$this->data['auth_no'] = $query['auth_no'];
				$this->data['activity_ar'] = $query['activity_ar'];
				$this->data['activity_en'] = $query['activity_en'];
				$this->data['establish_date'] = $query['establish_date'];
				$this->data['sector_id'] =$query['sector_id'];
				$this->data['license_source_id'] = $query['license_source_id'];
				$this->data['company_type_id'] = $query['company_type_id'];
				
				$this->data['personal_notes'] = $query['personal_notes'];
				$this->data['display_directory'] = $query['display_directory'];
				$this->data['directory_interested'] = $query['directory_interested'];
				$this->data['display_exhibition'] = $query['display_exhibition'];
				$this->data['exhibition_interested'] = $query['exhibition_interested'];

				/**********************Address************************/
				$this->data['governorate_id'] = $query['governorate_id'];
				$this->data['district_id'] = $query['district_id'];
				$this->data['area_id'] = $query['area_id'];
				$this->data['street_ar'] = $query['street_ar'];
				$this->data['street_en'] = $query['street_en'];
				$this->data['bldg_ar'] = $query['bldg_ar'];
				$this->data['bldg_en'] = $query['bldg_en'];
				$this->data['fax'] = $query['fax'];
				$this->data['phone'] = $query['phone'];
				$this->data['pobox_ar'] = $query['pobox_ar'];
				$this->data['pobox_en'] = $query['pobox_en'];
				$this->data['email'] = $query['email'];
				$this->data['website'] = $query['website'];
				$this->data['x_location'] = $query['x_location'];
				$this->data['y_location'] = $query['y_location'];
				/*************************End Address******************/
				$this->data['ind_association'] = $query['ind_association'];
				$this->data['iro_code'] = $query['iro_code'];
				$this->data['igr_code'] = $query['igr_code'];
				$this->data['eas_code'] = $query['eas_code'];
				
				/*************************Molhak******************/
				$this->data['rep_person_ar'] = $query['rep_person_ar'];
				$this->data['rep_person_en'] = $query['rep_person_en'];
				$this->data['app_fill_date'] = $query['app_fill_date'];
				$this->data['position_id'] = $query['position_id'];
				$this->data['sales_man_id'] = $query['sales_man_id'];
				$this->data['is_exporter'] = $query['is_exporter'];
				$this->data['show_online'] = $query['show_online'];
				$this->data['is_adv'] = $query['is_adv'];
				$this->data['copy_res'] = $query['copy_res'];
				$this->data['adv_pic'] = $query['adv_pic'];
				$this->data['governorates']=$this->Address->GetGovernorate('online',0,0);
				$this->data['economical_assembly']=$this->Company->GetEconomicalAssembly('online');
				$this->data['company_types']=$this->Company->GetCompanyTypes('online');
				$this->data['districts']=$this->Address->GetDistrictByGov('online',$query['governorate_id']);
				$this->data['areas']=$this->Address->GetAreaByDistrict('online',$query['district_id']);
				
				$this->data['sectors']=$this->Item->GetSector('online',0,0);
				$this->data['iro_data']=$this->Company->GetIndustrialRooms();
				$this->data['igr_data']=$this->Company->GetIndustrialGroups();
				$this->data['eas_data']=$this->Company->GetEconomicalAssemblies();
				$this->data['positions']=$this->Company->GetPositions();
				$this->data['sales']=$this->Company->GetSalesMen();
				$this->data['license_sources']=$this->Company->GetLicenseSources();
				
				$this->data['subtitle'] = 'Edit Company';
				$this->data['title'] = $this->data['Ctitle']."- Edit New Company";
				$this->template->load('_template', 'company/company_form', $this->data);	
				}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect('companies');					

			}	
	}
	public function power($id,$item_id='')
	{
		
			if($this->p_power)
			{
			$query=$this->Company->GetCompanyById($id);
					
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Companies','companies');
			$this->breadcrumb->add_crumb($query['name_en'],'companies/details/'.$id);
			$this->breadcrumb->add_crumb('Electric Power','companies/power/'.$id);
					
			$this->form_validation->set_rules('fuel', 'fuel', 'trim');
			$this->form_validation->set_rules('diesel', 'diesel', 'trim');	
		if ($this->form_validation->run()) {
				if($_POST['action']=='add'){
					if($this->form_validation->set_value('fuel')!='')
					{
						$fuels=$this->form_validation->set_value('fuel').' '.$this->input->post('fuel_unit');
					}
					else{
						$fuels='';
						}
					if($this->form_validation->set_value('diesel')!='')
					{
						$diesels=$this->form_validation->set_value('diesel').' '.$this->input->post('diesel_unit');
					}
					else{
						$diesels='';
						}	
				if($fuels=='' and $diesels=='')
				{
					$this->session->set_userdata(array('admin_message'=>'You musta t least select 1 field'));	
					redirect('companies/power/'.$id);	
				}		
				$data = array(
				'company_id'=> $id,
				'fuel'=> $fuels,
				'diesel'=> $diesels,
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
				if($this->form_validation->set_value('fuel')!='')
					{
						$fuels=$this->form_validation->set_value('fuel').' '.$this->input->post('fuel_unit');
					}
					else{
						$fuels='';
						}
					if($this->form_validation->set_value('diesel')!='')
					{
						$diesels=$this->form_validation->set_value('diesel').' '.$this->input->post('diesel_unit');
					}
					else{
						$diesels='';
						}	
				$data = array(
				'company_id'=> $id,
				'fuel'=> $fuels,
				'diesel'=> $diesels,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
				$row=$this->Company->GetCompanyEPower($id);
				if($this->Administrator->edit($this->company_power,$data,$row['id']))
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
			$items=$this->Company->GetCompanyElectricPowers($id); 	
		if(count($items)==0){
				
			$this->data['subtitle'] = 'Add';
			$this->data['action'] = 'add';
			$this->data['display']='';
			$fuel=array(0=>'',1=>'');
			$diesel=array(0=>'',1=>'');
			
			}
		else{
			
			$row=$this->Company->GetCompanyEPower($id);
		
			$this->data['subtitle'] = 'Edit';
			$this->data['action'] = 'edit';
			$this->data['display']=@$row['fuel'].'<br><hr />'.@$row['diesel'];

			$fuel=explode(' ',@$row['fuel']);
			$diesel=explode(' ',@$row['diesel']);
			}	
		$this->data['id'] = $id;
		$this->data['c_id'] = $id;		
		$this->data['fuel'] = @$fuel[0];
		$this->data['fuel_unit'] = @$fuel[1];
		$this->data['diesel'] = @$diesel[0];	
		$this->data['diesel_unit'] = @$diesel[1];	
		$this->data['query']=$query;
	
		
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['items']=$this->Company->GetCompanyElectricPowers($id);
		$this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
		$this->template->load('_template', 'company/electric_power', $this->data);	
		}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect('companies/details/'.$id);					

			}		
	}	
	public function sponsors($id)
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
		$this->breadcrumb->add_crumb('Sponsors','companies/sponsors/'.$id);
	
		$this->data['c_id'] = $id;
		$this->data['query']=$query;
	
		$this->data['p_delete']=TRUE;
		$this->data['p_edit']=TRUE;
		$this->data['p_add']=TRUE;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['items']=$this->Company->GetCompanySponsors('online');
		$this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
		$this->data['subtitle'] = "Sponsors";
		$this->template->load('_template', 'company/sponsors', $this->data);		
	}
	public function marketdata()
	{
			$query=$this->Company->GetCompanies('',0,0);
			foreach($query as $row)
			{
				/*
				if($row->local_market==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>1,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->gulf_arab_state==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>2,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->other_arab_state==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>3,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->south_east_asia==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>4,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->north_west_asia==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>5,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->african_state==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>6,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->europian_countries==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>7,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->usa_canada==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>8,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				if($row->latin_american==1)
				{
					$data=array();
					$data=array(
					'company_id'=>$row->id,
					'market_id'=>9,
					'item_type'=>'region',
					'create_time' =>  date('Y-m-d H:i:s'),
					'update_time' =>  date('Y-m-d H:i:s'),
					'user_id' =>  $this->session->userdata('id')
					);	
					$this->General->save('tbl_markets_company',$data);
				}
				*/
					echo $row->name_ar.' Local Market : '.$row->local_market.' 1';
					echo ' Gulf Arab States : '.$row->gulf_arab_state.' 2';
					echo ' other_arab_state : '.$row->other_arab_state.' 3';
					echo ' south_east_asia : '.$row->south_east_asia.' 4';
					echo ' north_west_asia : '.$row->north_west_asia.' 5';
					echo ' african_state : '.$row->african_state.' 6';
					echo ' europian_countries : '.$row->europian_countries.' 7';
					echo ' usa_canada : '.$row->usa_canada.' 8';
					echo ' latin_american : '.$row->latin_american.' 9';
					echo '<hr />';
			}
	
	}	
	
	public function importexcel()
	{
		$file = base_url().'files/company.csv';
		$handle = fopen($file, "r");
		$c = 0;
		while(($filesop = fgetcsv($handle, filesize($file), ",")) !== false)
		{
			$data=array(
				'name_ar'=>$filesop[1],
				'name_en'=>$filesop[1],
				'owner_name'=>$filesop[2],
				'owner_name_en'=>$filesop[2],
				'activity_ar'=>$filesop[3],
				'activity_en'=>$filesop[3],
				'governorate_id'=>$filesop[4],
				'district_id'=>$filesop[5],
				'area_id'=>$filesop[6],
				'street_ar'=>$filesop[7],
				'street_en'=>$filesop[7],
				'phone'=>$filesop[8],
				'fax'=>$filesop[9],
				'email'=>$filesop[10],
				'website'=>$filesop[11],
				'personal_notes'=>$filesop[12],
			);
			//$name = $filesop[0];
			//$email = $filesop[1];
			echo '<pre>';
			var_dump($data);
			echo '</pre>';
			//$sql = mysql_query("INSERT INTO csv (name, email) VALUES ('$name','$email')");
			$c = $c + 1;
		}
		
	}
	public function inmportdata()
	{
	
			//$name = $_FILES;
			$name = 'files/company.csv';
			//echo $name;
			include APPPATH.'libraries/PHPExcel/IOFactory.php';
			
			$objPHPExcel = PHPExcel_IOFactory::load($name);
			$maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
							echo 'test';

			$sheetData = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
			$sheetData = array_map('array_filter', $sheetData);
			
			$sheetData = array_filter($sheetData);
			//$format = array('title','Date (DD-MM-YYYY)','start time (HH:MM:SS AM/PM)','end time (HH:MM:SS AM/PM)','Tags (Comma Separated)','Is AD','title en');
			//if($sheetData[0] == $format)
		//	{
				unset($sheetData[0]);
				foreach($sheetData as $filesop)
				{
					$data=array(
					'name_ar'=>$filesop[1],
					'name_en'=>$filesop[1],
					'owner_name'=>$filesop[2],
					'owner_name_en'=>$filesop[2],
					'activity_ar'=>$filesop[3],
					'activity_en'=>$filesop[3],
					'governorate_id'=>$filesop[4],
					'district_id'=>$filesop[5],
					'area_id'=>$filesop[6],
					'street_ar'=>$filesop[7],
					'street_en'=>$filesop[7],
					'phone'=>@$filesop[8],
					'fax'=>@$filesop[9],
					'email'=>@$filesop[10],
					'website'=>@$filesop[11],
					'personal_notes'=>@$filesop[12],
				);
					echo '<pre>';
					var_dump($data);
					echo '</pre>';
					//$this->load->model('clientmodel');
					//$this->clientmodel->addtvevents($data);					
				}
			//	redirect('clients/schedules');
			//}
			
		
	}
	
	function documents($cid)
	{
	
		if($this->p_production){
			$query=$this->Company->GetDocumentsItemById($id);
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Companies','companies');
			$this->breadcrumb->add_crumb($query['name_en'],'companies/details/'.$id);
			$this->breadcrumb->add_crumb('Production information','companies/productions/'.$id);
					
			$this->form_validation->set_rules('heading_id', 'Heading', 'required');	
		if ($this->form_validation->run()) {
				if($_POST['action']=='add'){
				//	var_dump($_POST);
				//	die;
				$data = array(
				'company_id'=> $id,
				'heading_id'=> $this->form_validation->set_value('heading_id'),
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($this->General->save($this->company_heading,$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Prodduction Added successfully'));	
					redirect('companies/productions/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('companies/prodcution-create/'.$id);					
				}
				}
			else{
				$data = array(
				'company_id'=> $id,
				'heading_id'=> $this->form_validation->set_value('heading_id'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

				if($this->Administrator->edit($this->company_heading,$data,$item_id))
				{
					$this->session->set_userdata(array('admin_message'=>'Prodduction Updated successfully'));	
					redirect('companies/productions/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('companies/prodcutions/'.$id.'/'.$item_id);					
				}
				}	
			 }		
		if($item_id==''){
				
			$this->data['subtitle'] = 'Add New Production Item';
			$this->data['action'] = 'add';
			$this->data['display']='';
			}
		else{
			
			$row=$this->Company->GetProductionInfoById($item_id);
		//echo $item_id;
			$this->data['subtitle'] = 'Edit Production Item';
			$this->data['action'] = 'edit';
			$this->data['display']=@$row['heading_ar'].'<br><hr />'.@$row['heading_en'];
			}	
		$this->data['c_id'] = $id;
		$this->data['id'] = $id;
		$this->data['heading_id'] = $item_id;	
		$this->data['query']=$query;
	
		//$this->data['p_delete']=TRUE;
		//$this->data['p_edit']=TRUE;
		//$this->data['p_add']=TRUE;
		$this->data['msg']=$this->session->userdata('admin_message');
		$this->session->unset_userdata('admin_message');		
		$this->data['productions']=$this->Company->GetProductionInfo($id);
		$this->data['title'] = $this->data['Ctitle']." - Companies - الشركات";
		$this->data['items']=$this->Item->GetItems('online',0,0);
		$this->template->load('_template', 'company/documents', $this->data);	
		}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect('companies/details/'.$id);					

			}
		
	}
											
}

?>