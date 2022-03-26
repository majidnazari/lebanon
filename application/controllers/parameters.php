<?php

class Parameters extends Application
{
	var $p_delete_position=FALSE;
	var $p_edit_position=FALSE;
	var $p_add_position=FALSE;
	var $p_view_position=FALSE;
	
	var $p_delete_salesman=FALSE;
	var $p_edit_salesman=FALSE;
	var $p_add_salesman=FALSE;
	var $p_view_salesman=FALSE;

	var $p_delete_industrialroom=FALSE;
	var $p_edit_industrialroom=FALSE;
	var $p_add_industrialroom=FALSE;
	var $p_view_industrialroom=FALSE;

	var $p_delete_companytype=FALSE;
	var $p_edit_companytype=FALSE;
	var $p_add_companytype=FALSE;
	var $p_view_companytype=FALSE;

	var $p_delete_economicalunion=FALSE;
	var $p_edit_economicalunion=FALSE;
	var $p_add_economicalunion=FALSE;
	var $p_view_economicalunion=FALSE;

	var $p_delete_industrialgroup=FALSE;
	var $p_edit_industrialgroup=FALSE;
	var $p_add_industrialgroup=FALSE;
	var $p_view_industrialgroup=FALSE;

	var $p_delete_economicalassembly=FALSE;
	var $p_edit_economicalassembly=FALSE;
	var $p_add_economicalassembly=FALSE;
	var $p_view_economicalassembly=FALSE;

	var $p_delete_licensesources=FALSE;
	var $p_edit_licensesources=FALSE;
	var $p_add_licensesources=FALSE;
	var $p_view_licensesources=FALSE;

	var $p_delete_insuranceactivity=FALSE;
	var $p_edit_insuranceactivity=FALSE;
	var $p_add_insuranceactivity=FALSE;
	var $p_view_insuranceactivity=FALSE;

	var $p_delete_companymarket=FALSE;
	var $p_edit_companymarket=FALSE;
	var $p_add_companymarket=FALSE;
	var $p_view_companymarket=FALSE;

