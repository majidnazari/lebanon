<?php

class Logs extends Application
{
	var $p_delete=FALSE;
	var $p_restore=FALSE;
	var $p_view=FALSE;
	
	
	var $page_denied=FALSE;
	
	var $CompanyData;
	
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('logs'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Log','Address','Company','Bank','Insurance','Importer','Transport','Parameter','Item'));
		$this->data['Ctitle']='Industry - Logs ';
		
		$this->p_delete=$this->data['p_delete']=$this->ag_auth->check_privilege(71,'delete_logs');
		$this->p_restore=$this->data['p_restore']=$this->ag_auth->check_privilege(71,'restore_logs');
		$this->p_view=$this->data['p_view']=$this->ag_auth->check_privilege(71,'view_logs');

        $this->page_denied='denied';
		$this->data['page_denied']=$this->page_denied;
		$this->CompanyData = array(
		            'id' => 'ID',
                    'ref' => 'المرجع',
                    'name_ar' => 'اسم المؤسسة',
                    'name_en' => 'Company Name',
                    'sector_id' => 'القطاع',
                    'activity_ar' => 'النشاط',
                    'activity_en' => 'Activity',
                    'company_type_id' => 'نوع الشركة',
                    'governorate_id' => 'المحافظة',
                    'district_id' => 'القضاء',
                    'area_id' => 'البلدة',
                    'street_ar' => 'شارع',
                    'street_en' => 'Street in English',
                    'bldg_ar' => 'بناية',
                    'bldg_en' => 'Building in English',
                    'fax' => 'Fax',
                    'phone' => 'Phone',
                    'pobox_ar' => 'Pobox in Arabic',
                    'pobox_en' => 'Pobox in English',
                    'email' => 'Email',
                    'website' => 'Website',
                    'x_decimal' => 'N Location Decimal',
                    'y_decimal' => 'E Location Decimal',
                    'rep_person_ar' => 'مع من تمت المقابلة',
                    'rep_person_en' => 'Interviewer',
                    'position_id' => 'صفته في المؤسسة',
                    'iro_code' => 'غرفة التجارة الصناعة والزراعة في',
                    'igr_code' => 'تجمع صناعي',
                    'sales_man_id' => 'المندوب',
                    'auth_no' => 'سجل تجاري',
                    'owner_name' => 'صاحب المؤسسة',
                    'eas_code' => 'اتحادات مهنية اقليمية او دولية',
                    'show_online' => 'Online',
                    'owner_name_en' => 'Company Owner',
                    'copy_res' => 'Copy Reservation',
                    'is_adv' => 'Advertisment',
                    'auth_person_ar' => 'المفوض بالتوقيع',
                    'auth_person_en' => 'Auth. to sign',
                    'app_fill_date' => 'تاريخ ملء الاستمار',
                    'personal_notes' => 'ملاحظات شخصي',
                    'adv_pic' => 'صورة الاعل',
                    'ind_association' => 'جمعية الصناعيين اللبنانين',
                    'license_source_id' => 'مصدر السجل',

                    'display_directory' => 'تم عرض الدليل',
                    'directory_interested' => 'مهتم',
                    'display_exhibition' => 'تم عرض المعرض',
                    'address2_ar' => 'العنوان ٢',
                    'address2_en' => 'Address 2',

                    'wezara_source' => 'وزارة الصناعة',
                    'other_source' => 'اخرى / حدد',
                    'nbr_source' => 'رقم الرخصة',
                    'date_source' => 'تاريخ الرخصة',
                    'type_source' => 'الفئة - الرخصة',
                    'ministry_id' => 'ID وزارة',
                    'employees_number' => 'عدد العمال',
                    'is_closed' => 'مغلقة',
                    'error_address' => 'عنوان خطأ ',
                    'acc' => 'ACC. Done',
                    'closed_date' => 'تاريخ الاغلاق',
                    'related_companies'=>'Related Companies ID',
                    'create_time' => 'Create Date',
                    'update_time' => 'Last Update Date',
                    'user_id' => 'Created By',
                );
                
                function ShowData($array,$type){
                    $data=array();
                    	switch($type)
			{
				case 'company':
				 foreach($this->CompanyData as $key=>$value)
			        {
			            
			            $data->$value=$array->$key;
			        };
				break;
				case 'bank':
				$data=$array;
				break;
				case 'insurance':
					$data=$array;
					break;
				case 'importer':
					$data=$array;
				break;
				case 'transportation':
						$data=$array;
				break;
				}
			       
			        return $data;
			
			}
		
			
						
	}
	public function delete()
	{
		$get = $this->uri->ruri_to_assoc();
		if((int)$get['id'] > 0){
                    if($this->p_delete){
					$this->General->delete('logs',array('id'=>$get['id']));
                    $this->General->delete('logs',array('logs_id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Logs Deleted'));
					redirect($_SERVER['HTTP_REFERER']);	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}
			

				
				}

		 } 
	

