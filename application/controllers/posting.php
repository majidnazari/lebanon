<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posting extends Application {
	public function __construct()
	{

		parent::__construct();
		$this->load->model(array('Administrator','Item','Address','Company','Bank','Insurance','Parameter'));
						
	}
	public function GetDistricts()
	{
		echo '<script>
        $(document).ready(function() {
            $("#district_id").select2();   
        });
    </script>';
			$jsdis='id="district_id" onchange="getarea(this.value)" class="search-select" required="required"';
		$gov_id	= $_POST['id'];
		$districts=$this->Address->GetDistrictByGov('online',$gov_id);
		if(count($districts)>0){
		$array_districts['']='All';
		foreach($districts as $district)
			{
				$array_districts[$district->id]=$district->label_ar.' ('.$district->label_en.')';
			}
		}
		else{
				$array_districts['']='No Data Found';
			}			
		echo form_dropdown('district_id',$array_districts,'',$jsdis);
				}	
	public function GetArea()
	{
		echo '<script>
        $(document).ready(function() {
            $("#area_id").select2();   
        });
    </script>';
		$dist_id	= $_POST['id'];
		if(isset($_POST['area_id'])){
		$area_id	= $_POST['area_id'];
		}
		else{
			$area_id	= 0;
			}
		$areas=$this->Address->GetAreaByDistrict('online',$dist_id);
		if(count($areas)>0){
		$array_area['']='All';
		foreach($areas as $area)
			{
				$array_area[$area->id]=$area->label_ar.' ('.$area->label_en.')';
			}
		}
		else{
				$array_area[0]='No Data Found';
			}	
					
		echo form_dropdown('area_id',$array_area,$area_id,' id="area_id" class="search-select" required="required"');
				}				
							
	public function companies($id)
	{
			$this->form_validation->set_rules('name_ar', 'company name in arabic', 'required');
			if ($this->form_validation->run()) {
				/*
				$array=$this->Administrator->do_upload('uploads/');
				
				if($array['target_path']!=""){
					$path=$array['target_path'];
				}
				else{
					$path=$this->input->post('logo');
					}

				$msg=$array['error'];	
				
				$x1=$this->input->post('x1');	
				$x2=$this->input->post('x2');	
				$x3=$this->input->post('x3');	
				$x=$x1.'°'.$x2."'".$x3.'"';
				
				$y1=$this->input->post('y1');	
				$y2=$this->input->post('y2');	
				$y3=$this->input->post('y3');	
				$y=$y1.'°'.$y2."'".$y3.'"';
				*/
				$data = array(
				'company_id'=> $this->input->post('id'),
				'name_ar'=> $this->input->post('name_ar'),
				'name_en'=> $this->input->post('name_en'),
				//'sector_id'=> $this->input->post('sector_id'),
				//'establish_date'=> $this->input->post('establish_date'),
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
				'x_decimal'=> $this->input->post('x_decimal'),
				'y_decimal'=> $this->input->post('y_decimal'),
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
				'owner_name_en'=> $this->input->post('owner_name_en'),
				'copy_res'=> $this->input->post('copy_res'),
				'is_adv'=> $this->input->post('is_adv'),
				'entry_date'=> $this->input->post('entry_date'),
				'trade_license'=> $this->input->post('trade_license'),
				'auth_person_ar'=> $this->input->post('auth_person_ar'),
				'auth_person_en'=> $this->input->post('auth_person_en'),
				
				'license_date'=> $this->input->post('license_date'),
				'license_source_ar'=> $this->input->post('license_source_ar'),
				'license_source_en'=> $this->input->post('license_source_en'),
				'license_type'=> $this->input->post('license_type'),
				'app_fill_date'=> date('Y-m-d H:i:s'),
				'personal_notes'=> $this->input->post('personal_notes'),
				'ind_association'=> $this->input->post('ind_association'),
				'license_source_id'=> $this->input->post('license_source_id'),
				'is_exporter'=> $this->input->post('is_exporter'), 
				'productions'=> $this->input->post('productions'), 
				
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
			
				if($id=$this->General->save('posting_companies',$data))
				{
					$this->session->set_userdata(array('admin_message'=>'Company Added successfully'));	
					echo '<center><h3>Application has been submited</h3></center>';
					//redirect('posting/company-msg/'.$id);
				}
				else
				{
					$this->session->set_userdata(array('admin_message'=>'Error'));	
					redirect('posting/companies/'.$id);					
				}
				
			 }
			 	$query=$this->Company->GetCompanyById($id);
				$this->data['query']=$query;
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
				
				$this->data['title'] = "Lebanon Industry - ".$query['name_ar'];
				//$this->load->view('posting/_header', $this->data);	
				$this->load->view('posting/company', $this->data);	
					
			
	}	
		
}