	var $page_denied=FALSE;
	
	
	public function __construct()
	{

		parent::__construct();
		$this->ag_auth->restrict('parameters'); // restrict this controller to admins only
		$this->load->model(array('Administrator','Item','Address','Company','Bank','Parameter'));
		$this->data['Ctitle']='Industry - Parameters ';
		
		$this->p_delete_position=$this->ag_auth->check_privilege(39,'delete');
		$this->p_edit_position=$this->ag_auth->check_privilege(39,'edit');
		$this->p_add_position=$this->ag_auth->check_privilege(39,'add');
		$this->p_view_position=$this->ag_auth->check_privilege(39,'view');
		$this->p_changing_position=$this->ag_auth->check_privilege(39,'changing_position');
		$this->data['p_delete_position']=$this->p_delete_position;
		$this->data['p_edit_position']=$this->p_edit_position;
		$this->data['p_add_position']=$this->p_add_position;
		$this->data['p_view_position']=$this->p_view_position;
		$this->data['p_changing_position']=$this->p_changing_position;
		
		$this->p_delete_salesman=$this->ag_auth->check_privilege(40,'delete');
		$this->p_edit_salesman=$this->ag_auth->check_privilege(40,'edit');
		$this->p_add_salesman=$this->ag_auth->check_privilege(40,'add');
		$this->p_view_salesman=$this->ag_auth->check_privilege(40,'view');
		$this->data['p_delete_salesman']=$this->p_delete_salesman;
		$this->data['p_edit_salesman']=$this->p_edit_salesman;
		$this->data['p_add_salesman']=$this->p_add_salesman;
		$this->data['p_view_salesman']=$this->p_view_salesman;

		$this->p_delete_industrialroom=$this->ag_auth->check_privilege(41,'delete');
		$this->p_edit_industrialroom=$this->ag_auth->check_privilege(41,'edit');
		$this->p_add_industrialroom=$this->ag_auth->check_privilege(41,'add');
		$this->p_view_industrialroom=$this->ag_auth->check_privilege(41,'view');
		$this->data['p_delete_industrialroom']=$this->p_delete_industrialroom;
		$this->data['p_edit_industrialroom']=$this->p_edit_industrialroom;
		$this->data['p_add_industrialroom']=$this->p_add_industrialroom;
		$this->data['p_view_industrialroom']=$this->p_view_industrialroom;

		$this->p_delete_companytype=$this->ag_auth->check_privilege(42,'delete');
		$this->p_edit_companytype=$this->ag_auth->check_privilege(42,'edit');
		$this->p_add_companytype=$this->ag_auth->check_privilege(42,'add');
		$this->p_view_companytype=$this->ag_auth->check_privilege(42,'view');
		$this->data['p_delete_companytype']=$this->p_delete_companytype;
		$this->data['p_edit_companytype']=$this->p_edit_companytype;
		$this->data['p_add_companytype']=$this->p_add_companytype;
		$this->data['p_view_companytype']=$this->p_view_companytype;
	
		$this->p_delete_companytype=$this->ag_auth->check_privilege(42,'delete');
		$this->p_edit_companytype=$this->ag_auth->check_privilege(42,'edit');
		$this->p_add_companytype=$this->ag_auth->check_privilege(42,'add');
		$this->p_view_companytype=$this->ag_auth->check_privilege(42,'view');
		$this->data['p_delete_companytype']=$this->p_delete_companytype;
		$this->data['p_edit_companytype']=$this->p_edit_companytype;
		$this->data['p_add_companytype']=$this->p_add_companytype;
		$this->data['p_view_companytype']=$this->p_view_companytype;
	
		$this->p_delete_economicalunion=$this->ag_auth->check_privilege(43,'delete');
		$this->p_edit_economicalunion=$this->ag_auth->check_privilege(43,'edit');
		$this->p_add_economicalunion=$this->ag_auth->check_privilege(43,'add');
		$this->p_view_economicalunion=$this->ag_auth->check_privilege(43,'view');
		$this->data['p_delete_economicalunion']=$this->p_delete_economicalunion;
		$this->data['p_edit_economicalunion']=$this->p_edit_economicalunion;
		$this->data['p_add_economicalunion']=$this->p_add_economicalunion;
		$this->data['p_view_economicalunion']=$this->p_view_economicalunion;


		$this->p_delete_industrialgroup=$this->ag_auth->check_privilege(45,'delete');
		$this->p_edit_industrialgroup=$this->ag_auth->check_privilege(45,'edit');
		$this->p_add_industrialgroup=$this->ag_auth->check_privilege(45,'add');
		$this->p_view_industrialgroup=$this->ag_auth->check_privilege(45,'view');
		$this->data['p_delete_industrialgroup']=$this->p_delete_industrialgroup;
		$this->data['p_edit_industrialgroup']=$this->p_edit_industrialgroup;
		$this->data['p_add_industrialgroup']=$this->p_add_industrialgroup;
		$this->data['p_view_industrialgroup']=$this->p_view_industrialgroup;

		$this->p_delete_economicalassembly=$this->ag_auth->check_privilege(46,'delete');
		$this->p_edit_economicalassembly=$this->ag_auth->check_privilege(46,'edit');
		$this->p_add_economicalassembly=$this->ag_auth->check_privilege(46,'add');
		$this->p_view_economicalassembly=$this->ag_auth->check_privilege(46,'view');
		$this->data['p_delete_economicalassembly']=$this->p_delete_economicalassembly;
		$this->data['p_edit_economicalassembly']=$this->p_edit_economicalassembly;
		$this->data['p_add_economicalassembly']=$this->p_add_economicalassembly;
		$this->data['p_view_economicalassembly']=$this->p_view_economicalassembly;

		$this->p_delete_licensesources=$this->ag_auth->check_privilege(46,'delete');
		$this->p_edit_licensesources=$this->ag_auth->check_privilege(46,'edit');
		$this->p_add_licensesources=$this->ag_auth->check_privilege(46,'add');
		$this->p_view_licensesources=$this->ag_auth->check_privilege(46,'view');
		$this->data['p_delete_licensesources']=$this->p_delete_licensesources;
		$this->data['p_edit_licensesources']=$this->p_edit_licensesources;
		$this->data['p_add_licensesources']=$this->p_add_licensesources;
		$this->data['p_view_licensesources']=$this->p_view_licensesources;
		
		$this->p_delete_insuranceactivity=$this->ag_auth->check_privilege(58,'delete');
		$this->p_edit_insuranceactivity=$this->ag_auth->check_privilege(58,'edit');
		$this->p_add_insuranceactivity=$this->ag_auth->check_privilege(58,'add');
		$this->p_view_insuranceactivity=$this->ag_auth->check_privilege(58,'view');
		$this->data['p_delete_insuranceactivity']=$this->p_delete_insuranceactivity;
		$this->data['p_edit_insuranceactivity']=$this->p_edit_insuranceactivity;
		$this->data['p_add_insuranceactivity']=$this->p_add_insuranceactivity;
		$this->data['p_view_insuranceactivity']=$this->p_view_insuranceactivity;

		$this->p_delete_importeractivity=$this->ag_auth->check_privilege(59,'delete');
		$this->p_edit_importeractivity=$this->ag_auth->check_privilege(59,'edit');
		$this->p_add_importeractivity=$this->ag_auth->check_privilege(59,'add');
		$this->p_view_importeractivity=$this->ag_auth->check_privilege(59,'view');
		$this->data['p_delete_importeractivity']=$this->p_delete_importeractivity;
		$this->data['p_edit_importeractivity']=$this->p_edit_importeractivity;
		$this->data['p_add_importeractivity']=$this->p_add_importeractivity;
		$this->data['p_view_importeractivity']=$this->p_view_importeractivity;

		$this->p_delete_companymarket=$this->ag_auth->check_privilege(60,'delete');
		$this->p_edit_companymarket=$this->ag_auth->check_privilege(60,'edit');
		$this->p_add_companymarket=$this->ag_auth->check_privilege(60,'add');
		$this->p_view_companymarket=$this->ag_auth->check_privilege(60,'view');
		$this->data['p_delete_companymarket']=$this->p_delete_companymarket;
		$this->data['p_edit_companymarket']=$this->p_edit_companymarket;
		$this->data['p_add_companymarket']=$this->p_add_companymarket;
		$this->data['p_view_companymarket']=$this->p_view_companymarket;
	
		$this->page_denied='denied';
		$this->data['page_denied']=$this->page_denied;
		
			
						
	}
		public function delete()
	{
		$get = $this->uri->ruri_to_assoc();
		if((int)$get['id'] > 0){
			switch($get['p'])
			{
				case 'position':
				if($this->p_delete_position){
					$query=$this->Parameter->GetPositionById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'position','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);

					$this->General->delete('tbl_positions',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/positions');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}
				break;
				
				case 'salesman': 
				if($this->p_delete_salesman){
					$query=$this->Parameter->GetSalesmanById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'salesman','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_sales_man',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/salesman');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}			
				break;
				
				case 'industrialroom':
				if($this->p_delete_salesman){
					$query=$this->Parameter->GetIndustrialRoomById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'industrialroom','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_industrial_room',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/industrial-room');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}					
				break;
				case 'companytype':
				if($this->p_delete_companytype){
					$query=$this->Parameter->GetCompanyTypeById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'companytype','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_company_type',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/company-types');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}					
				break;
				
				case 'economicalunion':
				if($this->p_delete_economicalunion){
					$query=$this->Parameter->GetEconomicalUnionById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'economicalunion','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_technical_union',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/economical-union');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}				
				break;

				case 'industrialgroup':
				if($this->p_delete_industrialgroup){
					$query=$this->Parameter->GetIndustrialGroupById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'industrialgroup','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_industrial_group',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/industrial-group');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}				
				break;
				case 'economicalassembly':
				if($this->p_delete_economicalassembly){
					$query=$this->Parameter->GetEconomicalAssemblyById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'economicalassembly','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_economical_assembly',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/economical-assembly');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}				
				break;
				
				case 'licensesources':
				if($this->p_delete_licensesources){
					$query=$this->Parameter->GetLicenseSourcesById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'licensesources','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_license_sources',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/license-sources');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}				
				break;
				
				case 'insuranceactivity':
				if($this->p_delete_insuranceactivity){
					$query=$this->Parameter->GetInsuranceActivityById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'insuranceactivity','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_insurance_activities',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/insurance-activities');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}				
				break;
				case 'importeractivity':
				if($this->p_delete_importeractivity){
					$query=$this->Parameter->GetImporterActivityById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'importeractivity','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_importer_activities',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/importer-activities');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}				
				break;
				
				case 'companymarket':
				if($this->p_delete_companymarket){
					$query=$this->Parameter->GetCompanyMarketById($get['id']);
					$history=array('action'=>'delete','logs_id'=>0,'item_id'=>$get['id'],'item_title'=>$query['label_ar'],'type'=>'companymarket','details'=>json_encode($query),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
					$h_id=$this->General->save('logs',$history);
					$this->General->delete('tbl_importer_activities',array('id'=>$get['id']));
					$this->session->set_userdata(array('admin_message'=>'Deleted'));
					redirect('parameters/importer-activities');	
				}
				else{
					$this->session->set_userdata(array('admin_message'=>'Access Denied'));
					redirect($this->page_denied);	
					}				
				break;
		
				}

		 } 
	}
	public function company_markets()
	{
		if($this->p_view_companymarket){
			
			$query=$this->Parameter->GetCompanyMarkets();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Company Markets','parameters/company-markets/');
			$this->data['subtitle'] = 'Company Markets';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Company Markets";
			$this->template->load('_template', 'parameters/company_markets', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_company_market()
	{
		if($this->p_add_companymarket)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_markets',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'companymarket','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/company-markets/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_company_market()
	{
		if($this->p_edit_companymarket)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');
		
		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetCompanyMarketById($id);
		if($this->Administrator->edit('tbl_markets',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'companymarket','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/company-markets/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}


	public function positions()
	{
		if($this->p_view_position){
			
			$query=$this->Parameter->GetPositions();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Positions','parameters/positions/');
			$this->data['subtitle'] = 'Positions Item';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Positions";
			$this->template->load('_template', 'parameters/positions', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_position()
	{
		if($this->p_add_position)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_positions',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'position','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/positions/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_position()
	{
		if($this->p_edit_position)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');
		
		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetPositionById($id);
		if($this->Administrator->edit('tbl_positions',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'position','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/positions/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
	public function changing_position()
	{
		if($this->p_changing_position)
		{
		$old_position=$this->input->post('old_position');
		$new_position=$this->input->post('new_position');
		$companies=$this->Administrator->update('tbl_company',array('position_id'=>$new_position),array('position_id'=>$old_position));
		$banks=$this->Administrator->update('tbl_bank',array('position_id'=>$new_position),array('position_id'=>$old_position));
		$importers=$this->Administrator->update('tbl_importers',array('position_id'=>$new_position),array('position_id'=>$old_position));
		$insurances=$this->Administrator->update('tbl_insurances',array('position_id'=>$new_position),array('position_id'=>$old_position));
		$transport=$this->Administrator->update('tbl_transport',array('position_id'=>$new_position),array('position_id'=>$old_position));
		
		
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully<br>'.$companies.' companies<br>'.$banks.' banks<br>'.$importers.' importer companies<br>'.$insurances.' insurance companies<br>'.$transport.' transportation companies'));
			redirect('parameters/positions/');					
		
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

public function salesman()
	{
		if($this->p_view_salesman){
			
			$query=$this->Parameter->GetSalesmen();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Salesmen','parameters/salesman/');
			$this->data['subtitle'] = 'Salesmen';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Salesmen";
			$this->template->load('_template', 'parameters/salesman', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
	function export_salesman($lang = 'ar') { 
        // filename for download
        $filename = "SalesMan-".$lang.".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel,  charset=UTF-8; encoding=UTF-8");
        header('Content-type: text/html; charset=UTF-8');
        $flag = false;
        echo '<style type="text/css">
				.table tr td {
					border:1px solid #000;
				}
				.yellow{
				        font-weight: bold;
					}
				.table tr th{
					border:1px solid #FFF;
					background: #000;
					color: #FFF;
					font-weight: bold;
				}
				.htitle{
				border:1px solid #FFF !important;
				height:5px !important;
					}
				</style>   ';
                $query = $this->Parameter->GetSalesManToReport($lang);
                        $x=TRUE;
                        echo '<body style="width:1080;font-family: Arial;"><table style="width:1080px !important; border:1px solid #000;" cellpadding="0" cellspacing="0" width="1080" class="table">';
                       if($lang == 'ar') {
                        echo'<tr>   
                                <th>وقت الإنشاء </th>  
								<th>حالة</th>                              
								<th>هاتف</th>
								<th>عنوان</th>
                                <th style="width: 250px !important;">اسم </th>
                            </tr>
                        ';
                       }
                       else{
                            echo'<tr>
                                    <th style="width: 250px !important;">FullName</th>
                                    <th>Address</th>
                                    <th>Phone</th>
									<th>Status</th>
                                    <th>Created Time</th>
                                  
                                    
                                </tr>';
                       }
                        foreach($query as $row) {
                             if(@$row->is_adv == 1)
                                        $css_ex = 'font-weight:bold; font-size:14px !important';
                                    elseif(@$row->copy_res == 1)
                                        $css_ex = 'font-weight:bold; font-size:13px !important';
                                    else
                                        $css_ex = 'font-size:12px !important';
                                        if($lang=='ar'){
                                         echo '<tr>
                                           
                                            <td style="text-align:center; '.$css_ex.'">'.$row->create_time.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->status.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->address.'</td>
                                            <td style="direction:rtl !important; text-align:center !important; '.$css_ex.'">'.$row->fullname.'</td>
                                        </tr>';
                                        }
                                        else{
                                            echo '<tr>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->fullname_en.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->address.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->phone.'</td>
                                            <td style="text-align:center !important; '.$css_ex.'">'.$row->status.'</td>
                                            <td style="text-align:center; '.$css_ex.'">'.$row->create_time.'</td>
                                           
                                        </tr>'; 
                                        }
                            
                        }
        echo '</table></body>';
        exit;
    }	
	public function create_salesman()
	{ 
		if($this->p_add_salesman)
		{
		$fullname=$this->input->post('fullname');
		$fullname_en=$this->input->post('fullname_en');
		$phone=$this->input->post('phone');
		$address=$this->input->post('address');
		$status=$this->input->post('status');

		$data = array(
				'fullname'=> $fullname,
				'fullname_en'=> $fullname_en,
				'phone'=> $phone,
				'address'=> $address,
				'status'=> $status,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_sales_man',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'salesman','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/salesman/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_salesman()
	{
		if($this->p_edit_salesman)
		{
		$fullname=$this->input->post('fullname');
		$fullname_en=$this->input->post('fullname_en');
		$phone=$this->input->post('phone');
		$address=$this->input->post('address');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$data = array(
				'fullname'=> $fullname,
				'fullname_en'=> $fullname_en,
				'phone'=> $phone,
				'address'=> $address,
				'status'=> $status,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetSalesmanById($id);
		if($this->Administrator->edit('tbl_sales_man',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'salesman','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/salesman/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function industrial_room()
	{
		if($this->p_view_industrialroom){
			
			$query=$this->Parameter->GetIndustrialRooms();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Industrial Room','parameters/industrial-room/');
			$this->data['subtitle'] = 'Industrial Room';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Industrial Room";
			$this->template->load('_template', 'parameters/industrial_room', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_industrial_room()
	{
		if($this->p_add_industrialroom)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_industrial_room',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'industrialroom','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/industrial-room/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_industrial_room()
	{
		if($this->p_edit_industrialroom)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetIndustrialRoomById($id);
		if($this->Administrator->edit('tbl_industrial_room',$data,$id))
		{
			
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'industrialroom','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/industrial-room/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

public function company_types()
	{
		if($this->p_view_companytype){
			
			$query=$this->Parameter->GetCompanyTypes();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Company Types','parameters/company-type/');
			$this->data['subtitle'] = 'Company Types';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Company Types";
			$this->template->load('_template', 'parameters/company_types', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_company_type()
	{
		if($this->p_add_companytype)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_company_type',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'companytype','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/company-types/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_company_type()
	{
		if($this->p_edit_companytype)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetCompanyTypeById($id);
		if($this->Administrator->edit('tbl_company_type',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'companytype','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/company-types/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

public function economical_union()
	{
		if($this->p_view_economicalunion){
			
			$query=$this->Parameter->GetEconomicalUnion();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Economical Union','parameters/economical-union/');
			$this->data['subtitle'] = 'Economical Union';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Economical Union";
			$this->template->load('_template', 'parameters/economical_union', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_economical_union()
	{
		if($this->p_add_economicalunion)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_technical_union',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'economicalunion','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/economical-union/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_economical_union()
	{
		if($this->p_edit_economicalunion)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetEconomicalUnionById($id);
		if($this->Administrator->edit('tbl_technical_union',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'economicalunion','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/economical-union/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function industrial_group()
	{
		if($this->p_view_industrialgroup){
			
			$query=$this->Parameter->GetIndustrialGroups();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Industrial Group','parameters/industrial-group/');
			$this->data['subtitle'] = 'Industrial Group';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | industrial Group";
			$this->template->load('_template', 'parameters/industrial_group', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_industrial_group()
	{
		if($this->p_add_industrialgroup)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_industrial_group',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'industrialgroup','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/industrial-group/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_industrial_group()
	{
		if($this->p_edit_industrialgroup)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetIndustrialGroupById($id);
		if($this->Administrator->edit('tbl_industrial_group',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'industrialgroup','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/industrial-group/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function economical_assembly()
	{
		if($this->p_view_economicalassembly){
			
			$query=$this->Parameter->GetEconomicalAssembly();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Economical Assembly','parameters/economical-assembly/');
			$this->data['subtitle'] = 'Economical Assembly';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Economical Assembly";
			$this->template->load('_template', 'parameters/economical_assembly', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_economical_assembly()
	{
		if($this->p_add_economicalassembly)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_economical_assembly',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'economicalassembly','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/economical-assembly/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_economical_assembly()
	{
		if($this->p_edit_economicalassembly)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetEconomicalAssemblyById($id);
		if($this->Administrator->edit('tbl_economical_assembly',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'economicalassembly','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/economical-assembly/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}

public function license_sources()
	{
		if($this->p_view_licensesources){
			
			$query=$this->Parameter->GetLicenseSources();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('License Sources','parameters/license-sources/');
			$this->data['subtitle'] = 'License Sources';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | License Sources";
			$this->template->load('_template', 'parameters/license_sources', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_license_sources()
	{
		if($this->p_add_licensesources)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_license_sources',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'licensesources','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/license-sources/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_license_sources()
	{
		if($this->p_edit_licensesources)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetLicenseSourcesById($id);
		if($this->Administrator->edit('tbl_license_sources',$data,$id))
		{
			$query=$this->Parameter->GetLicenseSourcesById($id);
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'licensesources','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/license-sources/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function insurance_activities()
	{
		if($this->p_view_insuranceactivity){
			
			$query=$this->Parameter->GetInsuranceActivities();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Insurance Activities','parameters/insurance-activities/');
			$this->data['subtitle'] = 'Insurance Activities';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Insurance Activities";
			$this->template->load('_template', 'parameters/insurance_activities', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_insurance_activity()
	{
		if($this->p_add_insuranceactivity)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_insurance_activities',$data))
		{
			$history=array('action'=>'add','logs_id'=>0,'type'=>'insuranceactivity','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/insurance-activities/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_insurance_activity()
	{
		if($this->p_edit_insuranceactivity)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetInsuranceActivityById($id);
		if($this->Administrator->edit('tbl_insurance_activities',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'insuranceactivity','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);	
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/insurance-activities/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function importer_activities()
	{
		if($this->p_view_importeractivity){
			
			$query=$this->Parameter->GetImporterActivities();
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Dashboard','dashboard');
			$this->breadcrumb->add_crumb('Parameters');
			$this->breadcrumb->add_crumb('Importer Activities','parameters/importer-activities/');
			$this->data['subtitle'] = 'Importer Activities';	
			$this->data['query']=$query;
			$this->data['msg']=$this->session->userdata('admin_message');
			$this->session->unset_userdata('admin_message');		
			$this->data['title'] = $this->data['Ctitle']." | Importer Activities";
			$this->template->load('_template', 'parameters/importer_activities', $this->data);	
			}
		else{
			
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}	




	public function create_importer_activity()
	{
		if($this->p_add_importeractivity)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'create_time' =>  date('Y-m-d H:i:s'),
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);

		if($id=$this->General->save('tbl_importer_activities',$data))
		{
			$data['id']=$id;
			$history=array('action'=>'add','logs_id'=>0,'type'=>'importeractivity','details'=>json_encode($data),'item_id'=>$id,'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
            $this->General->save('logs',$history);
			$this->session->set_userdata(array('admin_message'=>'Add Successfully'));	
			redirect('parameters/importer-activities/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
public function edit_importer_activity()
	{
		if($this->p_edit_importeractivity)
		{
		$label_ar=$this->input->post('label_ar');
		$label_en=$this->input->post('label_en');
		$id=$this->input->post('id');

		$data = array(
				'label_ar'=> $label_ar,
				'label_en'=> $label_en,
				'update_time' =>  date('Y-m-d H:i:s'),
				'user_id' =>  $this->session->userdata('id'),
			);
		$query=$this->Parameter->GetImporterActivityById($id);
		if($this->Administrator->edit('tbl_importer_activities',$data,$id))
		{
			$newdata=$this->Administrator->affected_fields($query,$data);
			$history=array('action'=>'edit','logs_id'=>0,'item_id'=>$id,'item_title'=>$query['label_ar'],'type'=>'importeractivity','details'=>json_encode($newdata),'create_time'=>$this->datetime,'user_id' =>  $this->session->userdata('id'));
			$LID=$this->General->save('logs',$history);	
			$this->session->set_userdata(array('admin_message'=>'Updated Successfully'));
				
			redirect('parameters/importer-activities/');					
		}
		}
		else{
			$this->session->set_userdata(array('admin_message'=>'Access Denied'));	
			redirect($this->page_denied);					

			}
	}
										
}

?>