	public function restore()
	{
		$get = $this->uri->ruri_to_assoc();
		if((int)$get['id'] > 0){
			if($this->p_restore){
			switch($get['p'])
			{
				case 'company':
					$this->RestoreCompanies($get['id']);
				break;
				case 'bank':
					$this->RestoreBanks($get['id']);
				break;
				case 'insurance':
					$this->RestoreInsurances($get['id']);
					break;
				case 'importer':
					$this->RestoreImporters($get['id']);
				break;
				case 'transportation':
					$this->RestoreTransportations($get['id']);
				break;
				}
			}
			else{
				$this->session->set_userdata(array('admin_message'=>'Access Denied'));
				redirect($this->page_denied);	
				}
		 } 
		 
	}
        private function RestoreCompanies($id)
        {
            
           $query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
			{
				$company_array=json_decode($query['details']);
				
				if(count($company_array)>0)
				{
					$data = array(
							'ref'=> $company_array->ref,
							'name_ar'=> $company_array->name_ar,
							'name_en'=> $company_array->name_en,
							'sector_id'=> $company_array->sector_id,
							'start_date'=> $company_array->start_date,
							'commercial_register_ar'=> $company_array->commercial_register_ar,
							'commercial_register_en'=> $company_array->commercial_register_en,
							'activity_ar'=> $company_array->activity_ar,
							'activity_en'=> $company_array->activity_en,
							'com_capital'=> $company_array->com_capital,
							'company_type_id'=> $company_array->company_type_id,
							
							'governorate_id'=> $company_array->governorate_id,
							'district_id'=> $company_array->district_id,
							'area_id'=> $company_array->area_id,
							'street_ar'=> $company_array->street_ar,
							'street_en'=> $company_array->street_en,
							'bldg_ar'=> $company_array->bldg_ar,
							'bldg_en'=> $company_array->bldg_en,
							'fax'=> $company_array->fax,
							'phone'=> $company_array->phone,
							'pobox_ar'=> $company_array->pobox_ar,
							'pobox_en'=> $company_array->pobox_en,
							'email'=> $company_array->email,
							'website'=> $company_array->website,
							'x_decimal'=> $company_array->x_decimal,
							'y_decimal'=> $company_array->y_decimal,
							
							'rep_person_ar'=> $company_array->rep_person_ar,
							'rep_person_en'=> $company_array->rep_person_en,
							'position_id'=> $company_array->position_id,
							
							'iro_code'=> $company_array->iro_code,
							'igr_code'=> $company_array->igr_code,
							'leb_ind_group'=> $company_array->leb_ind_group,
							'sales_man_id'=> $company_array->sales_man_id,
							'auth_no'=> $company_array->auth_no,
							'owner_name'=> $company_array->owner_name,
							
							'eas_code'=> $company_array->eas_code,
							'tun_code'=> $company_array->tun_code,
							'beside_en'=> $company_array->beside_en,
							'beside_ar'=> $company_array->beside_ar,
							'show_online'=> $company_array->show_online,
			
							'owner_name_en'=> $company_array->owner_name_en,
							'copy_res'=> $company_array->copy_res,
							'is_adv'=> $company_array->is_adv,
							'entry_date'=> $company_array->entry_date,
							'ref'=> $company_array->ref,
							'trade_license'=> $company_array->trade_license,
							'auth_person_ar'=> $company_array->auth_person_ar,
							'auth_person_en'=> $company_array->auth_person_en,
							
							
							'license_date'=> $company_array->license_date,
							'license_source_ar'=> $company_array->license_source_ar,
							'license_source_en'=> $company_array->license_source_en,
							'license_type'=> $company_array->license_type,
							'app_fill_date'=> $company_array->app_fill_date,
							'exp_dest_ar'=> $company_array->exp_dest_ar,
							'exp_dest_en'=> $company_array->exp_dest_en,
							'personal_notes'=> $company_array->personal_notes,
							'adv_pic'=> $company_array->adv_pic,
							'ind_association'=> $company_array->ind_association,
							'license_source_id'=> $company_array->license_source_id,
							'is_exporter'=> $company_array->is_exporter, 
							
							'display_directory'=> ($company_array->display_directory  != false) ? 1 : 0, 
							'directory_interested'=> $company_array->directory_interested, 
							'display_exhibition'=> ($company_array->display_exhibition  != false) ? 1 : 0, 
							'exhibition_interested'=> $company_array->exhibition_interested, 
			
							'address2_ar' => $company_array->address2_ar,
							'address2_en' => $company_array->address2_en,				
							
							'create_time' =>   $company_array->create_time,
							'update_time' =>   date('Y-m-d H:i:s'),
							'status' => $company_array->status,
							'user_id' =>  $this->session->userdata('id'),
						);
					$company=$this->Company->GetCompanyById($company_array->id);
					if(count($company)==0)
					{
						$data['id']=$company_array->id;
					}	
					$cid=$this->General->save('tbl_company',$data);
					
					$others=$this->Log->GetLogs('','', '','','delete',$id,0,0);
					foreach($others as $other){
						switch ($other->type) {
							case 'company_heading':
								$_items=json_decode($other->details);
								foreach($_items as $item){
									$this->General->save('tbl_company_heading',array('code'=>$item->code,'company_id'=>$cid,'heading_id'=>$item->heading_id,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));
					}
								break;
							case 'power_company':
								$_power=json_decode($other->details);
								foreach($_powers as $power){
									
									$this->General->save('tbl_power_company',array('fuel'=>$power->fuel,'company_id'=>$cid,'diesel'=>$power->diesel,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));						
								}
								break;
							case 'insurances_company':
								$_insurances=json_decode($other->details);
								foreach($_insurances as $insurance){
									$this->General->save('tbl_insurances_company',array('aic_code'=>$insurance->aic_code,'company_id'=>$cid,'insurance_id'=>$insurance->insurance_id,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));						
								}
								break;
								case 'banks_company':
								$_banks=json_decode($other->details);
								foreach($_banks as $bank){
						$this->General->save('tbl_banks_company',array('company_id'=>$cid,'bank_id'=>$bank->bank_id,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));						
					}
								break;
								case 'markets_company':
								$_markets=json_decode($other->details);
								foreach($_markets as $market){
						$this->General->save('tbl_markets_company',array('company_id'=>$cid,'market_id'=>$market->market_id,'item_type'=>$market->item_type,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));						
					}
								break;
							
							
								
						} 
					}
					$this->General->delete('logs',array('item_id'=>$id));	
					$this->General->delete('logs',array('id'=>$id));
				}
				}
					$this->session->set_userdata(array('admin_message'=>'Company Restored'));
					redirect($_SERVER['HTTP_REFERER']);	
        }
	private function RestoreBanks($id)
	{
		
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				'name_ar'=> $_array->name_ar,
				'name_en'=> $_array->name_en,
				'establish_date'=> $_array->establish_date,
				'bnk_capital'=> $_array->bnk_capital,
				'list_number'=> $_array->list_number,
				'trade_license'=> $_array->trade_license,
				'license_source_id'=> $_array->license_source_id,
				
				'governorate_id'=> $_array->governorate_id,
				'district_id'=> $_array->district_id,
				'area_id'=> $_array->area_id,
				'street_ar'=> $_array->street_ar,
				'street_en'=> $_array->street_en,
				'bldg_ar'=> $_array->bldg_ar,
				'bldg_en'=> $_array->bldg_en,
				'fax'=> $_array->fax,
				'phone'=> $_array->phone,
				'pobox_ar'=> $_array->pobox_ar,
				'pobox_en'=> $_array->pobox_en,
				'email'=> $_array->email,
				'website'=> $_array->website,
				'x_location'=> $_array->x_location,
				'y_location'=> $_array->y_location,
				'sales_man_id'=> $_array->sales_man_id,
				'online'=> $_array->online,
				'bnk_capital'=> $_array->bnk_capital,
				'res_person_ar'=> $_array->res_person_ar,
				'res_person_en'=> $_array->res_person_en,
				'position_id'=> $_array->position_id,
				'beside_en'=> $_array->beside_en,
				'beside_ar'=> $_array->beside_ar,
				
				'copy_res'=> $_array->copy_res,
				'is_adv'=> $_array->is_adv,
				'adv_pic'=> $_array->adv_pic,
				'bnk_ref'=> $_array->bnk_ref,
				'app_refill_date' => $_array->app_refill_date,
				
				'display_directory' => $_array->display_directory,
				'directory_interested' => $_array->directory_interested,
				'display_exhibition' => $_array->display_exhibition,
				'exhibition_interested' => $_array->exhibition_interested,
				'personal_notes' => $_array->personal_notes,
				'address2_ar' => $_array->address2_ar,
				'address2_en' => $_array->address2_en,

				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'status' => $_array->status,
				'user_id' =>  $this->session->userdata('id'),
			);
				$bank=$this->Bank->GetBankById($_array->id);
				if(count($bank)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_bank',$data);
				$others=$this->Log->GetLogs('','', '','','delete',$id,0,0);
					foreach($others as $other){
						switch ($other->type) {
							case 'banks_directors':
								$_directors=json_decode($other->details);
								foreach($_directors as $_director){
					$this->General->save('tbl_bank_director',array('bank_id'=>$cid,'name_en'=>$_director->name_en,'name_ar'=>$_director->name_ar,'ordering'=>$_director->ordering,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));
				}
								break;
							case 'banks_branches':
								$_branches=json_decode($other->details);
								foreach($_branches as $_branche){
									$branch_data = array(
										'name_ar'=> $_branche->name_ar,
										'name_en'=> $_branche->name_en,
										'bank_id'=> $cid,
										'area_id'=> $_branche->area_id,
										'street_ar'=> $_branche->street_ar,
										'street_en'=> $_branche->street_en,
										'bldg_ar'=> $_branche->bldg_ar,
										'bldg_en'=> $_branche->bldg_en,
										'fax'=> $_branche->fax,
										'phone'=> $_branche->phone,
										'pobox_ar'=> $_branche->pobox_ar,
										'pobox_en'=> $_branche->pobox_en,
										'email'=> $_branche->email,
										'web_page'=> $_branche->website,
										'x_location'=> $_branche->x_location,
										'y_location'=> $_branche->y_location,
										'beside_en'=> $_branche->beside_en,
										'beside_ar'=> $_branche->beside_ar,
										'create_time' =>  date('Y-m-d H:i:s'),
										'update_time' =>  date('Y-m-d H:i:s'),
										'status' => $_branche->status,
										'user_id' =>  $this->session->userdata('id'),
									);
									$this->General->save('tbl_bank_branch',$branch_data);						
								}
								break;
						} 
					}
					$this->General->delete('logs',array('item_id'=>$id));	
					$this->General->delete('logs',array('id'=>$id));			}
			
		}
		$this->session->set_userdata(array('admin_message'=>'Bank Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	}
	private function RestoreInsurances($id)
	{
		
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				'name_en'=> $_array->name_en,
				'name_ar'=> $_array->name_ar,
				'ins_number'=> $_array->ins_number,
				'ins_ecoo_no'=> $_array->ins_ecoo_no,
				'manager_ar'=> $_array->manager_ar,
				'manager_en'=> $_array->manager_en,
				'chairman_ar'=> $_array->chairman_ar,
				'chairman_en'=> $_array->chairman_en,
				'trade_license'=> $_array->trade_license,
				'license_source_id'=> $_array->license_source_id,
			
//				'cr_ar'=> $_array->cr_ar,
//				'cr_en'=> $_array->cr_en,
				'capital'=> $_array->capital,
				'area_id'=> $_array->area_id,
				'street_en'=> $_array->street_en,
				'street_ar'=> $_array->street_ar,
				'bldg_en'=> $_array->bldg_en,
				'bldg_ar'=> $_array->bldg_ar,
				'phone'=> $_array->phone,
				'fax'=> $_array->fax,
				'pobox_ar'=> $_array->pobox_ar,
				'pobox_en'=> $_array->pobox_en,
				'email'=> $_array->email,
				'website'=> $_array->website,
				'governorate_id'=> $_array->governorate_id,
				'district_id'=> $_array->district_id,
				'x_location'=> $_array->x_location,
				'y_location'=> $_array->y_location,
				'sales_man_id'=> $_array->sales_man_id,
				'beside_en'=> $_array->beside_en,
				'beside_ar'=> $_array->beside_ar,

				'copy_res'=> $_array->copy_res,
				'is_adv'=> $_array->is_adv,
				'adv_pic'=> $_array->adv_pic,
				'activities'=> $_array->activities,
				'activity_other_ar'=> $_array->activity_other_ar,
				'activity_other_en'=> $_array->activity_other_en,
				'entry_date'=> $_array->entry_date,
				'rep_person_ar'=> $_array->rep_person_ar,
				'rep_person_en'=> $_array->rep_person_en,		
				'position_id'=> $_array->position_id,	
				'ref'=> $_array->ref,
				'personal_notes'=> $_array->personal_notes,
				
				'display_directory' => $_array->display_directory,
				'directory_interested' => $_array->directory_interested,
				'display_exhibition' => $_array->display_exhibition,
				'exhibition_interested' => $_array->exhibition_interested,
				'address2_ar'=> $_array->address2_ar,
				'address2_en'=> $_array->address2_en,								
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'status' => $_array->status,
				'user_id' =>  $this->session->userdata('id'),

			);
				$bank=$this->Insurance->GetInsuranceById($_array->id);
				if(count($bank)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_insurances',$data);
				
				$others=$this->Log->GetLogs('','', '','','delete',$id,0,0);
					foreach($others as $other){
						switch ($other->type) {
							case 'insurance_directors':
								$_directors=json_decode($other->details);
								foreach($_directors as $_director){
								$this->General->save('tbl_insurance_directors',array('insurance_id'=>$cid,'name_en'=>$_director->name_en,'name_ar'=>$_director->name_ar,'ordering'=>$_director->ordering,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));
					
								}
								break;
							case 'insurance_branches':
								$_branches=json_decode($other->details);
								foreach($_branches as $_branche){
									$branch_data = array(
										'insurance_id'=> $cid,
										'name_ar'=> $_branche->name_ar,
										'name_en'=> $_branche->name_en,
										'area_id'=> $_branche->area_id,
										'street_ar'=> $_branche->street_ar,
										'street_en'=> $_branche->street_en,
										'bldg_ar'=> $_branche->bldg_ar,
										'bldg_en'=> $_branche->bldg_en,
										'phone'=> $_branche->phone,
										'fax'=> $_branche->fax,
										'pobox_ar'=> $_branche->pobox_ar,
										'pobox_en'=> $_branche->pobox_en,
										'email'=> $_branche->email,
										'website'=> $_branche->website,
										'beside_en'=> $_branche->beside_en,
										'beside_ar'=> $_branche->beside_ar,
										'create_time' =>  date('Y-m-d H:i:s'),
										'update_time' =>  date('Y-m-d H:i:s'),
										'user_id' =>  $this->session->userdata('id'),
									);
									$this->General->save('tbl_insurance_branches',$branch_data);						
									}
								break;
								case 'insurance_managers':
								$_managers=json_decode($other->details);
								foreach($_managers as $_manager){
								$this->General->save('tbl_insurance_managers',array('insurance_id'=>$cid,'name_en'=>$_manager->name_en,'name_ar'=>$_manager->name_ar,'ordering'=>$_director->ordering,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));
					
								}
								break;
						} 
					}
				$this->General->delete('logs',array('item_id'=>$id));	
				$this->General->delete('logs',array('id'=>$id));	
			}
			
		}
		$this->session->set_userdata(array('admin_message'=>'Insurance Company Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	}
	
	private function RestoreImporters($id)
	{
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				'name_en'=> $_array->name_en,
				'name_ar'=> $_array->name_ar,
				'owner_ar'=> $_array->owner_ar,
				'owner_en'=> $_array->owner_en,
				'area_id'=> $_array->area_id,
				'street_en'=> $_array->street_en,
				'street_ar'=> $_array->street_ar,
				'bldg_en'=> $_array->bldg_en,
				'bldg_ar'=> $_array->bldg_ar,
				'phone'=> $_array->phone,
				'fax'=> $_array->fax,
				'pobox_ar'=> $_array->pobox_ar,
				'pobox_en'=> $_array->pobox_en,
				'address2_ar'=> $_array->address2_ar,
				'address2_en'=> $_array->address2_en,
				'email'=> $_array->email,
				'website'=> $_array->website,
				'governorate_id'=> $_array->governorate_id,
				'district_id'=> $_array->district_id,
				'x_location'=> $_array->x_location,
				'y_location'=> $_array->y_location,
				'sales_man_id'=> $_array->sales_man_id,
				'beside_en'=> $_array->beside_en,
				'beside_ar'=> $_array->beside_ar,

				'copy_reservation'=> $_array->copy_res,
				'is_adv'=> $_array->is_adv,
				'adv_pic'=> $_array->adv_pic,
				'activities'=> $activities,
				'app_refill_date'=> $_array->app_refill_date,
				'activity_other_en'=> $_array->activity_other_en,
				'activity_other_ar'=> $_array->activity_other_ar,
				'res_person_ar'=> $_array->res_person_ar,
				'res_person_en'=> $_array->res_person_en,	
				'position_id'=> $_array->position_id,
						
				'ref'=> $_array->ref,
				'personal_notes'=> $_array->personal_notes,
				
				'display_directory'=> ($_array->display_directory  != false) ? 1 : 0, 
				'directory_interested'=> $_array->directory_interested, 
				'display_exhibition'=> ($_array->display_exhibition  != false) ? 1 : 0, 
				'exhibition_interested'=> $_array->exhibition_interested, 
				
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'online' => $_array->online,
				'user_id' =>  $this->session->userdata('id'),
			
				);
				$insu=$this->Importer->GetImporterById($_array->id);
				if(count($insu)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_importers',$data);
				
				$others=$this->Log->GetLogs('','', '','','delete',$id,0,0);
					foreach($others as $other){
						switch ($other->type) {
							case 'mporter_foreigns':
								$_fcompanies=json_decode($other->details);
								foreach($_fcompanies as $_fcompany){
									$fcompany_data = array(
										'importer_id'=> $cid,
										'name_ar'=> $_fcompany->name_ar,
										'name_en'=> $_fcompany->name_en,
										'address_ar'=> $_fcompany->address_ar,
										'address_en'=> $_fcompany->address_en,
										'items_ar'=> $_fcompany->items_ar,
										'items_en'=> $_fcompany->items_en,
										'trade_mark_ar'=> $_fcompany->trade_mark_ar,
										'trade_mark_en'=> $_fcompany->trade_mark_en,
										'create_time' =>  date('Y-m-d H:i:s'),
										'update_time' =>  date('Y-m-d H:i:s'),
										'user_id' =>  $this->session->userdata('id'),
									);
									$this->General->save('tbl_importer_foreign_companies',$fcompany_data);						
								}
								break;
													} 
					}
				$this->General->delete('logs',array('item_id'=>$id));	
				$this->General->delete('logs',array('id'=>$id));	
			}
		}
		$this->session->set_userdata(array('admin_message'=>'Importer Company Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	}	
    private function RestoreTransportations($id)
	{		
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				
				'name_en'=> $_array->name_en,
				'name_ar'=> $_array->name_ar,
				'owner_ar'=> $_array->owner_ar,
				'owner_en'=> $_array->owner_en,
				'area_id'=> $_array->area_id,
				'street_en'=> $_array->street_en,
				'street_ar'=> $_array->street_ar,
				'bldg_en'=> $_array->bldg_en,
				'bldg_ar'=> $_array->bldg_ar,
				'phone'=> $_array->phone,
				'fax'=> $_array->fax,
				'pobox_ar'=> $_array->pobox_ar,
				'pobox_en'=> $_array->pobox_en,
				'email'=> $_array->email,
				'website'=> $_array->website,
				'est_date'=> $_array->est_date,
				'governorate_id'=> $_array->governorate_id,
				'district_id'=> $_array->district_id,
				'x_location'=> $_array->x_location,
				'y_location'=> $_array->y_location,
				'sales_man_id'=> $_array->sales_man_id,
				'cr_ar'=> $_array->cr_ar,
				'cr_en'=> $_array->cr_en,
				'member_local'=> $_array->member_local,
				'member_overseas'=> $_array->member_overseas,
				'maritime'=> $_array->maritime,
				'airline'=> $_array->airline,
				'service_landline'=> $_array->service_landline,
				'service_maritime'=> $_array->service_maritime,
				'service_airline'=> $_array->service_airline,

				'copy_reservation'=> $_array->copy_reservation,
				'is_adv'=> $_array->is_adv,
				'adv_pic'=> $_array->adv_pic,
				'services'=> $_array->services,
				'app_refill_date'=> $_array->app_refill_date,
				'res_person_ar'=> $_array->res_person_ar,
				'res_person_en'=> $_array->res_person_en,			
				'position_id'=> $_array->position_id,	
					
				'trade_license'=> $_array->trade_license,		
				'license_source_id'=> $_array->license_source_id,		
					
				'ref'=> $_array->ref,
				'personal_notes'=> $_array->personal_notes,
				'address2_ar'=> $_array->address2_ar,
				'address2_en'=> $_array->address2_en,								
				
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'online' => $_array->online,
				'user_id' =>  $this->session->userdata('id'),
			
				);
				$_data=$this->Transport->GetTransportationById($_array->id);
				if(count($_data)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_transport',$data);
				
				$others=$this->Log->GetLogs('','', '','','delete',$id,0,0);
					foreach($others as $other){
						switch ($other->type) {
							case 'transportation_line_represented':
								$_linesrs=json_decode($other->details);
								foreach($_linesrs as $_linesr){
					$this->General->save('tbl_transport_line_represented',array('transport_id'=>$cid,'name_en'=>$_linesr->name_en,'name_ar'=>$_linesr->name_ar,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));
				
								}
								break;
							case 'transportation_branches':
								$_branches=json_decode($other->details);
								foreach($_branches as $_branche){
									$branch_data = array(
									'name_ar'=> $_branche->name_ar,
									'name_en'=> $_branche->name_en,
									'phone'=> $_branche->phone,
									'country_id'=> $_branche->country_id,
									'email'=> $_branche->email,
									'website'=> $_branche->website,
									'transport_id'=> $cid,
									'create_time' =>  date('Y-m-d H:i:s'),
									'update_time' =>  date('Y-m-d H:i:s'),
									'user_id' =>  $this->session->userdata('id'),
									);
									$this->General->save('tbl_transport_branches',$branch_data);						
								}
								break;
								case 'transportation_ports':
								$_ports=json_decode($other->details);
								foreach($_ports as $_port){
					$this->General->save('tbl_transport_ports',array('transport_id'=>$cid,'name_en'=>$_port->name_en,'name_ar'=>$_port->name_ar,'create_time'=>date('Y-m-d H:i:s'),'update_time'=>date('Y-m-d H:i:s'),'user_id' =>  $this->session->userdata('id')));
								}
								break;
						} 
					}
				$this->General->delete('logs',array('item_id'=>$id));	
				$this->General->delete('logs',array('id'=>$id));
			}
			
		}
		$this->session->set_userdata(array('admin_message'=>'Transport Company Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	
	}
private function RestoreSectors($id)
	{
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				'label_ar'=> $_array->label_ar,
				'label_en'=> $_array->label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			
				);
				$row=$this->Item->GetSectorById($_array->id);
				if(count($row)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_sectors',$data);
				$this->General->delete('logs',array('id'=>$id));	
			}
		}
		$this->session->set_userdata(array('admin_message'=>'Sector Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	}		
private function RestoreSections($id)
	{
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				'label_ar'=> $_array->label_ar,
				'label_en'=> $_array->label_en,
				'sector_id'=> $_array->sector_id,
				'scn_nbr'=> $_array->scn_nbr,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			
				);
				$row=$this->Item->GetSectionById($_array->id);
				if(count($row)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_section',$data);
				$this->General->delete('logs',array('id'=>$id));	
			}
		}
		$this->session->set_userdata(array('admin_message'=>'Section Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	}		
private function RestoreChapters($id)
	{
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				'label_ar'=> $_array->label_ar,
				'label_en'=> $_array->label_en,
				'section_id'=> $_array->section_id,
				'cha_nbr'=> $_array->cha_nbr,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			
				);
				$row=$this->Item->GetChapterById($_array->id);
				if(count($row)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_chapter',$data);
				$this->General->delete('logs',array('id'=>$id));	
			}
		}
		$this->session->set_userdata(array('admin_message'=>'Chapter Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	}	
	private function RestoreSubhead($id)
	{
		$query=$this->Log->GetLogById($id);
					
		if(count($query)>0)
		{
			$_array=json_decode($query['details']);
			
			if(count($_array)>0)
			{
				
				$data = array(
				'code'=> $_array->code,
				'label_ar'=> $_array->label_ar,
				'label_en'=> $_array->label_en,
				'code'=> $_array->code,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			
				);
				$row=$this->Item->GetSubheadById($_array->id);
				if(count($row)==0)
				{
					$data['id']=$_array->id;
				}	
				$cid=$this->General->save('tbl_subhead',$data);
				$this->General->delete('logs',array('id'=>$id));	
			}
		}
		$this->session->set_userdata(array('admin_message'=>'Subhead Restored'));
		redirect($_SERVER['HTTP_REFERER']);	
					
	}		

	public function index($row=0)
	{
		$query=array();
		if($this->p_view){
			if(isset($_GET['search'])){
			$limit=20;
			$row=$this->input->get('per_page');	
			$this->data['from']=$from=$this->input->get('from');
			$this->data['to']=$to=$this->input->get('to');
			$this->data['action']=$action=$this->input->get('action');	
			$this->data['user']=$user=$this->input->get('user');	
			$this->data['type']=$type=$this->input->get('type');
			$this->data['id']=$id=$this->input->get('id');
			$this->data['keyword']=$keyword=$this->input->get('keyword');
			$config['base_url']=base_url().'logs?id='.$id.'&keyword='.$keyword.'&from='.$from.'&to='.$to.'&action='.$action.'&user='.$user.'&type='.$type.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$query=$this->Log->GetLogs($id,$keyword,$from, $to, $user,$type,$action,'0',$row,$limit);
			$total_row=count($this->Log->GetLogs($id,$keyword,$from, $to, $user,$type,$action,'0',0,0));
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$config['total_rows'] =$total_row;
			$config['per_page'] = $limit;
			$config['num_links'] = 6;
			$this->pagination->initialize($config);
			$this->data['total_row']=$total_row;
			$this->data['links']=$this->pagination->create_links();

			
			}
		elseif(isset($_GET['clear'])){
			redirect('logs');	
			}	
			
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Logs');
			//$this->breadcrumb->add_crumb('Companies','logs/companies/');
			$this->data['subtitle'] = 'Logs';	
			$this->data['query']=$query;
			$this->data['users']=$this->Administrator->GetAllUsers();
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Companies";
			$this->template->load('_template', 'logs/logs', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	

	public function companies($row=0)
	{
		$query=array();
		if($this->p_view_company){
			if(isset($_GET['search'])){
			$limit=20;
			$row=$this->input->get('per_page');	
			$this->data['from']=$from=$this->input->get('from');
			$this->data['to']=$to=$this->input->get('to');
			$this->data['action']=$action=$this->input->get('action');	
			$config['base_url']=base_url().'logs/companies?from='.$from.'&to='.$to.'&action='.$action.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$query=$this->Log->GetCompanies($from,$to,$action,$row,$limit);
			$total_row=count($this->Log->GetCompanies($from,$to,$action,0,0));
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$config['total_rows'] =$total_row;
			$config['per_page'] = $limit;
			$config['num_links'] = 6;
			$this->pagination->initialize($config);
			$this->data['total_row']=$total_row;
			$this->data['links']=$this->pagination->create_links();

			
			}
		elseif(isset($_GET['clear'])){
			redirect('logs/companies');	
			}	
			
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Logs');
			$this->breadcrumb->add_crumb('Companies','logs/companies/');
			$this->data['subtitle'] = 'Companies';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Companies";
			$this->template->load('_template', 'logs/companies', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	

public function company_details($id)
	{
		$this->data['logs']=$row=$this->Log->GetLogById($id);
		$query=json_decode($row['details'],TRUE);
		$_items=array();
		$_banks=array();
		$_markets=array();
		$_insurances=array();
		$_power=array();
		$others=$this->Log->GetLogs('','', '','','','','delete',$id,0,0);
	//	GetLogs($id='',$keyword='',$from='', $to='', $user='',$type='',$action='',$logs_id='',$row,$limit)
		foreach($others as $other){
			switch ($other->type) {
				case 'company_heading':
					$_items=json_decode($other->details);
					break;
				case 'power_company':
					$_power=json_decode($other->details);
					break;
				case 'insurances_company':
					$_insurances=json_decode($other->details);
					break;
					case 'banks_company':
					$_banks=json_decode($other->details);
					break;
					case 'markets_company':
					$_markets=json_decode($other->details);
					break;
			}
		}
		//var_dump($query);
		$this->data['query']=$query;
		$this->data['id']=$id;
		$this->data['msg']=$this->session->userdata('admin_message');
		
		$this->data['title'] = $query['name_en']." - ".$query['name_ar'];
		$this->data['subtitle'] = "Companies - الشركات";
		$this->data['sectors']=$this->Item->GetSector('online',0,0);
		$this->data['sections']=$this->Item->GetSection('online',0,0);
		$this->data['governorates']=$this->Address->GetGovernorateById($query['governorate_id']);
		$this->data['districts']=$this->Address->GetDistrictById($query['district_id']);
		$this->data['area']=$this->Address->GetAreaById($query['area_id']);
		$this->data['items']=$_items;
		$this->data['banks']=$_banks;
		$this->data['markets']=$_markets;
		$this->data['insurances']=$_insurances;
		$this->data['powers']=$_power;
		$this->data['company_types']=$this->Company->GetCompanyTypes('online');
		
		$this->data['industrial_room']=$this->Company->GetIndustrialRoomById($query['iro_code']);
		$this->data['industrial_group']=$this->Company->GetIndustrialGroupById($query['igr_code']);
		$this->data['economical_assembly']=$this->Company->GetEconomicalAssemblyById($query['eas_code']);
		
		$this->data['salesman']=$this->General->GetSalesManById($query['sales_man_id']);
		$this->data['position']=$this->Item->GetPositionById($query['position_id']);
		
		$this->data['license']=$this->Company->GetLicenseSourceById($query['license_source_id']);
		$this->load->view('logs/company_details', $this->data);	
	}
	public function banks($row=0)
	{
		$query=array();
		if($this->p_view_bank){
			if(isset($_GET['search'])){
			$limit=20;
			$row=$this->input->get('per_page');	
			$this->data['from']=$from=$this->input->get('from');
			$this->data['to']=$to=$this->input->get('to');
			$this->data['action']=$action=$this->input->get('action');	
			$config['base_url']=base_url().'logs/banks?from='.$from.'&to='.$to.'&action='.$action.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$query=$this->Log->GetBanks($from,$to,$action,$row,$limit);
			$total_row=count($this->Log->GetBanks($from,$to,$action,0,0));
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$config['total_rows'] =$total_row;
			$config['per_page'] = $limit;
			$config['num_links'] = 6;
			$this->pagination->initialize($config);
			$this->data['total_row']=$total_row;
			$this->data['links']=$this->pagination->create_links();

			
			}
		elseif(isset($_GET['clear'])){
			redirect('logs/banks');	
			}	
			
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Logs');
			$this->breadcrumb->add_crumb('Banks','logs/banks/');
			$this->data['subtitle'] = 'Banks';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Banks";
			$this->template->load('_template', 'logs/banks', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	

public function bank_details($id)
	{
		$this->data['logs']=$row=$this->Log->GetLogById($id);
		
		$query=json_decode($row['details'],TRUE);
		
		$this->data['query']=$query;
		$this->data['id']=$id;
		$this->data['msg']=$this->session->userdata('admin_message');
		
		$this->data['title'] = $query['name_en']." - ".$query['name_ar'];
		$this->data['subtitle'] = "Banks - المصارف";

		$this->data['governorates']=$this->Address->GetGovernorateById($query['governorate_id']);
		$this->data['districts']=$this->Address->GetDistrictById($query['district_id']);
		$this->data['area']=$this->Address->GetAreaById($query['area_id']);
		
		$others=$this->Log->GetLogs('','', '','','','','delete',$id,0,0);
		foreach($others as $other){
			switch ($other->type) {
				case 'banks_directors':
					$_directors=json_decode($other->details);
					break;
				case 'banks_branches':
					$_branches=json_decode($other->details);
					break;
			} 
		}
		$this->data['directors']=@$_directors;
		$this->data['branches']=@$_branches;
		$this->data['salesman']=$this->General->GetSalesManById($query['sales_man_id']);
		//$this->data['position']=$this->Item->GetPositionById($query['position_id']);
		
		$this->data['license']=$this->Company->GetLicenseSourceById($query['license_source_id']);
		$this->load->view('logs/bank_details', $this->data);	
	}
 public function insurances($row=0)
	{
		$query=array();
		if($this->p_view_insurance){
			if(isset($_GET['search'])){
			$limit=20;
			$row=$this->input->get('per_page');	
			$this->data['from']=$from=$this->input->get('from');
			$this->data['to']=$to=$this->input->get('to');
			$this->data['action']=$action=$this->input->get('action');	
			$config['base_url']=base_url().'logs/insurances?from='.$from.'&to='.$to.'&action='.$action.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$query=$this->Log->GetInsurances($from,$to,$action,$row,$limit);
			$total_row=count($this->Log->GetInsurances($from,$to,$action,0,0));
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$config['total_rows'] =$total_row;
			$config['per_page'] = $limit;
			$config['num_links'] = 6;
			$this->pagination->initialize($config);
			$this->data['total_row']=$total_row;
			$this->data['links']=$this->pagination->create_links();

			
			}
		elseif(isset($_GET['clear'])){
			redirect('logs/insurances');	
			}	
			
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Logs');
			$this->breadcrumb->add_crumb('Insurances','logs/insurances/');
			$this->data['subtitle'] = 'Insurances';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Insurances";
			$this->template->load('_template', 'logs/insurances', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	

public function insurance_details($id)
	{
		$this->data['logs']=$row=$this->Log->GetLogById($id);
		
		$query=json_decode($row['details'],TRUE);
		$_directors=array();
		$_branches=array();
		$_managers=array();
		$this->data['query']=$query;
		$this->data['id']=$id;
		$this->data['msg']=$this->session->userdata('admin_message');
		
		$this->data['title'] = $query['name_en']." - ".$query['name_ar'];
		$this->data['subtitle'] = "Insurance Company - شركات التأمين";

		$this->data['governorates']=$this->Address->GetGovernorateById($query['governorate_id']);
		$this->data['districts']=$this->Address->GetDistrictById($query['district_id']);
		$this->data['area']=$this->Address->GetAreaById($query['area_id']);
		$others=$this->Log->GetLogs('','', '','','','','delete',$id,0,0);
		foreach($others as $other){
			switch ($other->type) {
				case 'insurance_directors':
					$_directors=json_decode($other->details);
					break;
				case 'insurance_branches':
					$_branches=json_decode($other->details);
					break;
					case 'insurance_managers':
					$_managers=json_decode($other->details);
					break;
			} 
		}
		$this->data['directors']=$_directors;
		$this->data['branches']=$_branches;
		$this->data['executives']=$_managers;
		$ids=explode(',',$query['activities']);

		$this->data['salesman']=$this->General->GetSalesManById($query['sales_man_id']);
		$this->data['activities']=$this->Insurance->GetActivitiesByIds($ids);
		
		$this->data['license']=$this->Company->GetLicenseSourceById($query['license_source_id']);
		$this->load->view('logs/insurance_details', $this->data);	
	}
 public function importers($row=0)
	{
		$query=array();
		if($this->p_view_importer){
			if(isset($_GET['search'])){
			$limit=20;
			$row=$this->input->get('per_page');	
			$this->data['from']=$from=$this->input->get('from');
			$this->data['to']=$to=$this->input->get('to');
			$this->data['action']=$action=$this->input->get('action');	
			$config['base_url']=base_url().'logs/importers?from='.$from.'&to='.$to.'&action='.$action.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$query=$this->Log->GetImporters($from,$to,$action,$row,$limit);
			$total_row=count($this->Log->GetImporters($from,$to,$action,0,0));
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$config['total_rows'] =$total_row;
			$config['per_page'] = $limit;
			$config['num_links'] = 6;
			$this->pagination->initialize($config);
			$this->data['total_row']=$total_row;
			$this->data['links']=$this->pagination->create_links();

			
			}
		elseif(isset($_GET['clear'])){
			redirect('logs/importers');	
			}	
			
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Logs');
			$this->breadcrumb->add_crumb('Importers','logs/importers/');
			$this->data['subtitle'] = 'Importers';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Importers";
			$this->template->load('_template', 'logs/importers', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	
public function importer_details($id)
	{
		$this->data['logs']=$row=$this->Log->GetlogById($id);
		$_fcompanies=array();
		$query=json_decode($row['details'],TRUE);
		
		$this->data['query']=$query;
		$this->data['id']=$id;
		$this->data['msg']=$this->session->userdata('admin_message');
		
		$this->data['title'] = $query['name_en']." - ".$query['name_ar'];
		$this->data['subtitle'] = "Importers - المستوردون";

		$this->data['governorates']=$this->Address->GetGovernorateById($query['governorate_id']);
		$this->data['districts']=$this->Address->GetDistrictById($query['district_id']);
		$this->data['area']=$this->Address->GetAreaById($query['area_id']);
		
			$others=$this->Log->GetLogs('','', '','','','','delete',$id,0,0);
			foreach($others as $other){
				switch ($other->type) {
					case 'mporter_foreigns':
						$_fcompanies=json_decode($other->details);
						break;
				} 
			}
		$this->data['fcompanies']=$_fcompanies;
				
		$this->data['salesman']=$this->General->GetSalesManById($query['sales_man_id']);
		$this->data['position']=$this->Item->GetPositionById(@$query['position_id']);
		$this->data['activities']=$this->Importer->GetImporterActivities();
		
		$this->load->view('logs/importer_details', $this->data);	
	}
	       
public function transportations($row=0)
	{
		$query=array();
		if($this->p_view_transportation){
			if(isset($_GET['search'])){
			$limit=20;
			$row=$this->input->get('per_page');	
			$this->data['from']=$from=$this->input->get('from');
			$this->data['to']=$to=$this->input->get('to');
			$this->data['action']=$action=$this->input->get('action');	
			$config['base_url']=base_url().'logs/transportations?from='.$from.'&to='.$to.'&action='.$action.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$query=$this->Log->GetTransportations($from,$to,$action,$row,$limit);
			$total_row=count($this->Log->GetTransportations($from,$to,$action,0,0));
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$config['total_rows'] =$total_row;
			$config['per_page'] = $limit;
			$config['num_links'] = 6;
			$this->pagination->initialize($config);
			$this->data['total_row']=$total_row;
			$this->data['links']=$this->pagination->create_links();

			
			}
		elseif(isset($_GET['clear'])){
			redirect('logs/transportations');	
			}	
			
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Logs');
			$this->breadcrumb->add_crumb('Transportations','logs/transportations/');
			$this->data['subtitle'] = 'Transportation';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Transportation";
			$this->template->load('_template', 'logs/transportations', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	
public function transportation_details($id)
	{
		$this->data['logs']=$row=$this->Log->GetLogById($id);
		$_linesrs=array();
		$_branches=array();
		$_ports=array();
		$query=json_decode($row['details'],TRUE);
		
		$this->data['query']=$query;
		$this->data['id']=$id;
		$this->data['msg']=$this->session->userdata('admin_message');
		
		$this->data['title'] = $query['name_en']." - ".$query['name_ar'];
		$this->data['subtitle'] = "Transportation - شركات النقل";

		$this->data['governorates']=$this->Address->GetGovernorateById($query['governorate_id']);
		$this->data['districts']=$this->Address->GetDistrictById($query['district_id']);
		$this->data['area']=$this->Address->GetAreaById($query['area_id']);
		
		$others=$this->Log->GetLogs('','', '','','','','delete',$id,0,0);
		foreach($others as $other){
			switch ($other->type) {
				case 'transportation_line_represented':
					$_linesrs=json_decode($other->details);
					break;
				case 'transportation_branches':
					$_branches=json_decode($other->details);
					break;
					case 'transportation_ports':
					$_ports=json_decode($other->details);
					break;
			} 
		}

		$this->data['represented']=$_linesrs;
		$this->data['branches']=$_branches;
		$this->data['ports']=$_ports;
		
		$this->data['services']=$this->Transport->GetTransportServices();
		
		$this->data['salesman']=$this->General->GetSalesManById($query['sales_man_id']);
		$this->data['position']=$this->Item->GetPositionById($query['position_id']);
		$this->data['license']=$this->Company->GetLicenseSourceById($query['license_source_id']);
		
		$this->load->view('logs/transportation_details', $this->data);	
	}
public function users($row=0)
	{
		$query=array();
		if($this->p_view_user){
			if(isset($_GET['search'])){
			$limit=20;
			$row=$this->input->get('per_page');	
			$this->data['from']=$from=$this->input->get('from');
			$this->data['to']=$to=$this->input->get('to');
			$this->data['user']=$user=$this->input->get('user');	
			$this->data['type']=$type=$this->input->get('type');
			$config['base_url']=base_url().'logs/users?from='.$from.'&to='.$to.'&user='.$user.'&type='.$type.'&search=Search';	
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			switch($type)
			{
				case 'company':
					$this->data['companies']=$companies=$this->Log->GetCompaniesByUser($from,$to,$user,$row,$limit);
					$total_row=count($this->Log->GetCompaniesByUser($from,$to,$user,0,0));
				break;
				case 'bank':
					$this->data['banks']=$banks=$this->Log->GetBanksByUser($from,$to,$user,$row,$limit);
					$total_row=count($this->Log->GetBanksByUser($from,$to,$user,0,0));		
				break;
				
				case 'insurance':
					$this->data['insurances']=$insurances=$this->Log->GetInsurancesByUser($from,$to,$user,$row,$limit);
					$total_row=count($this->Log->GetInsuranceByUser($from,$to,$user,0,0));		
		
				break;
				case 'importer':
					$this->data['importers']=$importers=$this->Log->GetImportersByUser($from,$to,$user,$row,$limit);
					$total_row=count($this->Log->GetImportersByUser($from,$to,$user,0,0));		
			
				break;
				case 'transportation':
				$this->data['transportations']=$transportations=$this->Log->GetTransportationsByUser($from,$to,$user,$row,$limit);
				$total_row=count($this->Log->GetTransportationsByUser($from,$to,$user,0,0));		
	
				break;

				
				}
			//$query=$this->Log->GetTransportations($from,$to,$action,$row,$limit);
			//$total_row=count($this->Log->GetTransportations($from,$to,$action,0,0));
			$config['enable_query_strings'] = TRUE;
			$config['page_query_string'] = TRUE; 
			$config['total_rows'] =$total_row;
			$config['per_page'] = $limit;
			$config['num_links'] = 6;
			$this->pagination->initialize($config);
			$this->data['total_row']=$total_row;
			$this->data['links']=$this->pagination->create_links();

			
			}
		elseif(isset($_GET['clear'])){
			redirect('logs/users');	
			}	
			
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Logs');
			$this->breadcrumb->add_crumb('Users','logs/users/');
			$this->data['subtitle'] = 'Users';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Users";
			$this->data['users']=$this->Administrator->GetAllUsers();
			$this->template->load('_template', 'logs/users', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	
	
									
}

?>